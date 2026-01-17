<?php
// Note: For CSS resources in this header, use the direct path calculation

// Start session and include authentication
session_start();
require_once __DIR__ . '/../php/user_auth.php';

$auth = new UserAuth();

// Check if user is logged in
$isLoggedIn = $auth->isLoggedIn();
$currentUser = $isLoggedIn ? $auth->getCurrentUser() : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Shayogi - <?php echo isset($pageTitle) ? $pageTitle : 'Luxury Hotel Experience'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php
    // Calculate base path relative to document root
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
    $version = '?v=' . time(); // Cache buster
    ?>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/main.css<?php echo $version; ?>">
    <style>
        .navbar_rightside {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .navbar_rightside > a {
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        .navbar_rightside > a:hover {
            color: #ffd700;
            transform: scale(1.1);
        }
        
        /* Profile Dropdown Styles */
        .profile-dropdown {
            position: relative;
        }
        
        #userProfileDropdown {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
            z-index: 1001;
            outline: none;
            pointer-events: auto !important;
            user-select: none;
        }
        
        #userProfileDropdown:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.15));
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        #userProfileDropdown:focus {
            outline: 2px solid rgba(102, 126, 234, 0.5);
            outline-offset: 2px;
        }
        
        #userProfileDropdown i {
            color: white;
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }
        
        #userProfileDropdown:hover i {
            transform: scale(1.1);
        }
        
        .user-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            color: white;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .profile-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 280px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10000;
            overflow: hidden;
        }
        
        .profile-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            display: block !important;
        }
        
        .profile-header {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }
        
        .profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid white;
            margin: 0 auto 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .avatar-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid white;
            margin: 0 auto 10px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .avatar-placeholder i {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .profile-info {
            text-align: center;
            margin-top: 8px;
        }
        
        .profile-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 4px;
            color: white;
        }
        
        .profile-status {
            display: inline-block;
            padding: 4px 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .profile-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
        
        .profile-divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.08);
            margin: 0;
            position: relative;
        }
        
        .profile-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            font-weight: 500;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .profile-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .profile-item:hover::before {
            left: 100%;
        }
        
        .profile-item:hover {
            background: linear-gradient(135deg, #f8f9ff, #e8f0ff);
            color: #667eea;
            transform: translateX(4px);
        }
        
        .profile-item:focus {
            outline: 2px solid #667eea;
            outline-offset: -2px;
        }
        
        .profile-item i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        
        .profile-item:hover i {
            transform: scale(1.1);
        }
        
        .profile-item.danger {
            color: #dc3545;
        }
        
        .profile-item.danger:hover {
            background: linear-gradient(135deg, #ffebee, #fce4ec);
            color: #d32f2f;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .profile-menu {
                right: -10px;
                min-width: 260px;
                border-radius: 12px;
            }
            
            .profile-item {
                padding: 14px 16px;
                font-size: 0.9rem;
            }
            
            .profile-header {
                padding: 16px;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .profile-menu {
                right: -20px;
                min-width: 240px;
            }
            
            .profile-item {
                padding: 12px 14px;
                gap: 12px;
            }
            
            .profile-item i {
                width: 18px;
                font-size: 0.9rem;
            }
        }
        
        /* Auth Modal Styles */
        .auth-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 20000;
            padding: 20px;
        }
        
        .auth-modal.show {
            display: flex;
        }
        
        .auth-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .auth-header {
            padding: 30px 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px 20px 0 0;
            color: white;
            text-align: center;
            position: relative;
        }
        
        .auth-header h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
        }
        
        .auth-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        
        .auth-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        
        .auth-body {
            padding: 30px;
        }
        
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }
        
        .form-group input {
            padding: 14px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 5px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            color: #495057;
            position: relative;
        }
        
        .checkbox-label input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            height: 18px;
            width: 18px;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
            flex-shrink: 0;
        }
        
        .checkbox-label:hover .checkmark {
            background-color: #e9ecef;
            border-color: #667eea;
        }
        
        .checkbox-label input[type="checkbox"]:checked ~ .checkmark {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .checkbox-label input[type="checkbox"]:checked ~ .checkmark:after {
            content: "";
            position: absolute;
            left: 5px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .password-strength-weak {
            width: 33%;
            background: #dc3545;
        }
        
        .password-strength-medium {
            width: 66%;
            background: #ffc107;
        }
        
        .password-strength-strong {
            width: 100%;
            background: #28a745;
        }
        
        .auth-buttons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }
        
        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #e9ecef;
            color: #495057;
        }
        
        .btn-secondary:hover {
            background: #dee2e6;
        }
        
        .auth-footer {
            padding: 20px 30px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
        }
        
        .auth-footer p {
            margin: 0;
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .form-help {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* Message Box */
        .message-box {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 30000;
            display: none;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .message-box.show {
            display: flex;
        }
        
        .message-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .message-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            backdrop-filter: blur(5px);
        }
        
        .loading-overlay.show {
            display: flex;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e9ecef;
            border-top-color: var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    
    <div id="home"></div>
    <section class="home_Navbar">
        <div class="logopart">
            <img src="<?php echo $basePath; ?>images/hotel/logoblack.png" alt="Hotel Shayogi Logo System">
        </div>
        <div class="mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div>
            <ul class="home_Navmenu">
                <li><a href="<?php echo $basePath; ?>index.php"><i class="nav-item-icon fas fa-home"></i> Home</a></li>
                <li><a href="<?php echo $basePath; ?>index.php#about"><i class="nav-item-icon fas fa-info-circle"></i> About</a></li>
                <li><a href="<?php echo $basePath; ?>index.php#gallery"><i class="nav-item-icon fas fa-images"></i> Gallery</a></li>
                <li><a href="<?php echo $basePath; ?>index.php#review"><i class="nav-item-icon fas fa-star"></i> Guest Review</a></li>
                <li><a href="<?php echo $basePath; ?>index.php#contact"><i class="nav-item-icon fas fa-phone"></i> Contact</a></li>
                <?php if ($isLoggedIn): ?>
                <li><a href="<?php echo $basePath; ?>rooms.php"><i class="nav-item-icon fas fa-hotel"></i> Rooms</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="navbar_rightside">
            <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="social-icon"><i class="fa-brands fa-twitter"></i></a>
            <div class="profile-dropdown">
                <button type="button" id="userProfileDropdown" class="user-profile-button" onclick="console.log('Direct click!'); toggleProfileMenu(event); return false;" 
                        aria-label="User Profile Menu" aria-expanded="false" aria-haspopup="true" 
                        tabindex="0">
                    <i class="fas fa-user"></i>
                    <?php if ($isLoggedIn): ?>
                    <span class="user-badge" aria-label="Logged in user"><?php echo strtoupper(substr($currentUser['name'], 0, 1)); ?></span>
                    <?php endif; ?>
                </button>
                <div class="profile-menu" id="profileMenu" role="menu" aria-labelledby="userProfileDropdown">
                    <div class="profile-header" role="none">
                        <div class="profile-avatar">
                            <?php if ($isLoggedIn): ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($currentUser['name']); ?>&background=random" alt="<?php echo htmlspecialchars($currentUser['name']); ?>" />
                            <?php else: ?>
                            <div class="avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="profile-info">
                            <div class="profile-name"><?php echo $isLoggedIn ? htmlspecialchars($currentUser['name']) : 'Guest User'; ?></div>
                            <?php if ($isLoggedIn): ?>
                            <div class="profile-status">Member</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="profile-divider" role="none"></div>
                    <?php if (!$isLoggedIn): ?>
                    <button class="profile-item" role="menuitem" onclick="showAuthModal('login')" tabindex="0">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </button>
                    <button class="profile-item" role="menuitem" onclick="showAuthModal('register')" tabindex="0">
                        <i class="fas fa-user-plus"></i>
                        <span>Register</span>
                    </button>
                    <?php else: ?>
                    <button class="profile-item" role="menuitem" onclick="viewProfile()" tabindex="0">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </button>
                    <button class="profile-item" role="menuitem" onclick="viewBookings()" tabindex="0">
                        <i class="fas fa-calendar-check"></i>
                        <span>My Bookings</span>
                    </button>
                    <button class="profile-item" role="menuitem" onclick="changePassword()" tabindex="0">
                        <i class="fas fa-key"></i>
                        <span>Change Password</span>
                    </button>
                    <div class="profile-divider" role="none"></div>
                    <button class="profile-item danger" role="menuitem" onclick="logoutUser()" tabindex="0">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <div class="auth-modal" id="authModal">
        <div class="auth-content">
            <div class="auth-header">
                <h2 id="authTitle">Login</h2>
                <button class="auth-close" onclick="closeAuthModal()">&times;</button>
            </div>
            <div class="auth-body">
                <!-- Login Form -->
                <form class="auth-form" id="loginForm" style="display: none;">
                    <div class="form-group">
                        <label for="loginEmail">Email or Username</label>
                        <input type="text" id="loginEmail" placeholder="Enter your email or username" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="loginPassword" placeholder="Enter your password" required autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">
                                <i class="fas fa-eye" id="loginPassword-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="rememberMe" name="rememberMe">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                    </div>
                    <div class="auth-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeAuthModal()">Cancel</button>
                    </div>
                </form>
                
                <!-- Register Form -->
                <form class="auth-form" id="registerForm" style="display: none;">
                    <div class="form-group">
                        <label for="registerName">Full Name</label>
                        <input type="text" id="registerName" placeholder="Enter your full name" required autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email Address</label>
                        <input type="email" id="registerEmail" placeholder="Enter your email" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="registerUsername">Username</label>
                        <input type="text" id="registerUsername" placeholder="Choose a username" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="registerPassword" placeholder="Create a password (min 6 characters)" required minlength="6" autocomplete="new-password" oninput="checkPasswordStrength(this.value)">
                            <button type="button" class="password-toggle" onclick="togglePassword('registerPassword')">
                                <i class="fas fa-eye" id="registerPassword-icon"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        <div class="form-help">Password must be at least 6 characters long</div>
                    </div>
                    <div class="auth-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeAuthModal()">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="auth-footer">
                <p id="authFooterText">Don't have an account? <a href="#" onclick="switchAuthMode('register'); return false;">Register here</a></p>
            </div>
        </div>
    </div>
    <main>