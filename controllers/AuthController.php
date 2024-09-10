<?php
// Include necessary files
require_once './models/User'; // Adjust the path to where your User model is located

class AuthController {

    private $userModel;

    public function __construct() {
        // Initialize the User model
        $this->userModel = new User();
    }

    public function register() {
        // Get the data from the POST request
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // Validate the input
        if (empty($email) || empty($password)) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Email and password are required']);
            return;
        }

        // Check if the email is already registered
        if ($this->userModel->emailExists($email)) {
            header('HTTP/1.1 409 Conflict');
            echo json_encode(['error' => 'Email is already registered']);
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Create a new user
        if ($this->userModel->createUser($email, $hashedPassword)) {
            // Start the session and store user information
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;

            // Send a confirmation response
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Registration successful']);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Registration failed']);
        }
    }
}
