<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shayogi Hotel Booking Reservation System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Login/style.css">
</head>

<body>
    <div class="loginPage">
        <div class="loginBox">
            <h2>Admin Login Panel</h2>
        <form id="login_Form">
            <div class="infeld">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="Username" placeholder="Type Your Username">
            </div>
            <div class="infeld">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="Password" placeholder="Type Your Password">
            </div>
            <div class="msgLogin">
            <button id="LoginIn">Login In</button><br>
                        <div id="error_msg"></div>
                        </div>
                    </form>
        </div>
    </div>
    <script src="Login/Login.js"></script>
</body>

</html>
