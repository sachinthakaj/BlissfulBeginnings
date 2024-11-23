<?php

class PlannerHomeController {

    public function signIn() {
        require_once '.\public\PlannerSignIn.php';
    }
    public function salonsList() {
        require_once '.\public\planner-salonList.html';
    }

    public function dressDesignersList() {
        require_once '.\public\planner-dressDesignerList.html';
    }

    public function photographersList() {
        require_once '.\public\planner-photographerList.html';
    }

    public function floristsList() {
        require_once '.\public\planner-floristList.html';
    }


}

