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

    public function salons() {
        require_once '.\public\Salons.php';
    }

    public function dressDesigners() {
        require_once '.\public\DressDesigners.php';
    }

    public function photographers() {
        require_once '.\public\Photographers.php';
    }

    public function florists() {
        require_once '.\public\Florists.php';
    }
}

