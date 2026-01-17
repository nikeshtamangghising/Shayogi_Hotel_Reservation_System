// Modern Dashboard JavaScript
$(document).ready(function() {
    
    // Initialize calendar and load data
    renderCalendar();
    showRoomData();
    show_Data();
    
    // Mobile Menu Toggle
    $('#menuToggle').on('click', function() {
        $('.sidebar').toggleClass('active');
    });
    
    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('#menuToggle').length) {
                $('.sidebar').removeClass('active');
            }
        }
    });
    
    // Navigation Active State
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all links
        $('.nav-link').removeClass('active');
        
        // Add active class to clicked link
        $(this).addClass('active');
        
        // Get target page
        const targetPage = $(this).data('page');
        
        // Hide all pages
        $('.page').hide();
        
        // Show target page
        $(`#${targetPage}-page`).show();
        
        // Update page title
        const pageTitle = $(this).find('span').text();
        $('.page-title').text(pageTitle);
        
        // Load data for specific pages
        if (targetPage === 'rooms') {
            showRoomData();
        } else if (targetPage === 'users') {
            show_Data();
        }
        
        // Close mobile sidebar
        if ($(window).width() <= 768) {
            $('.sidebar').removeClass('active');
        }
        
        // Add fade-in animation
        $(`#${targetPage}-page`).css('animation', 'fadeIn 0.5s ease-out');
    });
    
    // Search Functionality
    $('.search-bar input').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        // Here you would implement actual search functionality
        console.log('Searching for:', searchTerm);
    });
    
    // Notification Click Handler
    $('.notification-btn').on('click', function() {
        // Here you would show notification dropdown
        console.log('Notifications clicked');
        
        // Remove notification badge
        $('.notification-badge').hide();
    });
    
    // Quick Action Buttons
    $('.action-btn').on('click', function() {
        const action = $(this).find('span').text();
        console.log('Quick action:', action);
        
        // Here you would implement actual actions
        switch(action) {
            case 'Add User':
                openBtn('#Add_User');
                break;
            case 'Add Room':
                openBtn('#addRoom');
                break;
            case 'New Booking':
                showNotification('Opening booking form...', 'info');
                break;
            case 'Export Data':
                showNotification('Exporting data...', 'info');
                break;
        }
    });
    
    // Quick Actions Bar Buttons
    $('.quick-actions-bar .btn').on('click', function() {
        const buttonText = $(this).text().trim();
        console.log('Quick action bar clicked:', buttonText);
        
        // Actions are handled by onclick attributes in HTML
    });
    
    // Booking Item Click Handler
    $('.booking-item').on('click', function() {
        const bookingName = $(this).find('.booking-name').text();
        console.log('Booking clicked:', bookingName);
        
        // Here you would show booking details
        showNotification(`Viewing details for ${bookingName}`, 'info');
    });
    
    // View All Button
    $('.btn-sm').on('click', function() {
        // Navigate to bookings page
        $('.nav-link[data-page="bookings"]').click();
    });
    
    // Header User Click
    $('.header-user').on('click', function() {
        // Here you would show user dropdown
        console.log('User profile clicked');
    });
    
    // Logout Confirmation
    $('.logout-btn').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = $(this).attr('href');
        }
    });
    
    // Modal Functions (from original winCon.js)
    window.openBtn = function(selector) {
        // First hide all modals and legacy windows
        $('.modal, #Manage_User, #manageRoom').removeClass('active').hide();
        
        // Show the selected modal/window
        if (selector.startsWith('#')) {
            $(selector).show().addClass('active');
        }
        
        $('body').css('overflow', 'hidden');
    };
    
    window.clsBtn = function(selector) {
        $(selector).hide().removeClass('active');
        $('body').css('overflow', 'auto');
    };
    
    // Handle date click for calendar
    window.handleDateClick = function(day) {
        const selectedDate = new Date(currYear, currMonth, day);
        const dateStr = selectedDate.toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        $('#selectedDateDisplay').text(dateStr);
        
        // Here you would load bookings for the selected date
        console.log('Selected date:', selectedDate);
        
        // Update booking summary (mock data)
        $('#availableRooms').text(Math.floor(Math.random() * 20) + 10);
        $('#bookedRooms').text(Math.floor(Math.random() * 10) + 1);
    };
    
    // Notification System
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = $(`
            <div class="notification notification-${type}">
                <i class="fa-solid fa-${getNotificationIcon(type)}"></i>
                <span>${message}</span>
                <button class="notification-close">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `);
        
        // Add notification styles if not already present
        if (!$('#notification-styles').length) {
            $('head').append(`
                <style id="notification-styles">
                    .notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: white;
                        padding: 15px 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        z-index: 9999;
                        min-width: 300px;
                        animation: slideInRight 0.3s ease-out;
                    }
                    .notification-success {
                        border-left: 4px solid var(--success-color);
                    }
                    .notification-error {
                        border-left: 4px solid var(--accent-color);
                    }
                    .notification-warning {
                        border-left: 4px solid var(--warning-color);
                    }
                    .notification-info {
                        border-left: 4px solid var(--info-color);
                    }
                    .notification-close {
                        background: none;
                        border: none;
                        cursor: pointer;
                        padding: 0;
                        margin-left: auto;
                        color: var(--text-muted);
                    }
                    .notification-close:hover {
                        color: var(--text-dark);
                    }
                    @keyframes slideInRight {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    @keyframes slideOutRight {
                        from {
                            transform: translateX(0);
                            opacity: 1;
                        }
                        to {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                    }
                </style>
            `);
        }
        
        // Add to body
        $('body').append(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.css('animation', 'slideOutRight 0.3s ease-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
        
        // Manual close
        notification.find('.notification-close').on('click', function() {
            notification.css('animation', 'slideOutRight 0.3s ease-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
    }
    
    function getNotificationIcon(type) {
        switch(type) {
            case 'success': return 'check-circle';
            case 'error': return 'exclamation-circle';
            case 'warning': return 'exclamation-triangle';
            case 'info': return 'info-circle';
            default: return 'info-circle';
        }
    }
    
    // Initialize tooltips and other interactive elements
    $('[title]').each(function() {
        $(this).attr('data-tooltip', $(this).attr('title'));
        $(this).removeAttr('title');
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('.sidebar').removeClass('active');
        }
    });
    
    // Initialize page
    console.log('Dashboard initialized successfully!');
});
