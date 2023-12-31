<?php
require './models/AdminModel.php';
use Dompdf\Dompdf;
class Admin {

    protected $model;
    protected $user;
    protected $cart;
    protected $flash_message;

    function __construct() {
        if(!isset($_SESSION)) {
            session_start();
        }

        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $this->model = new AdminModel($this->user);

        if(!$this->user) {
            header('Location: /admin/login');
        }

        $this->cart = $this->model->getCartActive($this->user['id']);

        $this->flash_message = [
            'success' => isset($_SESSION['flash_message_success']) ? $_SESSION['flash_message_success'] : '',
            'warning' => isset($_SESSION['flash_message_warning']) ? $_SESSION['flash_message_warning'] : '',
            'error' => isset($_SESSION['flash_message_error']) ? $_SESSION['flash_message_error'] : '',
            'info' => isset($_SESSION['flash_message_info']) ? $_SESSION['flash_message_info'] : '',
        ];
        unset($_SESSION['flash_message_success']);
        unset($_SESSION['flash_message_warning']);
        unset($_SESSION['flash_message_error']);
        unset($_SESSION['flash_message_info']);
    }

    public function index() {
        if(!in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) {
            header('Location: /admin/product/gallery');
            return;
        }

        $totalSales = $this->model->getTotalSales();
        $dataDashboard = [
            'totalUser' => count($this->model->getListUser()),
            'totalProduct' => count($this->model->getListProduct()),
            'totalProductSold' => $totalSales ? $totalSales['total_produk'] : 0,
            'totalOrder' => count($this->model->getListCart('Done')),
            'totalSales' => $totalSales ? $totalSales['total_harga'] : 0,
            'totalCompany' => count($this->model->getListCompany()),
        ];

        $salesProductChart = $this->model->getSalesProductChart(date('Y'));
        $salesProductChartLastYear = $this->model->getSalesProductChart(date('Y') - 1);
        $dataChart = [
            'salesChart' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'],
                'sales' => $salesProductChart['sales'],
                'salesLastYear' => $salesProductChartLastYear['sales'],
            ],
            'productsChart' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'],
                'products' => $salesProductChart['product'],
                'productsLastYear' => $salesProductChartLastYear['product'],
            ],
        ];
        
        require './views/admin_page/dashboard.php';
    }

    // User
    public function usersPage() {
        $listUser = $this->model->getListUser();
        require './views/admin_page/users/users.php';
    }

    public function userAddPage() {
        if(!in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) {
            header('Location: /admin/product/gallery');
            return;
        }

        require './views/admin_page/users/user_add.php';
    }

    public function userAdd() {
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $cabang = isset($_POST['cabang']) ? $_POST['cabang'] : '';
        $company = isset($_POST['company']) ? $_POST['company'] : '';
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : '';

        if(!$fullname || !$email || !$password || !$role) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah user: Data tidak lengkap';
            header('Location: /admin/user/add');
            return;
        }

        $checkUser = $this->model->getUserByEmail($email);
        if($checkUser) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah user: Email sudah terdaftar';
            header('Location: /admin/user/add');
            return;
        }

        $dataInsert = [
            'fullname' => addslashes($fullname),
            'email' => $email,
            'password' => $password,
            'cabang' => addslashes($cabang),
            'company' => addslashes($company),
            'alamat' => addslashes($alamat),
            'role' => $role,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->user['email'],
        ];        

        if($this->model->addUser($dataInsert)) {
            $_SESSION['flash_message_success'] = 'Berhasil tambah user';
            header('Location: /admin/users');
            return;
        } else {
            $_SESSION['flash_message_error'] = 'Gagal tambah user';
            header('Location: /admin/user/add');
            return;
        }
    }

    public function userEditPage() {
        if(!in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) {
            header('Location: /admin/product/gallery');
            return;
        }

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $user = $id ? $this->model->getUser($id) : '';

        if(!$id || !$user) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit user: User tidak ditemukan';
            header('Location: /admin/users');
            return;
        }

        require './views/admin_page/users/user_edit.php';
    }

    public function userEdit() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $cabang = isset($_POST['cabang']) ? $_POST['cabang'] : '';
        $company = isset($_POST['company']) ? $_POST['company'] : '';
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : '';

        if(!$id || !$fullname || !$email || !$role) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit user: Data tidak lengkap';
            header('Location: /admin/user/edit?id='.$id);
            return;
        }

        $checkUser = $this->model->getUserByEmail($email);
        if($checkUser && $checkUser['id'] != $id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit user: Email sudah terdaftar';
            header('Location: /admin/user/edit?id='.$id);
            return;
        }

        $dataUpdate = [
            'fullname' => addslashes($fullname),
            'email' => $email,
            'cabang' => addslashes($cabang),
            'company' => addslashes($company),
            'alamat' => addslashes($alamat),
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user['email'],
        ];

        if($password) {
            $dataUpdate['password'] = $password;
        }

        if($this->model->editUser($id, $dataUpdate)) {
            $_SESSION['flash_message_success'] = 'Berhasil edit user';
            header('Location: /admin/users');
            return;
        } else {
            $_SESSION['flash_message_error'] = 'Gagal edit user';
            header('Location: /admin/user/edit?id='.$id);
            return;
        }
    }

    public function userDelete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        if(!$id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa hapus user: User tidak ditemukan';
            header('Location: /admin/users');
            return;
        }

        if($this->model->deleteUser($id)) {
            $_SESSION['flash_message_success'] = 'Berhasil hapus user';
        } else {
            $_SESSION['flash_message_error'] = 'Gagal hapus user';
        }
        header('Location: /admin/users');
        return;
    }

    // Product
    public function productGalleryPage() {
        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Populer';
        $listProduct = $this->model->getListProduct($kategori);
        require './views/admin_page/products/product_gallery.php';
    }

    public function productsPage() {
        $listProduct = $this->model->getListProduct();
        require './views/admin_page/products/products.php';
    }

    public function productAddPage() {
        if(!in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) {
            header('Location: /admin/product/gallery');
            return;
        }
        
        $listCompany = $this->model->getListCompany();
        require './views/admin_page/products/product_add.php';
    }

    public function productAdd() {
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $harga = isset($_POST['harga']) ? $_POST['harga'] : 0;
        $stok = isset($_POST['stok']) ? $_POST['stok'] : 0;
        $company = isset($_POST['company']) ? $_POST['company'] : '';
        $imageFile = isset($_FILES['image']) ? $_FILES['image'] : '';

        if(!$nama || !$kategori || !$harga || !$stok || !$company) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah produk: Data tidak lengkap';
            header('Location: /admin/product/add');
            return;
        }

        $checkProduct = $this->model->getProductByName($nama);
        if($checkProduct) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah produk: Produk sudah terdaftar';
            header('Location: /admin/product/add');
            return;
        }

        $dataInsert = [
            'nama' => addslashes($nama),
            'kategori' => $kategori,
            'harga' => $harga,
            'stok' => $stok,
            'company' => addslashes($company),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->user['email'],
        ];        
        
        $insertId = $this->model->addProduct($dataInsert);
        if($insertId) {
            if($imageFile) {
                // Create a direcotry if not exists
                if (!file_exists('./assets/image/products/')) {
                    mkdir('./assets/image/products/', 0777, true);
                }
                
                // Save image
                $imageName = $insertId.'_'.$imageFile['name'];
                $moveImage = move_uploaded_file($imageFile['tmp_name'], './assets/image/products/'.$imageName);

                // Update image name in database
                if($moveImage) {
                    $this->model->editProduct($insertId, ['image' => $imageName]);
                }
            }

            $_SESSION['flash_message_success'] = 'Berhasil tambah produk';
            header('Location: /admin/products');
            return;
        } else {
            $_SESSION['flash_message_error'] = 'Gagal tambah produk';
            header('Location: /admin/product/add');
            return;
        }
    }

    public function productEditPage() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $product = $id ? $this->model->getProduct($id) : '';

        if(!$id || !$product) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit: Produk tidak ditemukan';
            header('Location: /admin/products');
            return;
        }

        $listCompany = $this->model->getListCompany();
        require './views/admin_page/products/product_edit.php';
    }

    public function productEdit() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $harga = isset($_POST['harga']) ? $_POST['harga'] : 0;
        $stok = isset($_POST['stok']) ? $_POST['stok'] : 0;
        $company = isset($_POST['company']) ? $_POST['company'] : '';
        $imageOldName = isset($_POST['imageOldName']) ? $_POST['imageOldName'] : '';
        $imageFile = isset($_FILES['image']) ? $_FILES['image'] : '';
        
        if(!$id || !$nama || !$kategori || !$harga || !$company) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit produk: Data tidak lengkap';
            header('Location: /admin/product/edit?id='.$id);
            return;
        }

        $checkProduct = $this->model->getProductByName($nama);
        if($checkProduct && $checkProduct['id'] != $id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit produk: Produk sudah terdaftar';
            header('Location: /admin/product/edit?id='.$id);
            return;
        }

        $dataUpdate = [
            'nama' => addslashes($nama),
            'kategori' => $kategori,
            'harga' => $harga,
            'stok' => $stok,
            'company' => addslashes($company),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user['email'],
        ];

        if($this->model->editProduct($id, $dataUpdate)) {
            if($imageFile) {
                // Create a direcotry if not exists
                if (!file_exists('./assets/image/products/')) {
                    mkdir('./assets/image/products/', 0777, true);
                }
                
                // Save image
                $imageName = $id.'_'.$imageFile['name'];
                $moveImage = move_uploaded_file($imageFile['tmp_name'], './assets/image/products/'.$imageName);

                // Update image name in database
                if($moveImage) {
                    $this->model->editProduct($id, ['image' => $imageName]);
                    unlink('./assets/image/products/'.$imageOldName);
                }
            }

            $_SESSION['flash_message_success'] = 'Berhasil edit produk';
            header('Location: /admin/products');
            return;
        } else {
            $_SESSION['flash_message_error'] = 'Gagal edit produk';
            header('Location: /admin/product/edit?id='.$id);
            return;
        }
    }

    public function productDelete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $dataProduct = $id ? $this->model->getProduct($id) : '';

        if(!$id || !$dataProduct) {
            $_SESSION['flash_message_error'] = 'Tidak bisa hapus produk: Produk tidak ditemukan';
            header('Location: /admin/products');
            return;
        }

        if($this->model->deleteProduct($id)) {
            unlink('./assets/image/products/'.$dataProduct['image']);
            $_SESSION['flash_message_success'] = 'Berhasil hapus produk';
        } else {
            $_SESSION['flash_message_error'] = 'Gagal hapus produk';
        }

        header('Location: /admin/products');
        return;
    }

    // Cart
    public function cartPage() {
        require './views/admin_page/products/product_cart.php';
    }

    public function cartAdd() {
        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Populer';
        $productId = isset($_GET['id']) ? $_GET['id'] : '';
        $cartId = isset($_GET['cart_id']) ? $_GET['cart_id'] : '';
        $price = isset($_GET['price']) ? $_GET['price'] : 0;

        if(!$cartId) {
            $cartId = $this->model->addCart($this->user['id'], $this->user['email']);
        }

        if(!$productId || !$cartId) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah produk ke keranjang: Produk tidak ditemukan';
            header('Location: /admin/product/gallery?kategori='.$kategori);
            return;
        }

        if($this->model->addProductToCart($this->user, $cartId, $productId, $price)) {
            $totalProductInCart = $this->model->getTotalProductInCart($cartId);
            $this->model->updateCart($cartId, [
                'total_produk' => $totalProductInCart['total_produk'],
                'total_harga' => $totalProductInCart['total_harga'],
            ]);
            $this->model->minProductStock($productId, 1);
            $_SESSION['flash_message_success'] = 'Berhasil tambah produk ke keranjang';
        } else {
            $_SESSION['flash_message_error'] = 'Gagal tambah produk ke keranjang';
        }

        header('Location: /admin/product/gallery?kategori='.$kategori);
        return;
    }

    public function cartDeleteDetail() {
        $cartDetailId = isset($_GET['id']) ? $_GET['id'] : '';

        $cartDetail = $this->model->getDetailCart($cartDetailId);
        $cart = $cartDetail ? $this->model->getCart($cartDetail['id_cart']) : '';

        if(!$cartDetailId || !$cartDetail || !$cart) {
            $_SESSION['flash_message_error'] = 'Tidak bisa hapus produk dari keranjang: Produk tidak ditemukan';
            header('Location: /admin/product/cart');
            return;
        }

        if($this->model->deleteCartDetail($cartDetailId)) {
            $this->model->updateCart($cartDetail['id_cart'], [
                'total_produk' => $cart['total_produk'] - $cartDetail['jumlah'],
                'total_harga' => $cart['total_harga'] - $cartDetail['harga'],
            ]);
            $this->model->plusProductStock($cartDetail['id_product'], $cartDetail['jumlah']);
            $_SESSION['flash_message_success'] = 'Berhasil hapus produk dari keranjang';
        } else {
            $_SESSION['flash_message_error'] = 'Gagal hapus produk dari keranjang';
        }

        header('Location: /admin/product/cart');
        return;
    }

    public function cartCancel() {
        $cartId = isset($_GET['id']) ? $_GET['id'] : '';

        if(!$cartId) {
            $_SESSION['flash_message_error'] = 'Tidak bisa hapus keranjang: Keranjang tidak ditemukan';
            header('Location: /admin/product/gallery');
            return;
        }

        if($this->model->updateCart($cartId, [ 'waktu_selesai' => date('Y-m-d H:i:s'), 'status' => 'Cancel' ])) {
            $_SESSION['flash_message_success'] = 'Berhasil cancel keranjang';
            foreach($this->cart['detail'] as $detail) {
                $this->model->plusProductStock($detail['id_product'], $detail['jumlah']);
            }
        } else {
            $_SESSION['flash_message_error'] = 'Gagal cancel keranjang';
        }

        header('Location: /admin/product/gallery');
        return;
    }

    public function cartCheckout(){
        $this->cart['pembayaran'] = isset($_POST['pembayaran']) ? $_POST['pembayaran'] : 0;
        
        if(!$this->cart['pembayaran']) {
            $_SESSION['flash_message_error'] = 'Tidak bisa checkout: Harap Isi Nominal Pembayaran';
            header('Location: /admin/product/cart');
            return;
        } else if($this->cart['pembayaran'] < $this->cart['total_harga']) {
            $_SESSION['flash_message_error'] = 'Tidak bisa checkout: Nominal Pembayaran Kurang';
            header('Location: /admin/product/cart');
            return;
        }

        if(!isset($this->cart['id'])) {
            $_SESSION['flash_message_error'] = 'Tidak bisa checkout: Keranjang tidak ditemukan';
            header('Location: /admin/product/cart');
            return;
        }

        $this->cart['sisa_pembayaran'] = $this->cart['pembayaran'] - $this->cart['total_harga'];

        $updateCart = $this->model->updateCart($this->cart['id'], [
            'pembayaran' => $this->cart['pembayaran'], 
            'sisa_pembayaran' => $this->cart['sisa_pembayaran'],
            'waktu_selesai' => date('Y-m-d H:i:s'), 
            'status' => 'Done' 
        ]);

        if($updateCart) {
            $_SESSION['flash_message_success'] = 'Berhasil checkout';
            $this->printBill();
        } else {
            $_SESSION['flash_message_error'] = 'Gagal checkout';
            header('Location: /admin/product/cart');
            return;
        }
    }

    // Printout Bill
    public function printBill() {
        ob_start();
        include './views/admin_page/products/printout_bill.php';
        $html = ob_get_clean();

        $contentHeight = $this->getBillContentHeight($html);
        
        $dompdf = new Dompdf();
        $dompdf->setPaper([0, 0, 141.732, 141.732 * $contentHeight], 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();

        if(!file_exists('./assets/bill/')) {
            mkdir('./assets/bill/', 0777, true);
        }

        $billName = "bill_.{$this->cart['id']}.pdf";
        // Save PDF file
        file_put_contents("./assets/bill/$billName", $dompdf->output());
        
        // Output the generated PDF to Browser
        $dompdf->stream($billName, ['Attachment' => 0]);
    }

    public function getBillContentHeight($html) {
        $dompdf = new Dompdf();
        $dompdf->setPaper([0, 0, 141.732, 141.732], 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();
        $pageCount = $dompdf->getCanvas()->get_page_number();
        unset($dompdf);
        return $pageCount;
    }

    // Sales
    public function salesPage() {
        $listCart = $this->model->getListCart();
        require './views/admin_page/sales/sales.php';
    }

    public function salesDetailPage() {
        $cartId = isset($_GET['id']) ? $_GET['id'] : '';
        $cart = $cartId ? $this->model->getCart($cartId) : '';

        if(!$cartId || !$cart) {
            $_SESSION['flash_message_error'] = 'Tidak bisa lihat detail: penjualan tidak ditemukan';
            header('Location: /admin/product/sales');
            return;
        }

        $cart['detail'] = $this->model->getCartDetail($cartId);

        require './views/admin_page/sales/sales_detail.php';
    }

}