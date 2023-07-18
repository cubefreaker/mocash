<?php
require './config/database.php';

class Home {
    protected $db;

    function __construct() {
        $this->db = new DB();
    }

    public function index() {
        include './views/home_page/home.php';
    }
}