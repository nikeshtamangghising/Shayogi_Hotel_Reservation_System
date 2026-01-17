<?php
// User Authentication Functions
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once 'db.php';

class UserAuth {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    // Register a new user
    public function register($name, $email, $username, $password) {
        // Validate inputs
        if (empty($name) || empty($email) || empty($username) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required'];
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        // Check if username or email already exists in guests table
        $checkSql = "SELECT * FROM guests WHERE Username = ? OR Email = ?";
        $checkStmt = mysqli_prepare($this->conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "ss", $username, $email);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($checkResult) > 0) {
            return ['success' => false, 'message' => 'Username or email already exists'];
        }
        
        // Hash password and insert user into guests table
        // Use SHA1 hash to fit in varchar(50) field
        $hashedPassword = sha1($password);
        $sql = "INSERT INTO guests (FullName, Username, Email, Password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $hashedPassword);
        
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => true, 'message' => 'Registration successful'];
        } else {
            $error = mysqli_error($this->conn);
            return ['success' => false, 'message' => 'Registration failed: ' . $error];
        }
    }
    
    // Login user
    public function login($username, $password) {
        // Validate inputs
        if (empty($username) || empty($password)) {
            return ['success' => false, 'message' => 'Username and password are required'];
        }
        
        // Query user from guests table
        $sql = "SELECT * FROM guests WHERE Username = ? OR Email = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        
        // Debug: Check if user found and password details
        if ($user) {
            error_log("User found: " . print_r($user, true));
            error_log("Input password: " . $password);
            error_log("Stored hash: " . $user['Password']);
            error_log("Password verify result: " . (sha1($password) === $user['Password'] ? 'true' : 'false'));
        } else {
            error_log("User not found for: " . $username);
        }
        
        // Verify password using SHA1
        if ($user && sha1($password) === $user['Password']) {
            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['GuestID'];
            $_SESSION['user_name'] = $user['FullName'];
            $_SESSION['user_username'] = $user['Username'];
            $_SESSION['user_email'] = $user['Email'];
            $_SESSION['user_role'] = 'user';
            $_SESSION['login_time'] = time();
            
            return ['success' => true, 'message' => 'Login successful'];
        } else {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
            // Check if session is expired (30 minutes)
            if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 1800)) {
                $this->logout();
                return false;
            }
            return true;
        }
        return false;
    }
    
    // Get current user info
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            // Load fresh data from database
            $sql = "SELECT * FROM guests WHERE GuestID = ?";
            $stmt = mysqli_prepare($this->conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            
            if ($user) {
                return [
                    'id' => $user['GuestID'],
                    'name' => $user['FullName'],
                    'username' => $user['Username'],
                    'email' => $user['Email'],
                    'phone' => $user['Phone'],
                    'country' => $user['Country'],
                    'id_verification' => $user['ID_Verification'],
                    'role' => 'user'
                ];
            }
        }
        return null;
    }
    
    // Logout user
    public function logout() {
        session_unset();
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }
    
    // Update user profile
    public function updateProfile($userId, $name, $email, $username, $phone = '', $country = '', $idVerification = '', $newPassword = '') {
        if (empty($name) || empty($username)) {
            return ['success' => false, 'message' => 'Name and username are required'];
        }
        
        // Check if email or username is already taken by another user in guests table
        $checkSql = "SELECT * FROM guests WHERE (Username = ? OR Email = ?) AND GuestID != ?";
        $checkStmt = mysqli_prepare($this->conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "ssi", $username, $email, $userId);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($checkResult) > 0) {
            return ['success' => false, 'message' => 'Username or email already exists'];
        }
        
        // Build update query dynamically
        $updateFields = ["FullName = ?", "Username = ?"];
        $types = "ssi";
        $values = [$name, $username, $userId];
        
        if ($email !== null) {
            $updateFields[] = "Email = ?";
            $types .= "s";
            $values[] = $email;
        }
        
        if ($phone !== null) {
            $updateFields[] = "Phone = ?";
            $types .= "s";
            $values[] = $phone;
        }
        
        if ($country !== null) {
            $updateFields[] = "Country = ?";
            $types .= "s";
            $values[] = $country;
        }
        
        if ($idVerification !== null) {
            $updateFields[] = "ID_Verification = ?";
            $types .= "s";
            $values[] = $idVerification;
        }
        
        if ($newPassword !== null && $newPassword !== '') {
            $updateFields[] = "Password = ?";
            $types .= "s";
            $values[] = sha1($newPassword);
        }
        
        $sql = "UPDATE guests SET " . implode(', ', $updateFields) . " WHERE GuestID = ?";
        
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        
        if (mysqli_stmt_execute($stmt)) {
            // Update session variables
            $_SESSION['user_name'] = $name;
            $_SESSION['user_username'] = $username;
            if ($email !== null) {
                $_SESSION['user_email'] = $email;
            }
            
            return ['success' => true, 'message' => 'Profile updated successfully'];
        } else {
            return ['success' => false, 'message' => 'Profile update failed'];
        }
    }
    
    // Change user password
    public function changePassword($userId, $oldPassword, $newPassword) {
        if (empty($oldPassword) || empty($newPassword)) {
            return ['success' => false, 'message' => 'Both old and new passwords are required'];
        }
        
        if (strlen($newPassword) < 6) {
            return ['success' => false, 'message' => 'New password must be at least 6 characters'];
        }
        
        // Get current password hash from guests table
        $sql = "SELECT Password FROM guests WHERE GuestID = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        
        if (!$user || sha1($oldPassword) !== $user['Password']) {
            return ['success' => false, 'message' => 'Old password is incorrect'];
        }
        
        // Update with new password in guests table
        $newHashedPassword = sha1($newPassword);
        $updateSql = "UPDATE guests SET Password = ? WHERE GuestID = ?";
        $updateStmt = mysqli_prepare($this->conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "si", $newHashedPassword, $userId);
        
        if (mysqli_stmt_execute($updateStmt)) {
            return ['success' => true, 'message' => 'Password changed successfully'];
        } else {
            return ['success' => false, 'message' => 'Password change failed'];
        }
    }
}

