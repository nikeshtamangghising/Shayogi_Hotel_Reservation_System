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
        <form action="php/your_registration_script.php" method="post" enctype="multipart/form-data">
            <div class="Login_Title">
                <h3 class="form_title">Register Now</h3>
            </div>
            <div class="Login">
                <div class=" Register_formLeft">
                    <label for="GsfullName" class="label_title">Full Name:</label>
                    <input type="text" id="GsfullName" name="FullName" required>

                    <label for="Gsemail" class="label_title">Email:</label>
                    <input type="email" id="Gsemail" name="Email" required>

                    <label for="Gsphone" class="label_title">Phone:</label>
                    <input type="tel" id="Gsphone" name="Phone" required>

                    <label for="GsidVerification" class="label_title">ID Verification:</label>
                    <input type="text" id="GsidVerification" name="ID_Verification" required>
                </div>
                <div class="Register_formRight">
                    <label for="Gscountry" class="label_title">Country:</label>
                    <input type="text" id="Gscountry" name="Country" required>

                    <label for="Gsusername" class="label_title">Username:</label>
                    <input type="text" id="Gsusername" name="Username" required>

                    <label for="Gspassword" class="label_title">Password:</label>
                    <input type="password" id="Gspassword" name="Password" autocomplete="current-password" required>


                    <label for="Guest_image" class="label_title">Image Path:</label>
                    <div>
                        <input type="file" id="Guest_image" name="Guest_image" accept="image/*" required>
                    </div>
                </div>
            </div>
            <div class="Login_button">
                <button type="submit" class="button-79">Sign Up</button>
                <p style="color:white;padding:2rem 0 0 0;">Already have an account? <a href="Login.php"
                        style="color:#91834A">Login now</a></p>
            </div>
        </form>
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