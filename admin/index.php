<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hotel Shayogi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Login/style.css">
</head>

<body>
    <div class="loginPage">
        <div class="loginBox">
            <div class="login-info">
                <div class="logo">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <h2>Hotel Shayogi</h2>
                <p class="subtitle">Central operations dashboard</p>
                <ul class="info-points">
                    <li><i class="fa-solid fa-shield"></i> Secure access</li>
                    <li><i class="fa-solid fa-chart-line"></i> Real-time overview</li>
                    <li><i class="fa-solid fa-gear"></i> Manage reservations</li>
                </ul>
            </div>

            <div class="login-form-wrapper">
                <div class="login-header">
                    <p class="tag">Administrator</p>
                    <h2>Sign in to continue</h2>
                </div>

                <form id="login_Form" class="modern-form" method="post" novalidate>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="username" name="username"
                                   placeholder="Enter your admin username"
                                   autocomplete="username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="password" name="password"
                                   placeholder="Enter your password"
                                   autocomplete="current-password" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="remember" name="remember">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                        <a href="#" class="forgot-link">Need help?</a>
                    </div>

                    <div class="form-actions">
                        <button type="submit" id="LoginIn" class="btn-primary">
                            <span class="btn-text">Sign In</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>

                    <div id="error_msg" class="message-box" role="status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="Login/Login.js"></script>
</body>

</html>
