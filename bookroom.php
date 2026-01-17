<?php
// Get room details from URL parameters
$roomId = isset($_GET['roomId']) ? $_GET['roomId'] : '';
$roomName = isset($_GET['roomName']) ? $_GET['roomName'] : '';
$roomType = isset($_GET['roomType']) ? $_GET['roomType'] : '';
$attachBathroom = isset($_GET['attachBathroom']) ? $_GET['attachBathroom'] : '';
$nonSmokingRoom = isset($_GET['nonSmokingRoom']) ? $_GET['nonSmokingRoom'] : '';
$totalOccupancy = isset($_GET['totalOccupancy']) ? $_GET['totalOccupancy'] : '';
$availabilities = isset($_GET['availabilities']) ? $_GET['availabilities'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$ImagePath = isset($_GET['ImagePath']) ? $_GET['ImagePath'] : 'images/hotel/rooms/101.jpg';
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
                    <div class="thumbnail active" data-image="<?php echo htmlspecialchars($ImagePath); ?>">
                        <img src="<?php echo htmlspecialchars($ImagePath); ?>" alt="Main view" onerror="this.src='images/hotel/rooms/101.jpg'">
                    </div>
                    <div class="thumbnail" data-image="<?php echo htmlspecialchars($ImagePath); ?>">
                        <img src="<?php echo htmlspecialchars($ImagePath); ?>" alt="Interior view" onerror="this.src='images/hotel/rooms/101.jpg'">
                    </div>
                    <div class="thumbnail" data-image="<?php echo htmlspecialchars($ImagePath); ?>">
                        <img src="<?php echo htmlspecialchars($ImagePath); ?>" alt="Bathroom view" onerror="this.src='images/hotel/rooms/101.jpg'">
                    </div>
                    <div class="thumbnail" data-image="<?php echo htmlspecialchars($ImagePath); ?>">
                        <img src="<?php echo htmlspecialchars($ImagePath); ?>" alt="View from room" onerror="this.src='images/hotel/rooms/101.jpg'">
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            <div class="room-info slide-in">
                <h1 class="room-name"><?php echo htmlspecialchars($roomName); ?></h1>
                <span class="room-type"><?php echo htmlspecialchars($roomType); ?></span>
                
                <div class="room-price">
                    <span class="price-amount">NPR <?php echo htmlspecialchars($price); ?></span>
                    <span class="price-period">per night</span>
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