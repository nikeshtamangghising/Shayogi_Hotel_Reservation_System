<?php
$pageTitle = "My Profile - Hotel Shayogi";
include 'includes/header.php';

// Check if user is logged in
if (!$isLoggedIn) {
    header('Location: index.php');
    exit;
}
?>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    
    .profile-page {
        padding: 100px 20px 60px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }
    
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        font-weight: 700;
        margin: 0 auto 15px;
    }
    
    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .profile-email {
        color: #6c757d;
        font-size: 0.95rem;
    }
    
    .nav-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .nav-tab {
        padding: 12px 20px;
        background: none;
        border: none;
        color: #6c757d;
        font-weight: 600;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .nav-tab.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }
    
    .nav-tab:hover {
        color: #667eea;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2c3e50;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .form-group input, .form-group select, .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .booking-item, .review-item {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .booking-header, .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .booking-title, .review-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1.1rem;
    }
    
    .booking-date, .review-date {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .booking-details, .review-text {
        color: #495057;
        line-height: 1.6;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-confirmed {
        background: #d4edda;
        color: #155724;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .rating {
        color: #ffc107;
        font-size: 0.9rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #e9ecef;
        margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
        .profile-page {
            padding: 90px 15px 40px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .nav-tabs {
            flex-wrap: wrap;
        }
        
        .nav-tab {
            flex: 1;
            text-align: center;
        }
    }
</style>

<div class="profile-page">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($currentUser['name'], 0, 1)); ?>
            </div>
            <div class="profile-name"><?php echo htmlspecialchars($currentUser['name']); ?></div>
            <div class="profile-email"><?php echo htmlspecialchars($currentUser['email']); ?></div>
        </div>
        
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('edit-profile')">
                <i class="fas fa-user-edit"></i> Edit Profile
            </button>
            <button class="nav-tab" onclick="showTab('bookings')">
                <i class="fas fa-calendar-check"></i> My Bookings
            </button>
            <button class="nav-tab" onclick="showTab('reviews')">
                <i class="fas fa-star"></i> My Reviews
            </button>
        </div>
        
        <!-- Edit Profile Tab -->
        <div class="tab-content active" id="edit-profile">
            <h3 style="margin-bottom: 25px; color: #2c3e50;">Edit Your Profile</h3>
            
            <form id="editProfileForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullName">Full Name *</label>
                        <input type="text" id="fullName" value="<?php echo htmlspecialchars($currentUser['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($currentUser['email'] ?? ''); ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" value="<?php echo htmlspecialchars($currentUser['phone'] ?? ''); ?>" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" value="<?php echo htmlspecialchars($currentUser['country'] ?? ''); ?>" placeholder="Enter country">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="idVerification">ID Verification</label>
                    <input type="text" id="idVerification" value="<?php echo htmlspecialchars($currentUser['id_verification'] ?? ''); ?>" placeholder="Enter ID verification number">
                </div>
                
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" placeholder="Leave blank to keep current password">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>
        
        <!-- My Bookings Tab -->
        <div class="tab-content" id="bookings">
            <h3 style="margin-bottom: 25px; color: #2c3e50;">My Bookings</h3>
            <div id="bookingsContent">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h4>No bookings yet</h4>
                    <p>Start planning your perfect getaway!</p>
                </div>
            </div>
        </div>
        
        <!-- My Reviews Tab -->
        <div class="tab-content" id="reviews">
            <h3 style="margin-bottom: 25px; color: #2c3e50;">My Reviews</h3>
            <div id="reviewsContent">
                <div class="empty-state">
                    <i class="fas fa-star"></i>
                    <h4>No reviews yet</h4>
                    <p>Share your experience after your stay!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active class from all nav tabs
        document.querySelectorAll('.nav-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById(tabId).classList.add('active');
        
        // Add active class to clicked nav tab
        event.target.classList.add('active');
        
        // Load data if needed
        if (tabId === 'bookings') {
            loadBookings();
        } else if (tabId === 'reviews') {
            loadReviews();
        }
    }
    
    // Edit Profile Form
    document.getElementById('editProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('action', 'update_profile');
        formData.append('name', document.getElementById('fullName').value);
        formData.append('username', document.getElementById('username').value);
        formData.append('email', document.getElementById('email').value);
        
        // Add additional guest fields
        formData.append('phone', document.getElementById('phone').value);
        formData.append('country', document.getElementById('country').value);
        formData.append('id_verification', document.getElementById('idVerification').value);
        
        const newPassword = document.getElementById('newPassword').value;
        if (newPassword) {
            formData.append('new_password', newPassword);
        }
        
        fetch('<?php echo $basePath; ?>php/user_auth.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            showMessage('Update failed. Please try again.', 'error');
        });
    });
    
    // Load user bookings
    function loadBookings() {
        fetch('<?php echo $basePath; ?>php/get_user_bookings.php')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.bookings.length > 0) {
                    let html = '';
                    data.bookings.forEach(booking => {
                        const statusClass = booking.status === 'confirmed' ? 'status-confirmed' : 'status-pending';
                        html += `
                            <div class="booking-item">
                                <div class="booking-header">
                                    <div class="booking-title">${booking.room_name}</div>
                                    <div class="booking-date">${booking.check_in} - ${booking.check_out}</div>
                                </div>
                                <div class="booking-details">
                                    <p><strong>Room Type:</strong> ${booking.room_type}</p>
                                    <p><strong>Guests:</strong> ${booking.guests}</p>
                                    <p><strong>Total:</strong> NPR ${booking.total_price}</p>
                                    <p><strong>Status:</strong> <span class="status-badge ${statusClass}">${booking.status}</span></p>
                                </div>
                            </div>
                        `;
                    });
                    document.getElementById('bookingsContent').innerHTML = html;
                } else {
                    document.getElementById('bookingsContent').innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h4>No bookings yet</h4>
                            <p>Start planning your perfect getaway!</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                document.getElementById('bookingsContent').innerHTML = '<p style="text-align: center; color: #e74c3c;">Failed to load bookings.</p>';
            });
    }
    
    // Load user reviews
    function loadReviews() {
        fetch('<?php echo $basePath; ?>php/get_user_reviews.php')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.reviews.length > 0) {
                    let html = '';
                    data.reviews.forEach(review => {
                        html += `
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-title">Review for ${review.room_name || 'Hotel Stay'}</div>
                                    <div class="review-date">${review.date}</div>
                                </div>
                                <div class="rating">
                                    ${Array(5).fill(0).map((_, i) => `<i class="fas fa-star" style="color: ${i < review.rating ? '#ffc107' : '#e9ecef'};"></i>`).join('')}
                                </div>
                                <div class="review-text">${review.review_text}</div>
                            </div>
                        `;
                    });
                    document.getElementById('reviewsContent').innerHTML = html;
                } else {
                    document.getElementById('reviewsContent').innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <h4>No reviews yet</h4>
                            <p>Share your experience after your stay!</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                document.getElementById('reviewsContent').innerHTML = '<p style="text-align: center; color: #e74c3c;">Failed to load reviews.</p>';
            });
    }
</script>

<?php include 'includes/footer.php'; ?>
