<?php

/**
 * Dynamic Pricing Function
 * Calculates the same dynamic price as used in show_rooms.php
 */
function calculateDynamicPrice($basePrice, $roomId, $checkIn, $checkOut) {
    $price = floatval($basePrice);
    $multiplier = 1.0;
    
    // Factor 1: Time-based pricing (simpler version)
    $daysUntilCheckin = (strtotime($checkIn) - time()) / (24 * 60 * 60);
    if ($daysUntilCheckin <= 3) {
        $multiplier += 0.25; // Last-minute premium
    } elseif ($daysUntilCheckin <= 7) {
        $multiplier += 0.10; // Short notice
    } elseif ($daysUntilCheckin > 60) {
        $multiplier -= 0.10; // Early booking discount
    }
    
    // Factor 2: Seasonal adjustment
    $month = date('n', strtotime($checkIn));
    if (in_array($month, [10, 11, 12, 1, 2])) { // Peak tourist season
        $multiplier += 0.20; // +20%
    } elseif (in_array($month, [6, 7, 8, 9])) { // Monsoon season
        $multiplier -= 0.15; // -15%
    }
    
    // Factor 3: Room popularity adjustment
    $popularRooms = [18, 19]; // Based on sample data
    if (in_array($roomId, $popularRooms)) {
        $multiplier += 0.10; // +10% for popular rooms
    }
    
    // Apply reasonable bounds
    $multiplier = max(0.7, min(1.8, $multiplier));
    
    return round($price * $multiplier, 2);
}

