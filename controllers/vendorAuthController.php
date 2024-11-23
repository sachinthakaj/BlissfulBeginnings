<?php

class vendorAuthController
{
    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new vendor();
    }

    public function SignInPage()
    {
        require_once './public/VendorSignIn.php';
    }

    public function Register()
    {
        require_once './public/JoinOurNetwork.php';
    }
    public function VendorDash()
    {
        require_once './public/VendorDash.html';
    }


    public function registerAsVendor()
    {
        try {
            $data = file_get_contents('php://input');

            $parsed_data = json_decode($data, true);

            $email = $parsed_data['email'];
            $password = $parsed_data['password'];
            $businessName = $parsed_data['businessName'];
            $type = $parsed_data['type'];
            $contact = $parsed_data['contact'];
            $address = $parsed_data['address'];
            $description = $parsed_data['description'];

            if (empty($email) || empty($password) || empty($businessName) || empty($type) || empty($contact) || empty($address) || empty($description)) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'All details are required']);
                return;
            }
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            if (($vendorID = $this->vendorModel->createVendor($email, $hashedPassword, $businessName, $type, $contact, $address, $description))) {
                
                error_log("Something");
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['logged_in'] = true;
                $_SESSION['vendorID'] = $vendorID;

                header('Content-Type: application/json; charset=utf-8');
                error_log("Create a vendor");
                echo json_encode([
                    'vendorID' => $vendorID,
                    'message' => 'Vendor Registration successful'
                ]);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Vendor Registration failed']);
            }
        } catch (Exception $e) {
            echo $e;
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Vendor Registration failed']);
        }
    }


    public function login()
    {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $email = $parsed_data['email'];
            $password = $parsed_data['password'];
    
            if (empty($email) || empty($password)) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Email and password are required']);
                return;
            }
    
            $vendor = $this->vendorModel->getVendorByEmail($email);
            if (!$vendor) {
                header('HTTP/1.1 401 Unathorized');
                echo json_encode(['error' => 'Invalid credentials']);
                return;
            }
    
            if (!password_verify($password, $vendor['password'])) {
                header('HTTP/1.1 401 Unathorized');
                echo json_encode(['error' => 'Invalid credentials']);
                return;
            }
    
            session_start();
            $_SESSION['email'] = $vendor['email'];
            $_SESSION['logged_in'] = true;
    
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(['message' => 'Login Successful']);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => "$e"]);
        }
       
    }
}
