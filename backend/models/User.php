<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $role;
    public $user_type;
    public $company_name;
    public $industry;
    public $total_points;
    public $profile_completion;
    public $created_at;
    public $last_login;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Register a new user
    public function register() {
        $query = "INSERT INTO " . $this->table_name . "
                (username, email, password, role, user_type, company_name, industry, total_points, profile_completion)
                VALUES
                (:username, :email, :password, :role, :user_type, :company_name, :industry, :total_points, :profile_completion)";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->role = 'user';
        $this->user_type = htmlspecialchars(strip_tags($this->user_type));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->industry = htmlspecialchars(strip_tags($this->industry));
        $this->total_points = 0;
        $this->profile_completion = 0;

        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":user_type", $this->user_type);
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":industry", $this->industry);
        $stmt->bindParam(":total_points", $this->total_points);
        $stmt->bindParam(":profile_completion", $this->profile_completion);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Login user
    public function login() {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->role = $row['role'];
                $this->user_type = $row['user_type'];
                $this->company_name = $row['company_name'];
                $this->industry = $row['industry'];
                $this->total_points = $row['total_points'];
                $this->profile_completion = $row['profile_completion'];
                
                // Update last login
                $this->updateLastLogin();
                
                return true;
            }
        }
        return false;
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . "
                WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Get user by ID
    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->role = $row['role'];
            $this->password = $row['password'];
            $this->user_type = $row['user_type'];
            $this->company_name = $row['company_name'];
            $this->industry = $row['industry'];
            $this->total_points = $row['total_points'];
            $this->profile_completion = $row['profile_completion'];
            $this->created_at = $row['created_at'];
            $this->last_login = $row['last_login'];
            return true;
        }
        return false;
    }
    
    // Update user password
    public function updatePassword() {
        $query = "UPDATE " . $this->table_name . "
                SET password = :password
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Hash the password
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":id", $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Get all users
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update last login time
    public function updateLastLogin() {
        $query = "UPDATE " . $this->table_name . "
                SET last_login = NOW()
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Update profile completion percentage
    public function updateProfileCompletion($percentage) {
        $query = "UPDATE " . $this->table_name . "
                SET profile_completion = :percentage
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":percentage", $percentage);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Add company information
    public function updateCompanyInfo($company_name, $industry) {
        $query = "UPDATE " . $this->table_name . "
                SET company_name = :company_name, industry = :industry
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $company_name = htmlspecialchars(strip_tags($company_name));
        $industry = htmlspecialchars(strip_tags($industry));
        
        $stmt->bindParam(":company_name", $company_name);
        $stmt->bindParam(":industry", $industry);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            $this->company_name = $company_name;
            $this->industry = $industry;
            return true;
        }
        return false;
    }
}
?> 