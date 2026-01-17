$(document).ready(function () {
    // Helper functions for messages
    function showError(message) {
        const $errorMsg = $('#error_msg');
        $errorMsg.removeClass('success warning').addClass('error').html(message);
        $errorMsg.show();
        
        // Shake animation
        $errorMsg.addClass('shake');
        setTimeout(function() {
            $errorMsg.removeClass('shake');
        }, 500);
    }
    
    function showSuccess(message) {
        const $errorMsg = $('#error_msg');
        $errorMsg.removeClass('error warning').addClass('success').html(message);
        $errorMsg.show();
        
        // Bounce animation
        $errorMsg.addClass('bounce');
        setTimeout(function() {
            $errorMsg.removeClass('bounce');
        }, 1000);
    }
    
    function showWarning(message) {
        const $errorMsg = $('#error_msg');
        $errorMsg.removeClass('error success').addClass('warning').html(message);
        $errorMsg.show();
    }
    
    $('#login_Form').on('submit', function (e) {
        e.preventDefault();
        
        const $button = $('#LoginIn');
        const $errorMsg = $('#error_msg');
        
        // Add loading state
        $button.addClass('loading').prop('disabled', true);
        $errorMsg.removeClass('success error warning').html('');
        
        let username = $('input[name="username"]').val().trim();
        let password = $('input[name="password"]').val().trim();
        
        // Enhanced validation
        if (!username) {
            showError('Please enter your username');
            $button.removeClass('loading').prop('disabled', false);
            return;
        }
        
        if (!password) {
            showError('Please enter your password');
            $button.removeClass('loading').prop('disabled', false);
            return;
        }
        
        if (password.length < 6) {
            showError('Password must be at least 6 characters');
            $button.removeClass('loading').prop('disabled', false);
            return;
        }
        
        // Check for remember me
        const rememberMe = $('#remember').is(':checked');
        
        // AJAX request payload (keys match PHP expectations)
        const data = {
            Username: username,
            Password: password,
            Remember: rememberMe ? 1 : 0
        };
        
        $.ajax({
            url: 'Login/Login.php',
            method: 'POST',
            data: data,
            dataType: 'text',
            beforeSend: function() {
                $button.find('.btn-text').html('Authenticating...');
            },
            success: function (response) {
                $button.removeClass('loading').prop('disabled', false);
                $button.find('.btn-text').html('Sign In');

                console.log('Server response:', response); // Debug log
                
                if (response.trim() === "Success") {
                    showSuccess('Login successful! Redirecting to dashboard...');
                    setTimeout(function() {
                        window.location.href = "dashboard.php";
                    }, 1200);
                } else {
                    // Clean up the error message
                    let errorMsg = response.trim();
                    if (errorMsg.includes('Warning:')) {
                        errorMsg = errorMsg.replace('Warning:', '').trim();
                    }
                    if (errorMsg.includes('Unknown User')) {
                        errorMsg = 'Invalid username or password';
                    }
                    showError(errorMsg);
                }
            },
            error: function(xhr, status, error) {
                $button.removeClass('loading').prop('disabled', false);
                $button.find('.btn-text').html('Sign In');
                showError('Connection error. Please check your internet and try again.');
            }
        });
        
        // Don't reset form on error so user can see what they typed
    });
    
    // Password visibility toggle
    $('.password-toggle').on('click', function() {
        const $icon = $(this).find('i');
        const $input = $('#password');
        const isVisible = $input.attr('type') === 'text';

        $input.attr('type', isVisible ? 'password' : 'text');
        $icon.toggleClass('fa-eye fa-eye-slash');
    });
    
    // Input focus effects
    $('input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Forgot password handler
    $('.forgot-link').on('click', function(e) {
        e.preventDefault();
        showWarning('Password reset functionality coming soon!');
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        if (e.key === 'Enter') {
            $('#login_Form').submit();
        }
    });
});
