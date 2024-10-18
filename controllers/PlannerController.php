<?php

class PlannerController
{
    private $plannerModel;

    public function __construct()
    {
        $this->plannerModel=new planner();
    }

    public function registerAsVendor()
    {
        $data = file_get_contents('php://input');

        $parsed_data = json_decode($data,true);

        $email=$parsed_data['email'];
        $password=$parsed_data['password'];
        $businessName=$parsed_data['businessName'];
        $type=$parsed_data['type'];
        $contact=$parsed_data['contact'];
        $address=$parsed_data['address'];
        $bankAcc=$parsed_data['bankAcc'];

        if(empty($email)||empty($password)||empty($businessName)||empty($type)||empty($contact)||empty($address)||empty($bankAcc)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'All details are required']);
            return;
        }

        $hashedPassword = password_hash($password,PASSWORD_BCRYPT);

        if(($vendorID=$this->vendorModel->createVendor($email,$hashedPassword,$businessName,$type,$contact,$address,$bankAcc))){

            session_start();
            $_SESSION['email']=$email;
            $_SESSION['logged_in']=true;
            $_SESSION['vendorID']=$vendorID;

            header('Content-Type: application/json; charset=utf-8');
            error_log("Create a vendor");
            error_log(json_encode(['message' => 'Vendor Registration successful']));
            echo json_encode(['message' => 'Vendor Registration successful']);

        }

        else{
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Vendor Registration failed']);
        }
    }


    public function login(){
        $data = file_get_contents('php://input');
        $parsed_data = json_decode($data,true);
        $email=$parsed_data['email'];
        $password=$parsed_data['password'];

        if(empty($email) || empty($password)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Email and password are required']);
            return ;
        }

        $vendor=$this->vendorModel->getVendorByEmail($email);
        if(!$vendor){
            header('HTTP/1.1 401 Unathorized');
            echo json_encode(['error'=>'Invalid credentials']);
            return;
        }

        if(!password_verify($password,$vendor['password'])){
            header('HTTP/1.1 401 Unathorized');
            echo json_encode(['error'=>'Invalid credentials']);
            return;
        }

        session_start();
        $_SESSION['email']=$vendor['email'];
        $_SESSION['logged_in']=true;

        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(['message' => 'Login Successful']);
    }


}