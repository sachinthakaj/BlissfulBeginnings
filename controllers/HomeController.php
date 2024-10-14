<?php

class HomeController {
    public function index() {
        require_once '.\views\Home.php';
    }
    public function register() {
        require_once '.\views\Register.php';
    }

    public function signIn() {
        require_once '.\views\CustomerSignIn.php';
    }

    public function createAccount() {
        require_once '.\views\CreateAnAccount.php';
    }

    public function vendorNewWeddingDashboard() {
        require_once '.\views\VendorNewWeddingDashboard.php';
    }

    public function vendorSignIn() {
        require_once '.\views\VendorSignIn.php';
    }

    public function vendorWeddingDashboard() {
        require_once '.\views\VendorWeddingDashboard.php';
    }

}