// Get room details from URL parameters
$roomId = isset($_GET['roomId']) ? $_GET['roomId'] : '';
$roomName = isset($_GET['roomName']) ? $_GET['roomName'] : '';
$roomType = isset($_GET['roomType']) ? $_GET['roomType'] : '';
$attachBathroom = isset($_GET['attachBathroom']) ? $_GET['attachBathroom'] : '';
$nonSmokingRoom = isset($_GET['nonSmokingRoom']) ? $_GET['nonSmokingRoom'] : '';
$totalOccupancy = isset($_GET['totalOccupancy']) ? $_GET['totalOccupancy'] : '';
$availabilities = isset($_GET['availabilities']) ? $_GET['availabilities'] : '';
// Get room details from URL parameters
$roomId = isset($_GET['roomId']) ? $_GET['roomId'] : '';
$roomName = isset($_GET['roomName']) ? $_GET['roomName'] : '';
$roomType = isset($_GET['roomType']) ? $_GET['roomType'] : '';
$attachBathroom = isset($_GET['attachBathroom']) ? $_GET['attachBathroom'] : '';
$nonSmokingRoom = isset($_GET['nonSmokingRoom']) ? $_GET['nonSmokingRoom'] : '';
$totalOccupancy = isset($_GET['totalOccupancy']) ? $_GET['totalOccupancy'] : '';
$availabilities = isset($_GET['availabilities']) ? $_GET['availabilities'] : '';
$dynamicPrice = isset($_GET['dynamicPrice']) ? $_GET['dynamicPrice'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$checkInDate = isset($_GET['checkInDate']) ? $_GET['checkInDate'] : '';
$checkOutDate = isset($_GET['checkOutDate']) ? $_GET['checkOutDate'] : '';

// Include database connection to fetch base price and recalculate dynamic price
include_once 'php/db.php';

// Fetch the base price from the database to ensure we have the correct value
$fetchBasePriceSql = "SELECT Price FROM Rooms WHERE RoomId = '$roomId'";
$basePriceResult = mysqli_query($conn, $fetchBasePriceSql);
$basePriceRow = mysqli_fetch_assoc($basePriceResult);
$actualBasePrice = $basePriceRow ? $basePriceRow['Price'] : $price;

// Calculate dynamic price using the same algorithm as show_rooms.php
$recalculatedDynamicPrice = calculateDynamicPrice($actualBasePrice, $roomId, $checkInDate, $checkOutDate);

// Use the recalculated dynamic price as the primary price
$displayPrice = $recalculatedDynamicPrice;

// Close the DB connection
mysqli_close($conn);
// Handle multiple images - get the first one or the original ImagePath
$ImagePaths = isset($_GET['ImagePaths']) ? json_decode($_GET['ImagePaths'], true) : [];
$ImagePath = isset($_GET['ImagePath']) ? $_GET['ImagePath'] : 'images/hotel/rooms/101.jpg';

// If we have multiple images, use the first one, otherwise use the original
if (!empty($ImagePaths) && is_array($ImagePaths) && count($ImagePaths) > 0) {
    $ImagePath = $ImagePaths[0];
}
$checkInDate = isset($_GET['checkInDate']) ? $_GET['checkInDate'] : '';
$checkOutDate = isset($_GET['checkOutDate']) ? $_GET['checkOutDate'] : '';
$numberGuest = isset($_GET['numberGuest']) ? $_GET['numberGuest'] : '';

// Fallback for empty image path
if (empty($ImagePath) || $ImagePath === 'null') {
    $ImagePath = 'images/hotel/rooms/101.jpg';
}

$pageTitle = "$roomName - Book Your Stay";
include 'includes/header.php';
?>


<!-- Main Content -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <!-- Room Gallery -->
            <div class="room-gallery fade-in">
                <div class="gallery-main">
                    <img src="<?php echo htmlspecialchars($ImagePath); ?>" 
                         alt="<?php echo htmlspecialchars($roomName); ?>"
                         id="mainImage"
                         onerror="this.src='images/hotel/rooms/101.jpg'">
                </div>
                <div class="gallery-thumbnails">
                    <?php
                    // Display thumbnails for all available images
                    $imageList = [];  // Initialize as empty array
                    if (!empty($ImagePaths) && is_array($ImagePaths)) {
                        $imageList = $ImagePaths;
                    } else {
                        // If no ImagePaths, use the single ImagePath
                        $imageList = [$ImagePath];
                    }
                    
                    foreach ($imageList as $index => $imagePath):
                        $isActive = ($index === 0) ? 'active' : '';
                    ?>
                    <div class="thumbnail <?php echo $isActive; ?>" data-image="<?php echo htmlspecialchars($imagePath); ?>">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Room view <?php echo $index + 1; ?>" onerror="this.src='images/hotel/rooms/101.jpg'">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Room Information -->
            <div class="room-info slide-in">
                <h1 class="room-name"><?php echo htmlspecialchars($roomName); ?></h1>
                <span class="room-type"><?php echo htmlspecialchars($roomType); ?></span>
                
                <div class="room-price">
                    <?php if($displayPrice != $actualBasePrice && !empty($actualBasePrice)): ?>
                    <div class="original-price" style="text-decoration: line-through; color: #999; font-size: 1rem;">NPR <?php echo htmlspecialchars($actualBasePrice); ?></div>
                    <?php endif; ?>
                    <span class="price-amount">NPR <?php echo htmlspecialchars($displayPrice); ?></span>
                    <span class="price-period">per night</span>
                    <div class="dynamic-price-note">Dynamic Price (Based on availability & season)<?php if($displayPrice != $actualBasePrice && !empty($actualBasePrice)): ?> | Original Price: NPR <?php echo htmlspecialchars($actualBasePrice); ?><?php endif; ?></div>
                </div>

                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Max Occupancy</h4>
                            <p><?php echo htmlspecialchars($totalOccupancy); ?> guests</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Available Rooms</h4>
                            <p><?php echo htmlspecialchars($availabilities); ?> remaining</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-bath"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Private Bathroom</h4>
                            <p><?php echo htmlspecialchars($attachBathroom); ?></p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-smoking-ban"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Non-Smoking</h4>
                            <p><?php echo htmlspecialchars($nonSmokingRoom); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Booking Widget -->
                <div class="booking-widget">
                    <div class="widget-header">
                        <h2>Complete Your Stay</h2>
                        <p>Secure your reservation in just a few moments</p>
                    </div>
                    
                    <div class="date-summary">
                        <div class="date-item">
                            <div class="date-label">Check-in</div>
                            <div class="date-value"><?php echo htmlspecialchars($checkInDate); ?></div>
                        </div>
                        <div class="date-item">
                            <div class="date-label">Check-out</div>
                            <div class="date-value"><?php echo htmlspecialchars($checkOutDate); ?></div>
                        </div>
                    </div>

                    <form id="bookingForm" class="booking-form">
                        <input type="hidden" name="roomId" value="<?php echo htmlspecialchars($roomId); ?>">
                                                <input type="hidden" name="roomPrice" value="<?php echo htmlspecialchars($displayPrice); ?>">
                        <input type="hidden" name="checkInDate" value="<?php echo htmlspecialchars($checkInDate); ?>">
                        <input type="hidden" name="checkOutDate" value="<?php echo htmlspecialchars($checkOutDate); ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName" class="form-label">Full Name *</label>
                                <input type="text" 
                                       id="fullName" 
                                       name="fullName" 
                                       class="form-input"
                                       required 
                                       placeholder="Your full name"
                                       value="<?php echo $isLoggedIn && $currentUser ? htmlspecialchars($currentUser['name']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="guestEmail" class="form-label">Email Address *</label>
                                <input type="email" 
                                       id="guestEmail" 
                                       name="guestEmail" 
                                       class="form-input"
                                       required 
                                       placeholder="your@email.com"
                                       value="<?php echo $isLoggedIn && $currentUser ? htmlspecialchars($currentUser['email']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="guestPhone" class="form-label">Phone Number *</label>
                                <input type="tel" 
                                       id="guestPhone" 
                                       name="guestPhone" 
                                       class="form-input"
                                       required 
                                       placeholder="+977 98XXXXXXXX">
                            </div>
                            <div class="form-group">
                                <label for="guestCountry" class="form-label">Country *</label>
                                <input type="text" 
                                       id="guestCountry" 
                                       name="guestCountry" 
                                       class="form-input"
                                       required 
                                       value="<?php echo $isLoggedIn && $currentUser ? 'Nepal' : 'Nepal'; ?>"
                                       placeholder="Your country">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="guestVerifyID" class="form-label">ID Number *</label>
                                <input type="text" 
                                       id="guestVerifyID" 
                                       name="guestVerifyID" 
                                       class="form-input"
                                       required 
                                       placeholder="Passport or ID number">
                            </div>
                            <div class="form-group">
                                <label for="numberGuest" class="form-label">Number of Guests *</label>
                                <input type="number" 
                                       id="numberGuest" 
                                       name="numberGuest" 
                                       class="form-input"
                                       value="<?php echo htmlspecialchars($numberGuest); ?>" 
                                       min="1" 
                                       max="<?php echo htmlspecialchars($totalOccupancy); ?>"
                                       required>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-large btn-block" id="confirmBookingBtn">
                                <i class="fa-solid fa-check"></i>
                                <span class="btn-text">Confirm Reservation</span>
                            </button>
                            <button type="button" class="btn btn-secondary btn-large btn-block" onclick="history.back()">
                                <i class="fa-solid fa-arrow-left"></i>
                                Back to Search
                            </button>
                        </div>
                        
                        <div id="bookingMessage" class="message-box"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo $basePath; ?>javascript/modern-book.js"></script>

<script>
// Gallery functionality for multiple images
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Update main image
            const newImageSrc = this.getAttribute('data-image');
            mainImage.src = newImageSrc;
            
            // Update active state
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
<script>
// Message display function for booking page
function showMessage(message, type) {
    console.log('showMessage called:', message, type);
    const messageBox = document.getElementById('bookingMessage');
    if (!messageBox) {
        console.error('Message box not found!');
        alert(message); // Fallback to alert
        return;
    }
    
    messageBox.className = 'message-box show message-' + type;
    messageBox.textContent = message;
    messageBox.style.display = 'block';
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        messageBox.style.display = 'none';
    }, 5000);
}

// Debug: Check if form is being initialized
$(document).ready(function() {
    console.log('Bookroom page loaded');
    console.log('Form exists:', $('#bookingForm').length);
    console.log('jQuery version:', $.fn.jquery);
    
    // Add manual form submit handler as backup
    $('#bookingForm').on('submit', function(e) {
        console.log('Form submit triggered!');
    });
});
</script>

<?php
include 'includes/footer.php';
?>