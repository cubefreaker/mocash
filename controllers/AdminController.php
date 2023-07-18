<?php
require './models/AdminModel.php';

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
        } 
        
        require './views/admin_page/dashboard.php';
    }

    public function usersPage() {
        $listUser = $this->model->getListUser();
        require './views/admin_page/users/users.php';
    }

    public function userAddPage() {
        if(!in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) {
            header('Location: /admin/product/gallery');
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
        }

        $checkUser = $this->model->getUserByEmail($email);
        if($checkUser) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah user: Email sudah terdaftar';
            header('Location: /admin/user/add');
        }

        $dataInsert = [
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password,
            'cabang' => $cabang,
            'company' => $company,
            'alamat' => $alamat,
            'role' => $role,
        ];        

        if($this->model->addUser($dataInsert)) {
            $_SESSION['flash_message_success'] = 'Berhasil tambah user';
            header('Location: /admin/users');
        } else {
            $_SESSION['flash_message_error'] = 'Gagal tambah user';
            header('Location: /admin/user/add');
        }
    }

    public function userEditPage() {
        if(!in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) {
            header('Location: /admin/product/gallery');
        }

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $user = $id ? $this->model->getUser($id) : '';

        if(!$id || !$user) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit user: User tidak ditemukan';
            header('Location: /admin/users');
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
        }

        $checkUser = $this->model->getUserByEmail($email);
        if($checkUser && $checkUser['id'] != $id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit user: Email sudah terdaftar';
            header('Location: /admin/user/edit?id='.$id);
        }

        $dataUpdate = [
            'fullname' => $fullname,
            'email' => $email,
            'cabang' => $cabang,
            'company' => $company,
            'alamat' => $alamat,
            'role' => $role,
        ];

        if($password) {
            $dataUpdate['password'] = $password;
        }

        if($this->model->editUser($id, $dataUpdate)) {
            $_SESSION['flash_message_success'] = 'Berhasil edit user';
            header('Location: /admin/users');
        } else {
            $_SESSION['flash_message_error'] = 'Gagal edit user';
            header('Location: /admin/user/edit?id='.$id);
        }
    }

    public function userDelete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        if(!$id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa hapus user: User tidak ditemukan';
            header('Location: /admin/users');
        }

        if($this->model->deleteUser($id)) {
            $_SESSION['flash_message_success'] = 'Berhasil hapus user';
        } else {
            $_SESSION['flash_message_error'] = 'Gagal hapus user';
        }
        header('Location: /admin/users');
    }

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
        }
        
        $listCompany = $this->model->getListCompany();
        require './views/admin_page/products/product_add.php';
    }

    public function productCartPage() {
        require './views/admin_page/products/product_cart.php';
    }

    public function productAdd() {
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $harga = isset($_POST['harga']) ? $_POST['harga'] : 0;
        $stok = isset($_POST['stok']) ? $_POST['stok'] : 0;
        $company = isset($_POST['company']) ? $_POST['company'] : '';

        if(!$nama || !$kategori || !$harga || !$stok || !$company) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah produk: Data tidak lengkap';
            header('Location: /admin/product/add');
        }

        $checkProduct = $this->model->getProductByName($nama);
        if($checkProduct) {
            $_SESSION['flash_message_error'] = 'Tidak bisa tambah produk: Produk sudah terdaftar';
            header('Location: /admin/product/add');
        }

        $dataInsert = [
            'nama' => $nama,
            'kategori' => $kategori,
            'harga' => $harga,
            'stok' => $stok,
            'company' => $company,
        ];        
        
        if($this->model->addProduct($dataInsert)) {
            $_SESSION['flash_message_success'] = 'Berhasil tambah produk';
            header('Location: /admin/products');
        } else {
            $_SESSION['flash_message_error'] = 'Gagal tambah produk';
            header('Location: /admin/product/add');
        }
    }

    public function productEditPage() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $product = $id ? $this->model->getProduct($id) : '';

        if(!$id || !$product) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit: Produk tidak ditemukan';
            header('Location: /admin/products');
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

        if(!$id || !$nama || !$kategori || !$harga || !$company) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit produk: Data tidak lengkap';
            header('Location: /admin/product/edit?id='.$id);
        }

        $checkProduct = $this->model->getProductByName($nama);
        if($checkProduct && $checkProduct['id'] != $id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa edit produk: Produk sudah terdaftar';
            header('Location: /admin/product/edit?id='.$id);
        }

        $dataUpdate = [
            'nama' => $nama,
            'kategori' => $kategori,
            'harga' => $harga,
            'stok' => $stok,
            'company' => $company,
        ];

        if($this->model->editProduct($id, $dataUpdate)) {
            $_SESSION['flash_message_success'] = 'Berhasil edit produk';
            header('Location: /admin/products');
        } else {
            $_SESSION['flash_message_error'] = 'Gagal edit produk';
            header('Location: /admin/product/edit?id='.$id);
        }
    }

    public function productDelete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if(!$id) {
            $_SESSION['flash_message_error'] = 'Tidak bisa hapus produk: Produk tidak ditemukan';
            header('Location: /admin/products');
        }

        if($this->model->deleteProduct($id)) {
            $_SESSION['flash_message_success'] = 'Berhasil hapus produk';
        } else {
            $_SESSION['flash_message_error'] = 'Gagal hapus produk';
        }

        header('Location: /admin/products');
    }

    public function productAddCart() {
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
    }
}