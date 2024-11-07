<?php

class vendorController
{
    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel=new vendor();
    }
    public function editProfilePage()
    {
        require_once '.\public\editProfile.html';
    }



}