<?php
// Guest CRUD Operations
header('Content-Type: application/json');

// Database connection
require_once 'db.php';

// Check if user is logged in (optional - remove if not needed)
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

class GuestCRUD {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    // Read all guests
    public function readAll() {
        $sql = "SELECT * FROM guests ORDER BY GuestID DESC";
        $result = mysqli_query($this->conn, $sql);
        
        if ($result) {
            $guests = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $guests[] = $row;
            }
            return ['success' => true, 'guests' => $guests];
        } else {
            return ['success' => false, 'message' => 'Failed to fetch guests: ' . mysqli_error($this->conn)];
        }
    }
    
    // Read one guest
    public function readOne($id) {
        $sql = "SELECT * FROM guests WHERE GuestID = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            $guest = mysqli_fetch_assoc($result);
            if ($guest) {
                return ['success' => true, 'guest' => $guest];
            } else {
                return ['success' => false, 'message' => 'Guest not found'];
            }
        } else {
            return ['success' => false, 'message' => 'Failed to fetch guest: ' . mysqli_error($this->conn)];
        }
    }
    
    // Create new guest
    public function create($data) {
        // Validate required fields
        if (empty($data['FullName']) || empty($data['Phone']) || empty($data['Username'])) {
            return ['success' => false, 'message' => 'Full Name, Phone, and Username are required'];
        }
        
        // Check if username already exists
        $checkSql = "SELECT GuestID FROM guests WHERE Username = ?";
        $checkStmt = mysqli_prepare($this->conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "s", $data['Username']);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($checkResult) > 0) {
            return ['success' => false, 'message' => 'Username already exists'];
        }
        
        // Check if email already exists (if provided)
        if (!empty($data['Email'])) {
            $checkEmailSql = "SELECT GuestID FROM guests WHERE Email = ?";
            $checkEmailStmt = mysqli_prepare($this->conn, $checkEmailSql);
            mysqli_stmt_bind_param($checkEmailStmt, "s", $data['Email']);
            mysqli_stmt_execute($checkEmailStmt);
            $checkEmailResult = mysqli_stmt_get_result($checkEmailStmt);
            
            if (mysqli_num_rows($checkEmailResult) > 0) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
        }
        
        // Prepare password (hash if provided, otherwise use default)
        $password = !empty($data['Password']) ? sha1($data['Password']) : sha1('password123');
        
        // Insert guest
        $sql = "INSERT INTO guests (FullName, Email, Phone, Username, Password, Country, ID_Verification, image_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        
        $imagePath = 'images/hotel/guests/default.jpg';
        mysqli_stmt_bind_param($stmt, "ssssssss", 
            $data['FullName'], 
            $data['Email'], 
            $data['Phone'], 
            $data['Username'], 
            $password, 
            $data['Country'], 
            $data['ID_Verification'],
            $imagePath
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => true, 'message' => 'Guest created successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to create guest: ' . mysqli_error($this->conn)];
        }
    }
    
    // Update guest
    public function update($id, $data) {
        // Check if guest exists
        $checkSql = "SELECT GuestID FROM guests WHERE GuestID = ?";
        $checkStmt = mysqli_prepare($this->conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "i", $id);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($checkResult) === 0) {
            return ['success' => false, 'message' => 'Guest not found'];
        }
        
        // Check if username already exists (excluding current guest)
        $checkUsernameSql = "SELECT GuestID FROM guests WHERE Username = ? AND GuestID != ?";
        $checkUsernameStmt = mysqli_prepare($this->conn, $checkUsernameSql);
        mysqli_stmt_bind_param($checkUsernameStmt, "si", $data['Username'], $id);
        mysqli_stmt_execute($checkUsernameStmt);
        $checkUsernameResult = mysqli_stmt_get_result($checkUsernameStmt);
        
        if (mysqli_num_rows($checkUsernameResult) > 0) {
            return ['success' => false, 'message' => 'Username already exists'];
        }
        
        // Check if email already exists (excluding current guest)
        if (!empty($data['Email'])) {
            $checkEmailSql = "SELECT GuestID FROM guests WHERE Email = ? AND GuestID != ?";
            $checkEmailStmt = mysqli_prepare($this->conn, $checkEmailSql);
            mysqli_stmt_bind_param($checkEmailStmt, "si", $data['Email'], $id);
            mysqli_stmt_execute($checkEmailStmt);
            $checkEmailResult = mysqli_stmt_get_result($checkEmailStmt);
            
            if (mysqli_num_rows($checkEmailResult) > 0) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
        }
        
        // Build update query dynamically
        $updateFields = [];
        $types = "";
        $values = [];
        
        if (!empty($data['FullName'])) {
            $updateFields[] = "FullName = ?";
            $types .= "s";
            $values[] = $data['FullName'];
        }
        
        if (isset($data['Email'])) {
            $updateFields[] = "Email = ?";
            $types .= "s";
            $values[] = $data['Email'];
        }
        
        if (!empty($data['Phone'])) {
            $updateFields[] = "Phone = ?";
            $types .= "s";
            $values[] = $data['Phone'];
        }
        
        if (!empty($data['Username'])) {
            $updateFields[] = "Username = ?";
            $types .= "s";
            $values[] = $data['Username'];
        }
        
        if (!empty($data['Password'])) {
            $updateFields[] = "Password = ?";
            $types .= "s";
            $values[] = sha1($data['Password']);
        }
        
        if (isset($data['Country'])) {
            $updateFields[] = "Country = ?";
            $types .= "s";
            $values[] = $data['Country'];
        }
        
        if (isset($data['ID_Verification'])) {
            $updateFields[] = "ID_Verification = ?";
            $types .= "s";
            $values[] = $data['ID_Verification'];
        }
        
        if (empty($updateFields)) {
            return ['success' => false, 'message' => 'No fields to update'];
        }
        
        $sql = "UPDATE guests SET " . implode(', ', $updateFields) . " WHERE GuestID = ?";
        $types .= "i";
        $values[] = $id;
        
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => true, 'message' => 'Guest updated successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to update guest: ' . mysqli_error($this->conn)];
        }
    }
    
    // Delete guest
    public function delete($id) {
        // Check if guest exists
        $checkSql = "SELECT GuestID FROM guests WHERE GuestID = ?";
        $checkStmt = mysqli_prepare($this->conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "i", $id);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($checkResult) === 0) {
            return ['success' => false, 'message' => 'Guest not found'];
        }
        
        // Delete guest
        $sql = "DELETE FROM guests WHERE GuestID = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => true, 'message' => 'Guest deleted successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete guest: ' . mysqli_error($this->conn)];
        }
    }
}

// Handle requests
$crud = new GuestCRUD();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'read_all':
            echo json_encode($crud->readAll());
            break;
            
        case 'read_one':
            $id = $_GET['id'] ?? 0;
            echo json_encode($crud->readOne($id));
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'create':
            echo json_encode($crud->create($_POST));
            break;
            
        case 'update':
            $id = $_POST['id'] ?? 0;
            echo json_encode($crud->update($id, $_POST));
            break;
            
        case 'delete':
            $id = $_POST['id'] ?? 0;
            echo json_encode($crud->delete($id));
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
