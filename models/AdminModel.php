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
            if($this->userCondition['role'] != 'Owner') {
                $this->db->where("role != 'Owner' AND company = '{$this->userCondition['company']}'");
            }
        }
        
        return $this->db->select('company')->where('company != "" AND company IS NOT NULL')->from('tb_user')->groupBy('company')->get();
    }

    //User
    function getListUser($role = null) {
        if($this->userCondition) {
            if(!in_array($this->userCondition['role'], ['Owner', 'Super Admin', 'Admin'])) {
                $this->db->where('FALSE');
            } else if($this->userCondition['role'] == 'Super Admin') {
                $this->db->where("role != 'Owner' AND company = '{$this->userCondition['company']}'");
            } else if($this->userCondition['role'] == 'Admin') {
                $this->db->where("role != 'Owner' AND company = '{$this->userCondition['company']}' AND cabang = '{$this->userCondition['cabang']}'");
            }
        }

        if($role) {
            $this->db->where("role = '$role'");
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
        
        if($cart) {
            $cart['detail'] = $this->getCartDetail($cart['id']);
        } else {
            $cart['detail'] = [];
        }

        return $cart;
    }

    function getCartDetail($cartId) {
        return $this->db->select('tb_cart_detail.id, tb_cart_detail.id_product, tb_product.nama, tb_product.harga, tb_cart_detail.jumlah, tb_cart_detail.harga AS total')->from('tb_cart_detail')->join('INNER JOIN tb_product ON tb_product.id=id_product')->where("id_cart = $cartId")->get();
    }

    function getDetailCart($cartDetailId) {
        return $this->db->from('tb_cart_detail')->where("id = $cartDetailId")->getOne();
    }

    function getCart($cartId) {
        return $this->db->from('tb_cart')->where("id = $cartId")->getOne();
    }

    function addCart($userId, $userEmail) {
        return $this->db->insert('tb_cart', [
            'user_id' => $userId,
            'user_email' => $userEmail,
            'status' => 'Pending',
            'company' => $this->userCondition ? $this->userCondition['company'] : null,
            'cabang' => $this->userCondition ? $this->userCondition['cabang'] : null,
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

    function deleteCartDetail($id) {
        return $this->db->where("id = $id")->delete('tb_cart_detail');
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
        $currentStock = $this->db->select('stok')->from('tb_product')->where("id = $id")->getOne();
        if($currentStock) {
            return $this->db->where("id = $id")->update('tb_product', [
                'stok' => $currentStock['stok'] + $count
            ]);
        } else {
            return false;
        }
    }

    // Summary
    function getTotalSales() {
        if($this->userCondition) {
            if(!in_array($this->userCondition['role'], ['Owner', 'Super Admin', 'Admin'])) {
                $this->db->where('FALSE');
            } else if($this->userCondition['role'] == 'Super Admin') {
                $this->db->where("company = '{$this->userCondition['company']}'");
            } else if($this->userCondition['role'] == 'Admin') {
                $this->db->where("company = '{$this->userCondition['company']}' AND cabang = '{$this->userCondition['cabang']}'");
            }
        }

        return $this->db->select('SUM(total_produk) as total_produk, SUM(total_harga) as total_harga')->from('tb_cart')->where("status = 'Done'")->getOne();
    }
}