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
    <div id="home"></div>
    <section class="home_Navbar">
        <div class="logopart">
            <img src="Image/Hotel/logoblack.png" alt="Hotel Shayogi Logo System">
        </div>
        <div>
            <ul class="home_Navmenu">
                <li> <a href="#home">Home</a> </li>
                <li> <a href="#about">About</a> </li>
                <li> <a href="#gallery">Gallery</a> </li>
                <li> <a href="#review">Guest Review</a> </li>
                <li> <a href="#contact">Contact</a> </li>
            </ul>
        </div>
        <div class="navbar_rightside">
            <a href="#"><i class="fa-brands fa-instagram"></i></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-solid fa-circle-user"></i></a>
        </div>
    </section>
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
    <section class="footer_container" id="contact">
        <div class="upperFooter">
            <div>
                <ul>
                    <li id="headingfoot">Contact Info</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-address-book"><a href="#"></i>Shree
                        Krishna
                        Karki</a></li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-address-book"><a href="#"></i>Nikesh
                        Tamang</a></li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-phone"></i>+977 9861171281</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-location-dot"></i>Bhaktapur, Nepal
                    </li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-brands fa-whatsapp"></i>+977 9865214521</li>
                </ul>
            </div>

            <div>
                <ul>
                    <li id="headingfoot">Services</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-mug-saucer"></i>Delicious Breakfast
                    </li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-square-parking"></i>24 Hour Parking
                    </li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-wifi"></i>WiFi Internet</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-broom"></i>Room Service</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-car"></i>Car Rentals</li>
                </ul>
            </div>

            <div>
                <ul>
                    <li id="headingfoot">Services</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-address-book"></i>Delicious
                        Breakfast
                    </li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-address-book"></i>24 Hour Parking
                    </li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-phone"></i>WiFi Internet</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-solid fa-location-dot"></i>Room Service</li>
                    <li id="contentfoot" id="contentfoot"><i class="fa-brands fa-whatsapp"></i>Car Rentals</li>
                </ul>
            </div>
        </div>
        <div class="foottext">
            <span id="footersocial"><span id="headingfoot">Social Account:</span><i class="fa-brands fa-facebook"><a
                        href="#"></i>Facebook</a></span>
            <span id="footersocial"><i class="fa-brands fa-instagram"></i><a href="#"></href>Instagram</a></span>
            <span id="footersocial"><i class="fa-brands fa-tiktok"></i><a href="#">Tiktok</a></span>
            <span id="footersocial"><i class="fa-brands fa-twitter"></i><a href="#">Twitter</a></span>
        </div>

        <footer>
            <div>Shayogi Reservation System</div>
            <div>Copyright © Shayogi. All Rights Reserved.</div>
            <div></div>
        </footer>
    </section>

    <script src="javascript/home.js"></script>
</body>

</html>