// Handle AJAX requests - only if this file is called directly
if ($_SERVER['REQUEST_METHOD'] === 'POST' && basename($_SERVER['SCRIPT_FILENAME']) === 'user_auth.php') {
    $auth = new UserAuth();
    
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'register':
            $response = $auth->register(
                $_POST['name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['username'] ?? '',
                $_POST['password'] ?? ''
            );
            echo json_encode($response);
            break;
            
        case 'login':
            $response = $auth->login(
                $_POST['username'] ?? '',
                $_POST['password'] ?? ''
            );
            echo json_encode($response);
            break;
            
        case 'logout':
            $response = $auth->logout();
            echo json_encode($response);
            break;
            
        case 'update_profile':
            if ($auth->isLoggedIn()) {
                $response = $auth->updateProfile(
                    $_SESSION['user_id'],
                    $_POST['name'] ?? '',
                    $_POST['email'] ?? '',
                    $_POST['username'] ?? '',
                    $_POST['phone'] ?? '',
                    $_POST['country'] ?? '',
                    $_POST['id_verification'] ?? '',
                    $_POST['new_password'] ?? ''
                );
                echo json_encode($response);
            } else {
                echo json_encode(['success' => false, 'message' => 'Not logged in']);
            }
            break;
            
        case 'change_password':
            if ($auth->isLoggedIn()) {
                $response = $auth->changePassword(
                    $_SESSION['user_id'],
                    $_POST['old_password'] ?? '',
                    $_POST['new_password'] ?? ''
                );
                echo json_encode($response);
            } else {
                echo json_encode(['success' => false, 'message' => 'Not logged in']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
    exit;
}
?>