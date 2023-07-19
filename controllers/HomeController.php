<?php
require './config/database.php';

class Home {
    protected $db;

    function __construct() {
        $this->db = new DB();
    }

    public function index() {
        include './views/home_page/welcome.php';
    }

    public function homePage() {
        include './views/home_page/home.php';
    }

    public function aboutPage() {
        include './views/home_page/about.php';
    }

    public function contactPage() {
        include './views/home_page/contact.php';
    }

    public function productPage() {
        include './views/home_page/product.php';
    }

    public function profilePage() {
        include './views/home_page/profile.php';
    }
}