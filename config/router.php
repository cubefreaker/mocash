<?php

$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

switch ($request) {
    case '':
    case '/':
        require './controllers/HomeController.php';
        $home = new Home();
        $home->index();
        break;

    case '/admin':
    case '/admin/dashboard':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->index();
        break;
    
    case '/admin/login':
        require './controllers/LoginController.php';
        $login = new Login();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login->login();
        } else {
            $login->index();
        }
        break;
    
    case '/admin/logout':
        require './controllers/LoginController.php';
        $login = new Login();
        $login->logout();
        break;
    

    case '/admin/users':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->usersPage();
        break;
    
    case '/admin/user/add':
        require './controllers/AdminController.php';
        $admin = new Admin();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $admin->userAdd();
        } else {
            $admin->userAddPage();
        }
        break;
    
    case '/admin/user/edit':
        require './controllers/AdminController.php';
        $admin = new Admin();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $admin->userEdit();
        } else {
            $admin->userEditPage();
        }
        break;
    
    case '/admin/user/delete':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->userDelete();
        break;
    
    case '/admin/product/gallery':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->productGalleryPage();
        break;

    case '/admin/product/cart':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->productCartPage();
        break;

    case '/admin/product/addCart':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->productAddCart();
        break;

    case '/admin/products':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->productsPage();
        break;
    
    case '/admin/product/add':
        require './controllers/AdminController.php';
        $admin = new Admin();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $admin->productAdd();
        } else {
            $admin->productAddPage();
        }
        break;
    
    case '/admin/product/edit':
        require './controllers/AdminController.php';
        $admin = new Admin();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $admin->productEdit();
        } else {
            $admin->productEditPage();
        }
        break;

    case '/admin/product/delete':
        require './controllers/AdminController.php';
        $admin = new Admin();
        $admin->productDelete();
        break;

    default:
        echo '404 Not Found';
        break;
}