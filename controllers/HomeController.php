<?php

class HomeController {
    public function index() {
        require_once '.\public\Index.html';
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

    public function about() {
        require_once '.\public\About.html';
    }

    public function contact() {
        require_once '.\public\Contact.html';
    }

    public function services() {
        require_once '.\public\Services.html';
    }
}

