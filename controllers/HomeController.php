<?php

class HomeController {
    public function index() {
        require_once '.\public\Home.php';
    }
    public function register() {
        require_once '.\public\Register.php';
    }

    public function signIn() {
        require_once '.\public\CustomerSignIn.php';
    }

    public function createAccount() {
        require_once '.\public\CreateAnAccount.php';
    }
}

