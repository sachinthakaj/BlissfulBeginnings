<?php

class plannerController {
    public function dashboard(){
        require_once './public/plannerDashboard.php';
    }
    public function plannerWedding(){
        require_once './public/plannerWeddingPage.php';
    }
    public function selectPackages(){
        require_once './public/selectPackages.php';
    }
    public function selectPackages_saloon(){
        require_once './public/selectPackages-saloon.php';
    }
    public function selectPackages_dressDesigner(){
        require_once './public/selectPackages-dressDesigner.php';
    }
    public function selectPackages_photographer(){
        require_once './public/selectPackages-photographer.php';
    }
    public function selectPackages_decorator(){
        require_once './public/selectPackages-decorator.php';
    }
}