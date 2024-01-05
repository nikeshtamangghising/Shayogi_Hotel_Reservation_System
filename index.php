<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sahyogi Reservation System</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- header section starts  -->
    <?php include 'component/header.php'; ?>
    <!-- header section ends -->
    <section class="image_Container">
        <img class="img_slide active" src="Image/home1.jpg">
        <img class="img_slide" src="Image/home2.jpg">
        <img class="img_slide" src="Image/home3.jpg">
        <img class="img_slide" src="Image/home4.jpg">
        <div class="hotel_details">
            <span>Hotel Shayogi Nepal</span>
            <h1>Enjoy Your <br> Vacation With <br>Us</h1>
        </div>

        <div class="image_Slidernav">
            <div class="nav_btn active"></div>
            <div class="nav_btn"></div>
            <div class="nav_btn"></div>
            <div class="nav_btn"></div>
        </div>
        </div>
        <div class="home_Findroom">
            <label>Check In Date: </label>
            <input type="date" id="checkin_Room">
            <label>Check Out Date: </label>
            <input type="date" id="checkout_Room">
            <label>Number of Guest: </label>
            <input type="number" id="guestNumber">
            <input type="button" value="Show Room" class="ShowroomOn">
        </div>
    </section>
    <section class="home_ShowRooms">
        <div class="roomwrapper">
            <ul class="Roomarea"></ul>
        </div>
    </section>
    <section class="aboutBody" id="about">
        <h1>Welcome to Hotel Shayogi</h1>
        <p><span></span>Discover an oasis of tranquility and luxury at Hotel Shayogi, nestled in the picturesque hills
            of
            Nagarkot.
            With
            breathtaking views of the Himalayas, our harmonious blend of modern comforts and natural beauty offers
            an
            unparalleled escape. Indulge in well-appointed rooms and suites, each with a private balcony framing
            panoramic
            vistas, and savor culinary delights that capture local flavors and global cuisine. Rejuvenate in our
            spa,
            embark
            on guided treks, and immerse yourself in the allure of the Himalayas. Whether for relaxation, adventure,
            or
            events, Hotel Shayogi promises an unforgettable experience where nature meets luxury.</p>
    </section>
    <sectiom class="gallerysection" id="gallery">
        <div class="gallerywrapper">
            <!-- filter galleryitems -->
            <nav>
                <div class="galleryitems">
                    <span class="item active" data-name="all">All</span>
                    <span class="item" data-name="Room">Room</span>
                    <span class="item" data-name="Restaurants">Restaurants</span>
                    <span class="item" data-name="Bathroom">Bathroom</span>
                    <span class="item" data-name="Lobby">Lobby</span>
                    <span class="item" data-name="Exterior">Exterior</span>
                </div>
            </nav>
            <!-- filter Images -->
            <div class="gallery">
                <div class="image" data-name="Room"><span><img src="Image/Gallery/room_one.jpeg" alt=""></span></div>
                <div class="image" data-name="Exterior"><span><img src="Image/Gallery/ex_one.jpeg" alt=""></span></div>
                <div class="image" data-name="Lobby"><span><img src="Image/Gallery/lob_one.jpeg" alt=""></span></div>
                <div class="image" data-name="Restaurants"><span><img src="Image/Gallery/res_one.jpeg" alt=""></span>
                </div>
                <div class="image" data-name="Exterior"><span><img src="Image/Gallery/ex_two.jpeg" alt=""></span></div>
                <div class="image" data-name="Bathroom"><span><img src="Image/Gallery/bath_one.jpeg" alt=""></span>
                </div>
                <div class="image" data-name="Restaurants"><span><img src="Image/Gallery/res_two.jpeg" alt=""></span>
                </div>
                <div class="image" data-name="Lobby"><span><img src="Image/Gallery/lob_two.jpg" alt=""></span></div>
            </div>
        </div>
        <!-- fullscreen img preview box -->
        <div class="preview-box">
            <div class="galleryImgDetails">
                <span class="title">Image Category: <p></p></span>
                <span class="icon fas fa-times"></span>
            </div>
            <div class="image-box"><img src="" alt=""></div>
        </div>
        <div class="shadow"></div>
    </sectiom>
    <section class="guestReview" id="review">
        <div class="reviewwrapper">
            <i class="fa-solid fa-chevron-left"></i>
            <ul class="Reviewarea"></ul>
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </section>

    <!-- footer section starts  -->
    <?php include 'component/footer.php'; ?>
    <!-- footer section ends -->
    <script src="javascript/home.js"></script>
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