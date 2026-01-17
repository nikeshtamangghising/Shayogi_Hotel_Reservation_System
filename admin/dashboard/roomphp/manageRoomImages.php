<?php
// manageRoomImages.php - Admin interface for managing room images
include '../db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'add':
        addRoomImage();
        break;
    case 'delete':
        deleteRoomImage();
        break;
    case 'set_primary':
        setPrimaryImage();
        break;
    case 'upload':
        uploadRoomImages();
        break;
    default:
        showRoomImagesForm();
        break;
}

function showRoomImagesForm() {
    global $conn;
    
    // Get all rooms
    $roomsSql = "SELECT RoomId, RoomName, RoomType FROM Rooms ORDER BY RoomId";
    $roomsResult = mysqli_query($conn, $roomsSql);
    
    $rooms = [];
    while($room = mysqli_fetch_assoc($roomsResult)) {
        // Get images for this room
        $imagesSql = "SELECT * FROM room_images WHERE RoomId = {$room['RoomId']} ORDER BY SortOrder, IsPrimary DESC";
        $imagesResult = mysqli_query($conn, $imagesSql);
        
        $room['images'] = [];
        while($image = mysqli_fetch_assoc($imagesResult)) {
            $room['images'][] = $image;
        }
        
        $rooms[] = $room;
    }
    
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Manage Room Images</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .room-section {
                border: 1px solid #ccc;
                margin: 20px 0;
                padding: 15px;
                border-radius: 5px;
            }
            .image-item {
                display: inline-block;
                margin: 10px;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                text-align: center;
                vertical-align: top;
            }
            .image-preview {
                max-width: 150px;
                max-height: 100px;
                display: block;
                margin: 0 auto 10px;
            }
            .upload-form {
                margin: 20px 0;
                padding: 15px;
                background: #f9f9f9;
                border-radius: 5px;
            }
            input[type="file"] {
                margin: 10px 0;
            }
            .primary-btn {
                background: #4CAF50;
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                border-radius: 3px;
            }
            .delete-btn {
                background: #f44336;
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                border-radius: 3px;
            }
        </style>
    </head>
    <body>
        <h1>Manage Room Images</h1>
        
        <?php foreach($rooms as $room): ?>
        <div class="room-section">
            <h3><?php echo htmlspecialchars($room['RoomName']); ?> (<?php echo htmlspecialchars($room['RoomType']); ?>)</h3>
            
            <div class="upload-form">
                <h4>Upload New Images</h4>
                <form method="post" action="?action=upload" enctype="multipart/form-data">
                    <input type="hidden" name="room_id" value="<?php echo $room['RoomId']; ?>">
                    <input type="file" name="images[]" multiple required>
                    <input type="submit" value="Upload Images">
                </form>
            </div>
            
            <h4>Current Images</h4>
            <div>
                <?php if(empty($room['images'])): ?>
                    <p>No images uploaded for this room.</p>
                <?php else: ?>
                    <?php foreach($room['images'] as $image): ?>
                    <div class="image-item">
                        <img src="<?php echo htmlspecialchars($image['ImagePath']); ?>" alt="Room Image" class="image-preview" onerror="this.src='../../../images/hotel/rooms/101.jpg'">
                        <p>Sort: <?php echo $image['SortOrder']; ?></p>
                        <p>Primary: <?php echo $image['IsPrimary'] ? 'Yes' : 'No'; ?></p>
                        <?php if(!$image['IsPrimary']): ?>
                            <button class="primary-btn" onclick="setPrimary(<?php echo $image['ImageID']; ?>)">Set Primary</button>
                        <?php endif; ?>
                        <button class="delete-btn" onclick="deleteImage(<?php echo $image['ImageID']; ?>)">Delete</button>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        
        <script>
            function setPrimary(imageId) {
                if(confirm('Set this image as primary?')) {
                    fetch('?action=set_primary&id=' + imageId, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            alert('Image set as primary successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
                }
            }
            
            function deleteImage(imageId) {
                if(confirm('Delete this image?')) {
                    fetch('?action=delete&id=' + imageId, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            alert('Image deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
                }
            }
        </script>
    </body>
    </html>
    <?php
}

function uploadRoomImages() {
    global $conn;
    
    if(!isset($_FILES['images']) || !isset($_POST['room_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        return;
    }
    
    $roomId = (int)$_POST['room_id'];
    $files = $_FILES['images'];
    
    $uploadDir = '../../../images/hotel/rooms/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $errors = [];
    $successCount = 0;
    
    for($i = 0; $i < count($files['name']); $i++) {
        if($files['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = $files['name'][$i];
            $fileTmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileType = $files['type'][$i];
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if(in_array($fileType, $allowedTypes)) {
                // Create unique filename
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'room_' . $roomId . '_' . uniqid() . '.' . $fileExtension;
                $destination = $uploadDir . $newFileName;
                
                if(move_uploaded_file($fileTmpName, $destination)) {
                    // Save to database
                    $imagePath = 'images/hotel/rooms/' . $newFileName;
                    $sql = "INSERT INTO room_images (RoomId, ImagePath, IsPrimary, SortOrder) VALUES (?, ?, 0, 0)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "iss", $roomId, $imagePath, $sortOrder);
                    if(mysqli_stmt_execute($stmt)) {
                        $successCount++;
                    } else {
                        $errors[] = "Failed to save image to database: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $errors[] = "Failed to upload file: " . $fileName;
                }
            } else {
                $errors[] = "Invalid file type: " . $fileName . ". Allowed types: JPEG, PNG, GIF, WEBP";
            }
        } else {
            $errors[] = "Upload error for file: " . $files['name'][$i];
        }
    }
    
    if($successCount > 0) {
        echo json_encode([
            'success' => true, 
            'message' => "$successCount image(s) uploaded successfully"
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'No images were uploaded. Errors: ' . implode(', ', $errors)
        ]);
    }
}

function setPrimaryImage() {
    global $conn;
    
    $imageId = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    
    if($imageId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid image ID']);
        return;
    }
    
    // First, unset all primary images for this room
    $getImageInfoSql = "SELECT RoomId FROM room_images WHERE ImageID = $imageId";
    $result = mysqli_query($conn, $getImageInfoSql);
    if($row = mysqli_fetch_assoc($result)) {
        $roomId = $row['RoomId'];
        
        $unsetSql = "UPDATE room_images SET IsPrimary = 0 WHERE RoomId = $roomId";
        mysqli_query($conn, $unsetSql);
        
        // Set the selected image as primary
        $setSql = "UPDATE room_images SET IsPrimary = 1 WHERE ImageID = $imageId";
        if(mysqli_query($conn, $setSql)) {
            echo json_encode(['success' => true, 'message' => 'Primary image updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Image not found']);
    }
}

function deleteRoomImage() {
    global $conn;
    
    $imageId = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    
    if($imageId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid image ID']);
        return;
    }
    
    // Get image path to delete the physical file
    $getImageSql = "SELECT ImagePath FROM room_images WHERE ImageID = $imageId";
    $result = mysqli_query($conn, $getImageSql);
    
    if($row = mysqli_fetch_assoc($result)) {
        $imagePath = $row['ImagePath'];
        
        // Delete from database
        $deleteSql = "DELETE FROM room_images WHERE ImageID = $imageId";
        if(mysqli_query($conn, $deleteSql)) {
            // Optionally delete the physical file
            // Uncomment the next lines if you want to delete the physical file as well
            /*
            if(file_exists('../../../' . $imagePath)) {
                unlink('../../../' . $imagePath);
            }
            */
            
            echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Image not found']);
    }
}
?>