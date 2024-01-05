<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sahyogi Reservation System</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/loginsignup.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- header section starts  -->
    <?php include 'component/header.php'; ?>
    <!-- header section ends -->
    <section class="Login_Signup">
        <div class="Login_Title">
            <h3 class="form_title">Register Now</h3>
        </div>
        <div class="Login">
            <div class="Register_formRight">
                <label for="username" class="label_title">Username | Email:</label>
                <input type="text" id="username" name="username" required>

                <label for="password" class="label_title">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
        </div>
        <div class="Login_button">
            <button type="submit" class="button-79">
                Submit
            </button>
            <p style="color:white;padding:2rem 0 0 0;">Not have an account? <a href="Signup.php"
                    style="color:#91834A">signup now</a></p>
        </div>
        </div>
    </section>
    <!-- footer section starts  -->
    <?php include 'component/footer.php'; ?>
    <!-- footer section ends -->
    <script src="javascript/Login_Signup.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggleBtn = document.querySelector("#menuBtn");
        const menu = document.querySelector(".User_Menu");

        toggleBtn.addEventListener("click", () => {
            menu.classList.toggle("menu-visible");
        });
    });
    </script>

</body>

</html>