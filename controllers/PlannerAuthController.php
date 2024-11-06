<?php

class PlannerAuthController
{
    private $plannerModel;

    public function __construct()
    {
        $this->plannerModel=new Planner();
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

        $planner=$this->plannerModel->getPlannerByEmail($email);
        if(!$planner){
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error'=>'Invalid credentials']);
            return;
        }

        if(!password_verify($password,$planner->password)){
            header('HTTP/1.1 401 Unathorized');
            echo json_encode(['error'=>'Invalid credentials']);
            return;
        }

        session_start();
        $_SESSION['email']=$planner->email;
        $_SESSION['logged_in']=true;

        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(['message' => 'Login Successful']);
    }
}