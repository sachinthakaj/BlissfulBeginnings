<?php

class vendorController
{
    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new vendor();
    }
    public function editProfilePage()
    {
        require_once '.\public\editProfile.html';
    }

    public function editProfile()
    {
        $data = [
            'name' => "Trident Media",
            'type' => "Photographer",
            'description' => "Trident Media is a premier wedding photography studio that specializes in transforming your special day into timeless memories. With a keen eye for detail and a passion for storytelling, Trident Media's team of professional photographers ensures that every candid smile, heartfelt glance, and cherished moment is beautifully captured.",
            'image' => "/public/assets/images/camera_1361782 1.png",
            'packages' => [
                "123145678987654321" =>[
                    'packageName' => 'Package 1',
                    'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
                    'price' => '$99.99',
                    'state' => 'published',
                    'fixedCost' => 10000,
                    'cameraCoverage' => 1
                ],
                "123145678987654322" => [
                    'packageName' => 'Package 2',
                    'features' => ['Feature 4', 'Feature 5', 'Feature 6'],
                    'price' => '$149.99',
                    'state' => 'unpublished',
                    'fixedCost' => 10000,
                    'cameraCoverage' => 2
                ],
                "123145678987654323" => [
                    'packageName' => 'Package 3',
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
