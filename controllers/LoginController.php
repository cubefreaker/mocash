<?php
require './models/AdminModel.php';

class Login {
    protected $model;
    protected $user;
    protected $flash_message;

    function __construct() {
        if(!isset($_SESSION)) {
            session_start();
        }
        
        $this->model = new AdminModel();
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

        if($this->user) {
            header('Location: /admin');
        }

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
        include './views/login.php';
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->model->getLoginUser($email, $password);
        
        if($user) {
            $_SESSION['user'] = $user;
            $_SESSION['flash_message_success'] = 'Login berhasil';
            header('Location: /admin');
        } else {
            $_SESSION['flash_message_error'] = 'Email atau password salah';
            header('Location: /admin/login');
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        $_SESSION['flash_message_success'] = 'Logout berhasil';
        header('Location: /admin/login');
    }
}