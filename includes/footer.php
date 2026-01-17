    </main>

    <section class="footer_container" id="contact">
        <div class="upperFooter">
            <div>
                <ul>
                    <li id="headingfoot">Contact Info</li>
                    <li id="contentfoot"><i class="fa-solid fa-address-book"></i><a href="#">Shree Krishna Karki</a></li>
                    <li id="contentfoot"><i class="fa-solid fa-address-book"></i><a href="#">Nikesh Tamang</a></li>
                    <li id="contentfoot"><i class="fa-solid fa-phone"></i>+977 9861171281</li>
                    <li id="contentfoot"><i class="fa-solid fa-location-dot"></i>Bhaktapur, Nepal</li>
                    <li id="contentfoot"><i class="fa-brands fa-whatsapp"></i>+977 9865214521</li>
                </ul>
            </div>
            <div>
                <ul>
                    <li id="headingfoot">Services</li>
                    <li id="contentfoot"><i class="fa-solid fa-mug-saucer"></i>Delicious Breakfast</li>
                    <li id="contentfoot"><i class="fa-solid fa-square-parking"></i>24 Hour Parking</li>
                    <li id="contentfoot"><i class="fa-solid fa-wifi"></i>WiFi Internet</li>
                    <li id="contentfoot"><i class="fa-solid fa-broom"></i>Room Service</li>
                    <li id="contentfoot"><i class="fa-solid fa-car"></i>Car Rentals</li>
                </ul>
            </div>
            <div>
                <ul>
                    <li id="headingfoot">Quick Links</li>
                    <li id="contentfoot"><i class="fa-solid fa-bed"></i>Room Booking</li>
                    <li id="contentfoot"><i class="fa-solid fa-utensils"></i>Restaurant</li>
                    <li id="contentfoot"><i class="fa-solid fa-spa"></i>Spa Services</li>
                    <li id="contentfoot"><i class="fa-solid fa-hiking"></i>Trekking Tours</li>
                    <li id="contentfoot"><i class="fa-solid fa-calendar"></i>Event Booking</li>
                </ul>
            </div>
        </div>
        <div class="foottext">
            <span id="headingfoot">Connect With Us</span>
            <div>
                <a href="#" id="footersocial"><i class="fa-brands fa-facebook"></i>Facebook</a>
                <a href="#" id="footersocial"><i class="fa-brands fa-instagram"></i>Instagram</a>
                <a href="#" id="footersocial"><i class="fa-brands fa-tiktok"></i>Tiktok</a>
                <a href="#" id="footersocial"><i class="fa-brands fa-twitter"></i>Twitter</a>
            </div>
        </div>

        <footer>
            <div>Shayogi Reservation System</div>
            <div>Copyright © Shayogi. All Rights Reserved.</div>
            <div></div>
        </footer>

<!-- Message Box for notifications -->
<div id="bookingMessage" class="message-box"></div>

