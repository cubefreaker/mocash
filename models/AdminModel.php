<?php
require './config/database.php';

class AdminModel {
    protected $db;
    protected $userCondition;

    function __construct($user = null) {
        $this->db = new DB();
        $this->userCondition = $user ? [
            'id' => $user['id'],
            'role' => addslashes($user['role']),
            'company' => addslashes($user['company']),
            'cabang' => addslashes($user['cabang']),
        ] : null;
    }

    // Login
    function getLoginUser($email, $password) {
        return $this->db->from('tb_user')->where("email = '$email' AND password = '$password'")->getOne();
    }

    // Company
    function getListCompany() {
        if($this->userCondition) {
            if(!$this->userCondition['role'] == 'Owner') {
                $this->db->where("company = '{$this->userCondition['company']}'");
            }
        }
        
        return $this->db->select('company')->where('company != "" AND company IS NOT NULL')->from('tb_user')->groupBy('company')->get();
    }

    //User
    function getListUser() {
        if($this->userCondition) {
            if(!in_array($this->userCondition['role'], ['Owner', 'Super Admin', 'Admin'])) {
                $this->db->where('FALSE');
            } else if($this->userCondition['role'] == 'Super Admin') {
                $this->db->where("company = '{$this->userCondition['company']}'");
            } else if($this->userCondition['role'] == 'Admin') {
                $this->db->where("company = '{$this->userCondition['company']}' AND cabang = '{$this->userCondition['cabang']}'");
            }
        }

        return $this->db->from('tb_user')->get();
    }

    function getUser($id) {
        return $this->db->from('tb_user')->where("id = $id")->getOne();
    }

    function getUserByEmail($email) {
        return $this->db->from('tb_user')->where("email = '$email'")->getOne();
    }

    function addUser($data) {
        return $this->db->insert('tb_user', $data);
    }

    function editUser($id, $data) {
        return $this->db->where("id = $id")->update('tb_user', $data);
    }

    function deleteUser($id) {
        return $this->db->where("id = $id")->delete('tb_user');
    }

    // Product
    function getListProduct($kategori = null) {
        if($this->userCondition) {
            if($this->userCondition['role'] != 'Owner') {
                $this->db->where("tb_product.company = '{$this->userCondition['company']}'");
            }
        }

        if($kategori) {
            if(strtolower($kategori) == 'populer') {
                return $this->db->select('tb_product.*')->from('tb_product')->join('INNER JOIN tb_cart_detail ON tb_cart_detail.id_product = tb_product.id')->groupBy('tb_product.id')->orderBy('SUM(tb_cart_detail.jumlah) DESC')->limit(10)->get();
            } else {
                return $this->db->from('tb_product')->where("kategori = '$kategori'")->get();
            }
        } else {
            return $this->db->from('tb_product')->get();
        }
    }

    function getProduct($id) {
        return $this->db->from('tb_product')->where("id = $id")->getOne();
    }

    function getProductByName($nama) {
        return $this->db->from('tb_product')->where("nama = '$nama'")->getOne();
    }

    function addProduct($data) {
        return $this->db->insert('tb_product', $data);
    }

    function editProduct($id, $data) {
        return $this->db->where("id = $id")->update('tb_product', $data);
    }

    function deleteProduct($id) {
        return $this->db->where("id = $id")->delete('tb_product');
    }

    // Cart
    function getListCart($status = null) {
        if($this->userCondition) {
            if(!in_array($this->userCondition['role'], ['Owner', 'Super Admin', 'Admin'])) {
                $this->db->where('FALSE');
            } else if($this->userCondition['role'] == 'Super Admin') {
                $this->db->where("company = '{$this->userCondition['company']}'");
            } else if($this->userCondition['role'] == 'Admin') {
                $this->db->where("company = '{$this->userCondition['company']}' AND cabang = '{$this->userCondition['cabang']}'");
            }
        }

        if($status) {
            $this->db->where("status = '$status'");
        }

        return $this->db->from('tb_cart')->get();
    }

    function getCartActive($userId) {
        $cart = $this->db->from('tb_cart')->where("user_id = $userId AND status = 'Pending'")->getOne();
        $cart['detail'] = $cart ? $this->db->from('tb_cart_detail')->where("id_cart = {$cart['id']}")->get() : [];
        return $cart;
    }

    function addCart($userId, $userEmail) {
        return $this->db->insert('tb_cart', [
            'user_id' => $userId,
            'user_email' => $userEmail,
            'status' => 'Pending',
        ]);
    }

    function updateCart($id, $data) {
        return $this->db->where("id = $id")->update('tb_cart', $data);
    }

    function getTotalProductInCart($cartId) {
        return $this->db->select('SUM(jumlah) as total_produk, SUM(harga) as total_harga')->from('tb_cart_detail')->groupBy('id_cart')->where("id_cart = $cartId")->getOne();
    }

    function addProductToCart($user, $cartId, $productId, $price) {
        $checkProduct = $this->db->from('tb_cart_detail')->where("id_cart = $cartId AND id_product = $productId")->getOne();
        
        if($checkProduct) {
            return $this->db->where("id_cart = $cartId AND id_product = $productId")->update('tb_cart_detail', [
                'jumlah' => $checkProduct['jumlah'] + 1,
                'harga' => $checkProduct['harga'] + $price,
            ]);
        } else {
            return $this->db->insert('tb_cart_detail', [
                'id_cart' => $cartId,
                'id_product' => $productId,
                'jumlah' => 1,
                'harga' => $price,
                'company' => $this->userCondition ? $this->userCondition['company'] : null,
                'cabang' => $this->userCondition ? $this->userCondition['cabang'] : null,
            ]);
        }
    }

    function minProductStock($id, $count) {
        $currentStock = $this->db->select('stok')->from('tb_product')->where("id = $id")->getOne();
        if($currentStock) {
            return $this->db->where("id = $id")->update('tb_product', [
                'stok' => $currentStock['stok'] - $count
            ]);
        } else {
            return false;
        }
    }

    function plusProductStock($id, $count) {
        $currentStock = $this->db->select('stock')->from('tb_product')->where("id = $id")->getOne();
        if($currentStock) {
            return $this->db->where("id = $id")->update('tb_product', [
                'stock' => $currentStock['stock'] + $count
            ]);
        } else {
            return false;
        }
    }
}