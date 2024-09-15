<?php

class HomeController {
    public function index() {
        require_once '.\views\Home.php';
    }
    public function register() {
        require_once '.\views\Register.php';
    }
    public function CustomerSignIn() {
        require_once '.\views\CustomerSignIn.php';
    }
}