<script>
    // Profile dropdown functionality
    function toggleProfileMenu(event) {
        console.log('toggleProfileMenu called!', event);
        event.stopPropagation();
        const menu = document.getElementById('profileMenu');
        const button = document.getElementById('userProfileDropdown');
        console.log('Menu element:', menu);
        console.log('Button element:', button);
        
        if (!menu) {
            console.error('Profile menu not found!');
            return;
        }
        
        const isOpen = menu.classList.contains('show');
        console.log('Is menu open:', isOpen);
        
        // Close all dropdowns
        closeAllDropdowns();
        
        if (!isOpen) {
            menu.classList.add('show');
            button.setAttribute('aria-expanded', 'true');
            console.log('Menu should now be visible');
            
            // Focus first menu item
            const firstItem = menu.querySelector('.profile-item[role="menuitem"]');
            if (firstItem) {
                setTimeout(() => firstItem.focus(), 100);
            }
        } else {
            button.setAttribute('aria-expanded', 'false');
            console.log('Menu should now be hidden');
        }
    }
    
    function closeAllDropdowns() {
        const menu = document.getElementById('profileMenu');
        const button = document.getElementById('userProfileDropdown');
        if (menu) {
            menu.classList.remove('show');
            button.setAttribute('aria-expanded', 'false');
        }
    }
    
    // Keyboard navigation for profile menu
    function handleProfileKeydown(event) {
        const menu = document.getElementById('profileMenu');
        const isOpen = menu.classList.contains('show');
        
        if (!isOpen) {
            if (event.key === 'Enter' || event.key === ' ' || event.key === 'ArrowDown') {
                event.preventDefault();
                toggleProfileMenu(event);
            }
            return;
        }
        
        const menuItems = Array.from(menu.querySelectorAll('.profile-item[role="menuitem"]'));
        const currentIndex = menuItems.indexOf(document.activeElement);
        
        switch (event.key) {
            case 'Escape':
                event.preventDefault();
                closeAllDropdowns();
                document.getElementById('userProfileDropdown').focus();
                break;
            case 'ArrowDown':
                event.preventDefault();
                if (currentIndex < menuItems.length - 1) {
                    menuItems[currentIndex + 1].focus();
                } else {
                    menuItems[0].focus();
                }
                break;
            case 'ArrowUp':
                event.preventDefault();
                if (currentIndex > 0) {
                    menuItems[currentIndex - 1].focus();
                } else {
                    menuItems[menuItems.length - 1].focus();
                }
                break;
            case 'Home':
                event.preventDefault();
                menuItems[0].focus();
                break;
            case 'End':
                event.preventDefault();
                menuItems[menuItems.length - 1].focus();
                break;
        }
    }
    
    // Auth modal functionality
    function showAuthModal(mode) {
        closeAllDropdowns();
        const modal = document.getElementById('authModal');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const authTitle = document.getElementById('authTitle');
        const authFooterText = document.getElementById('authFooterText');
        
        if (!modal || !loginForm || !registerForm || !authTitle || !authFooterText) return;
        
        // Reset forms
        loginForm.reset();
        registerForm.reset();
        
        if (mode === 'login') {
            loginForm.style.display = 'flex';
            registerForm.style.display = 'none';
            authTitle.textContent = 'Login to Your Account';
            authFooterText.innerHTML = 'Don\'t have an account? <a href="#" onclick="switchAuthMode(\'register\'); return false;">Register here</a>';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'flex';
            authTitle.textContent = 'Create an Account';
            authFooterText.innerHTML = 'Already have an account? <a href="#" onclick="switchAuthMode(\'login\'); return false;">Login here</a>';
        }
        
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function closeAuthModal() {
        const modal = document.getElementById('authModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }
    
    function switchAuthMode(mode) {
        showAuthModal(mode);
    }
    
    // Legacy functions for backward compatibility
    function showLoginModal() {
        showAuthModal('login');
    }
    
    function showRegisterModal() {
        showAuthModal('register');
    }
    
    function closeLoginModal() {
        closeAuthModal();
    }
    
    function closeRegisterModal() {
        closeAuthModal();
    }
    
    // User action functions
    function viewProfile() {
        if (!<?php echo $isLoggedIn ? 'true' : 'false'; ?>) {
            showAuthModal('login');
            return false;
        }
        window.location.href = '<?php echo $basePath; ?>profile.php';
        return false;
    }
    
    function viewBookings() {
        if (!<?php echo $isLoggedIn ? 'true' : 'false'; ?>) {
            showAuthModal('login');
            return false;
        }
        window.location.href = '<?php echo $basePath; ?>profile.php#bookings';
        return false;
    }
    
    function changePassword() {
        if (!<?php echo $isLoggedIn ? 'true' : 'false'; ?>) {
            showAuthModal('login');
            return false;
        }
        window.location.href = '<?php echo $basePath; ?>profile.php#change-password';
        return false;
    }
    
    function logoutUser() {
        const formData = new FormData();
        formData.append('action', 'logout');
        
        fetch('<?php echo $basePath; ?>php/user_auth.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            showMessage(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            showMessage('Logout failed. Please try again.', 'error');
        });
        return false;
    }
        
        // Helper function to show messages
        function showMessage(message, type) {
            let messageBox = document.getElementById('bookingMessage');
            if (!messageBox) {
                messageBox = document.createElement('div');
                messageBox.id = 'bookingMessage';
                messageBox.className = 'message-box';
                document.body.appendChild(messageBox);
            }
            
            messageBox.textContent = message;
            messageBox.className = `message-box message-${type} show`;
            
            setTimeout(() => {
                messageBox.classList.remove('show');
            }, 5000);
        }
        
        // Loading overlay helpers
        function showLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) overlay.classList.add('show');
        }
        
        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) overlay.classList.remove('show');
        }
        
        // Password visibility toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrengthBar');
            if (!strengthBar) return;
            
            let strength = 0;
            let feedback = '';
            
            // Check length
            if (password.length >= 6) strength += 25;
            if (password.length >= 8) strength += 25;
            
            // Check for mixed case
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 20;
            
            // Check for numbers
            if (password.match(/[0-9]/)) strength += 20;
            
            // Check for special characters
            if (password.match(/[^a-zA-Z0-9]/)) strength += 30;
            
            // Determine strength level
            strengthBar.className = 'password-strength-bar';
            
            if (strength < 40) {
                strengthBar.classList.add('password-strength-weak');
                feedback = 'Weak password';
            } else if (strength < 60) {
                strengthBar.classList.add('password-strength-medium');
                feedback = 'Medium strength';
            } else {
                strengthBar.classList.add('password-strength-strong');
                feedback = 'Strong password';
            }
            
            // Update visual feedback
            const strengthContainer = document.getElementById('passwordStrength');
            if (strengthContainer) {
                strengthContainer.title = feedback;
            }
        }
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const navMenu = document.querySelector('.home_Navmenu');
            
            if (mobileToggle && navMenu) {
                mobileToggle.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });
            }
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.home_Navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Profile dropdown keyboard navigation
            const profileDropdown = document.getElementById('userProfileDropdown');
            if (profileDropdown) {
                profileDropdown.addEventListener('keydown', handleProfileKeydown);
            }
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const profileMenu = document.getElementById('profileMenu');
                const profileButton = document.getElementById('userProfileDropdown');
                
                if (profileMenu && !profileMenu.contains(event.target) && event.target !== profileButton) {
                    closeAllDropdowns();
                }
                
                // Close modal when clicking outside
                const authModal = document.getElementById('authModal');
                if (event.target === authModal) {
                    closeAuthModal();
                }
            });
            
            // Prevent modal close when clicking inside modal content
            document.querySelectorAll('.auth-content').forEach(content => {
                content.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
            
            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAuthModal();
                    closeAllDropdowns();
                }
            });
            
            // Login form submission
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = document.getElementById('loginEmail').value;
                    const password = document.getElementById('loginPassword').value;
                    const submitBtn = loginForm.querySelector('.btn-primary');
                    
                    if (!email || !password) {
                        showMessage('Please enter both email and password', 'error');
                        return;
                    }
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
                    showLoading();
                    
                    const formData = new FormData();
                    formData.append('action', 'login');
                    formData.append('username', email);
                    formData.append('password', password);
                    
                    fetch('<?php echo $basePath; ?>php/user_auth.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
                        
                        if (data.success) {
                            showMessage(data.message, 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
                        showMessage('Login failed. Please try again.', 'error');
                    });
                });
            }
            
            // Registration form submission
            const registerForm = document.getElementById('registerForm');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const name = document.getElementById('registerName').value;
                    const email = document.getElementById('registerEmail').value;
                    const username = document.getElementById('registerUsername').value;
                    const password = document.getElementById('registerPassword').value;
                    const submitBtn = registerForm.querySelector('.btn-primary');
                    
                    if (!name || !email || !username || !password) {
                        showMessage('Please fill in all fields', 'error');
                        return;
                    }
                    
                    if (password.length < 6) {
                        showMessage('Password must be at least 6 characters long', 'error');
                        return;
                    }
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating account...';
                    showLoading();
                    
                    const formData = new FormData();
                    formData.append('action', 'register');
                    formData.append('name', name);
                    formData.append('email', email);
                    formData.append('username', username);
                    formData.append('password', password);
                    
                    fetch('<?php echo $basePath; ?>php/user_auth.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Register';
                        
                        if (data.success) {
                            showMessage(data.message, 'success');
                            registerForm.reset();
                            setTimeout(() => {
                                showLoginModal();
                            }, 2000);
                        } else {
                            showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Register';
                        showMessage('Registration failed. Please try again.', 'error');
                    });
                });
            }
            
            // Smooth scrolling for navigation links
            const navLinks = document.querySelectorAll('.home_Navmenu a');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('href');
                    if (targetId.includes('#')) {
                        e.preventDefault();
                        const targetSection = document.querySelector(targetId.split('#')[1] ? '#' + targetId.split('#')[1] : targetId);
                        if (targetSection) {
                            const offsetTop = targetSection.offsetTop - 80;
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script src="<?php echo $basePath; ?>javascript/home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>