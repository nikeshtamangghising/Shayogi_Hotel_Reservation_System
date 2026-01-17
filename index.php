<?php
$pageTitle = "Home - Hotel Shayogi Reservation System";
include 'includes/header.php';
?>

    <section class="image_Container">
        <img class="img_slide active" src="images/home1.jpg">
        <img class="img_slide" src="images/home2.jpg">
        <img class="img_slide" src="images/home3.jpg">
        <img class="img_slide" src="images/home4.jpg">
        <div class="hotel_details">
            <span>Hotel Shayogi Nepal</span>
            <h1>Enjoy Your Vacation With Us</h1>
        </div>

        <div class="image_Slidernav">
            <div class="nav_btn active"></div>
            <div class="nav_btn"></div>
            <div class="nav_btn"></div>
            <div class="nav_btn"></div>
        </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="home_Findroom">
            <h3 style="text-align: center; color: white; margin-bottom: 20px; font-size: 1.5rem; font-weight: 600;">Find Your Perfect Room</h3>
            <div class="date-row">
                <div>
                    <label for="checkin_Room"><i class="fa-solid fa-calendar-check"></i> Check In Date</label>
                    <input type="date" id="checkin_Room" required>
                </div>
                <div>
                    <label for="checkout_Room"><i class="fa-solid fa-calendar-xmark"></i> Check Out Date</label>
                    <input type="date" id="checkout_Room" required>
                </div>
            </div>
            <div>
                <label for="guestNumber"><i class="fa-solid fa-users"></i> Number of Guests</label>
                <input type="number" id="guestNumber" min="1" max="10" value="1" required>
            </div>
            <button type="button" class="ShowroomOn">
                <i class="fa-solid fa-search"></i> Show Available Rooms
            </button>
        </div>
    </section>
    <section class="home_ShowRooms">
        <div class="roomwrapper">
            <ul class="Roomarea"></ul>
        </div>
    </section>
    <section class="aboutBody" id="about">
        <div class="container">
            <h1>Welcome to Hotel Shayogi</h1>
            <p>
                Discover an oasis of tranquility and luxury at <span>Hotel Shayogi</span>, nestled in the picturesque hills of Nagarkot. 
                With breathtaking views of the Himalayas, our harmonious blend of modern comforts and natural beauty offers an unparalleled escape.
            </p>
            <p>
                Indulge in well-appointed rooms and suites, each with a private balcony framing panoramic vistas, and savor culinary delights 
                that capture local flavors and global cuisine. Rejuvenate in our spa, embark on guided treks, and immerse yourself in the allure of the Himalayas.
            </p>
            <p>
                Whether for <span>relaxation</span>, <span>adventure</span>, or <span>events</span>, Hotel Shayogi promises an unforgettable experience where nature meets luxury.
            </p>
        </div>
    </section>
    <section class="gallerysection" id="gallery">
        <h2 style="text-align: center; color: #2c3e50; font-size: 2.5rem; margin: 40px 0; font-weight: 600;">Our Gallery</h2>
        <div class="gallerywrapper">
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
            <div class="gallery">
                <div class="image" data-name="Room"><span><img src="images/gallery/room_one.jpeg" alt="Hotel Room"></span></div>
                <div class="image" data-name="Exterior"><span><img src="images/gallery/ex_one.jpeg" alt="Hotel Exterior"></span></div>
                <div class="image" data-name="Lobby"><span><img src="images/gallery/lob_one.jpeg" alt="Hotel Lobby"></span></div>
                <div class="image" data-name="Restaurants"><span><img src="images/gallery/res_one.jpeg" alt="Hotel Restaurant"></span></div>
                <div class="image" data-name="Exterior"><span><img src="images/gallery/ex_two.jpeg" alt="Hotel Exterior View"></span></div>
                <div class="image" data-name="Bathroom"><span><img src="images/gallery/bath_one.jpeg" alt="Hotel Bathroom"></span></div>
                <div class="image" data-name="Restaurants"><span><img src="images/gallery/res_two.jpeg" alt="Restaurant Dining"></span></div>
                <div class="image" data-name="Lobby"><span><img src="images/gallery/lob_two.jpg" alt="Lobby Area"></span></div>
            </div>
        </div>
        <div class="preview-box">
            <div class="galleryImgDetails">
                <span class="title">Image Category: <p></p></span>
                <span class="icon fas fa-times"></span>
            </div>
            <div class="image-box">
                <img src="" alt="Preview">
                <div class="preview-nav prev"><i class="fas fa-chevron-left"></i></div>
                <div class="preview-nav next"><i class="fas fa-chevron-right"></i></div>
                <div class="image-counter">1 / 8</div>
                <div class="zoom-controls">
                    <div class="zoom-btn" data-zoom="out"><i class="fas fa-minus"></i></div>
                    <div class="zoom-btn" data-zoom="reset"><i class="fas fa-compress"></i></div>
                    <div class="zoom-btn" data-zoom="in"><i class="fas fa-plus"></i></div>
                </div>
            </div>
        </div>
        <div class="shadow"></div>
    </section>
    <section class="guestReview" id="review">
        <h2 style="text-align: center; color: white; font-size: 2.5rem; margin-bottom: 40px; font-weight: 600;">Guest Reviews</h2>
        <div class="reviewwrapper">
            <i class="fa-solid fa-chevron-left"></i>
            <ul class="Reviewarea"></ul>
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </section>
    <?php
    include 'includes/footer.php';
    ?>
