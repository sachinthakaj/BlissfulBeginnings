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

    public function vendorProfilePage($vendorID) {
        require_once '.\public\VendorProfile.html';
    }

    public function vendorProfile($vendorID) {
        $data = [
            'name' => "Trident Media",
            'type' => "Photographer",
            'description' => "Trident Media is a premier wedding photography studio that specializes in transforming your special day into timeless memories. With a keen eye for detail and a passion for storytelling, Trident Media's team of professional photographers ensures that every candid smile, heartfelt glance, and cherished moment is beautifully captured.",
            'image' => "/public/assets/images/camera_1361782 1.png",
            'packages' => [
                "123145678987654321" =>[
                    'name' => 'Package 1',
                    'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
                    'price' => '$99.99',
                    'state' => 'published',
                    'fixedCost' => 10000,
                    'cameraCoverage' => 1
                ],
                "123145678987654322" => [
                    'name' => 'Package 2',
                    'features' => ['Feature 4', 'Feature 5', 'Feature 6'],
                    'price' => '$149.99',
                    'state' => 'unpublished',
                    'fixedCost' => 10000,
                    'cameraCoverage' => 2
                ],
                "123145678987654323" => [
                    'name' => 'Package 3',
                    'features' => ['Feature 4', 'Feature 5', 'Feature 6'],
                    'price' => '$149.99',
                    'state' => 'unapproved',
                    'fixedCost' => 10000,
                    'cameraCoverage' => 1
                ]
            ]
        ];
        echo json_encode($data);
    }

}

