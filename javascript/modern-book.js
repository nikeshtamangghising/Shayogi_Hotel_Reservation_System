// Modern Booking Form JavaScript
$(document).ready(function() {
    
    // Form submission handler
    $('#bookingForm').on('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted!');
        
        const $submitBtn = $(this).find('button[type="submit"]');
        const $messageBox = $('#bookingMessage');
        
        console.log('Submit button found:', $submitBtn.length);
        console.log('Message box found:', $messageBox.length);
        
        // Show loading state
        $submitBtn.addClass('loading').prop('disabled', true);
        $messageBox.removeClass('success error warning').html('');
        
        // Get form data
        const formData = {
            roomId: $('input[name="roomId"]').val(),
            fullName: $('input[name="fullName"]').val().trim(),
            guestEmail: $('input[name="guestEmail"]').val().trim(),
            guestPhone: $('input[name="guestPhone"]').val().trim(),
            guestCountry: $('input[name="guestCountry"]').val().trim(),
            guestVerifyID: $('input[name="guestVerifyID"]').val().trim(),
            numberGuest: $('input[name="numberGuest"]').val(),
            checkInDate: $('input[name="checkInDate"]').val(),
            checkOutDate: $('input[name="checkOutDate"]').val()
        };
        
        console.log('Form data:', formData);
        
        // Client-side validation
        const validation = validateBookingForm(formData);
        if (!validation.isValid) {
            console.log('Validation failed:', validation.message);
            showMessage(validation.message, 'error');
            $submitBtn.removeClass('loading').prop('disabled', false);
            return;
        }
        
        console.log('Validation passed, sending AJAX request...');
        
        // AJAX submission
        $.ajax({
            url: 'php/book_room.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                const $icon = $submitBtn.find('i');
                const $text = $submitBtn.find('.btn-text');
                
                $icon.removeClass('fa-check').addClass('fa-spinner fa-spin');
                if ($text.length) {
                    $text.text('Processing...');
                } else {
                    $submitBtn.html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');
                }
            },
            success: function(response) {
                console.log('Booking response:', response);
                
                $submitBtn.removeClass('loading').prop('disabled', false);
                const $icon = $submitBtn.find('i');
                const $text = $submitBtn.find('.btn-text');
                
                $icon.addClass('fa-check').removeClass('fa-spinner fa-spin');
                if ($text.length) {
                    $text.text('Confirm Reservation');
                }
                
                if (response.success) {
                    showMessage(response.message || 'Booking confirmed! Redirecting to your bookings...', 'success');
                    setTimeout(function() {
                        window.location.href = response.redirect || 'profile.php#bookings';
                    }, 2000);
                } else {
                    showMessage(response.message || 'Booking failed. Please try again.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Booking error:', xhr.responseText, status, error);
                
                $submitBtn.removeClass('loading').prop('disabled', false);
                const $icon = $submitBtn.find('i');
                const $text = $submitBtn.find('.btn-text');
                
                $icon.addClass('fa-check').removeClass('fa-spinner fa-spin');
                if ($text.length) {
                    $text.text('Confirm Reservation');
                }
                
                showMessage('Connection error. Please check your internet and try again.', 'error');
            }
        });
    });
    
    // Real-time validation
    $('input, select').on('input change', function() {
        const field = $(this);
        const value = field.val().trim();
        const fieldName = field.attr('name');
        
        // Remove previous validation states
        field.removeClass('error');
        field.next('.error-message').remove();
        
        // Real-time validation
        if (value) {
            switch(fieldName) {
                case 'fullName':
                    if (value.length < 2) {
                        showFieldError(field, 'Name must be at least 2 characters');
                    } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                        showFieldError(field, 'Name should only contain letters');
                    }
                    break;
                case 'guestEmail':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        showFieldError(field, 'Please enter a valid email address');
                    }
                    break;
                case 'guestPhone':
                    const phoneRegex = /^[\+]?[0-9\s\-\(\)]{7,15}$/;
                    if (!phoneRegex.test(value)) {
                        showFieldError(field, 'Please enter a valid phone number');
                    }
                    break;
                case 'guestCountry':
                    if (value.length < 2) {
                        showFieldError(field, 'Country name must be at least 2 characters');
                    }
                    break;
                case 'guestVerifyID':
                    if (value.length < 4) {
                        showFieldError(field, 'ID must be at least 4 characters');
                    }
                    break;
            }
        }
    });
    
    // Input focus effects
    $('input').on('focus', function() {
        $(this).parent('.form-group').addClass('focused');
    }).on('blur', function() {
        $(this).parent('.form-group').removeClass('focused');
    });
    
    // Helper functions
    function validateBookingForm(data) {
        const errors = [];
        
        if (!data.fullName || data.fullName.length < 2) {
            errors.push('Full name is required (min 2 characters)');
        }
        
        if (!data.guestEmail || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.guestEmail)) {
            errors.push('Valid email address is required');
        }
        
        if (!data.guestPhone || !/^[\+]?[0-9\s\-\(\)]{7,15}$/.test(data.guestPhone)) {
            errors.push('Valid phone number is required');
        }
        
        if (!data.guestCountry || data.guestCountry.length < 2) {
            errors.push('Country is required (min 2 characters)');
        }
        
        if (!data.guestVerifyID || data.guestVerifyID.length < 4) {
            errors.push('ID number is required (min 4 characters)');
        }
        
        return {
            isValid: errors.length === 0,
            message: errors.length > 0 ? errors.join(', ') : null
        };
    }
    
    function showFieldError(field, message) {
        field.addClass('error');
        if (!field.next('.error-message').length) {
            field.after('<div class="error-message">' + message + '</div>');
        }
    }
    
    function showMessage(message, type) {
        const $messageBox = $('#bookingMessage');
        $messageBox.removeClass('success error warning').addClass(type).html(message);
        
        // Auto-hide success messages
        if (type === 'success') {
            setTimeout(function() {
                $messageBox.fadeOut();
            }, 5000);
        }
    }
    
    // Smooth scroll to form on errors
    function scrollToForm() {
        $('html, body').animate({
            scrollTop: $('.booking-form').offset().top - 100
        }, 800);
    }
    
    // Form field animations
    $('.form-group').each(function() {
        const $group = $(this);
        const $input = $group.find('input');
        const $label = $group.find('label');
        const $icon = $group.find('.input-icon');
        
        $input.on('focus', function() {
            $label.css({
                transform: 'translateY(-25px) scale(0.8)',
                color: '#3498db'
            });
            $icon.css({
                transform: 'translateY(-25px) scale(1.2)',
                color: '#3498db'
            });
        });
        
        $input.on('blur', function() {
            $label.css({
                transform: 'translateY(0) scale(1)',
                color: '#2c3e50'
            });
            $icon.css({
                transform: 'translateY(0) scale(1)',
                color: '#6c757d'
            });
        });
    });
    
    // Add floating labels functionality
    $('.form-group input').each(function() {
        const $input = $(this);
        const $label = $input.prev('label');
        
        $input.on('input', function() {
            if ($(this).val()) {
                $label.addClass('active');
            } else {
                $label.removeClass('active');
            }
        });
    });
    
    // Room card hover effects
    $('.feature-card').hover(
        function() {
            $(this).find('.feature-icon i').addClass('bounce');
        },
        function() {
            $(this).find('.feature-icon i').removeClass('bounce');
        }
    );
    
    // Date validation
    function validateDates(checkIn, checkOut) {
        const checkInDate = new Date(checkIn);
        const checkOutDate = new Date(checkOut);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (checkInDate < today) {
            return false;
        }
        
        if (checkOutDate <= checkInDate) {
            return false;
        }
        
        return true;
    }
});
