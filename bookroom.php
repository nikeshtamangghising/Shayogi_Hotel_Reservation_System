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
    <section class="bookRoomSection">
        <?php
// Retrieve the data values from query parameters
$roomId = $_GET["roomId"];
$roomName = $_GET["roomName"];
$roomType = $_GET["roomType"];
$attachBathroom = $_GET["attachBathroom"];
$nonSmokingRoom = $_GET["nonSmokingRoom"];
$totalOccupancy = $_GET["totalOccupancy"];
$availabilities = $_GET["availabilities"];
$price = $_GET["price"];
$ImagePath = $_GET["ImagePath"];
$numberGuest = $_GET["numberGuest"];
$checkOutDate = $_GET["checkOutDate"];
$checkInDate = $_GET["checkInDate"];
?>

        <h1>Hotel Shayogi Nepal</h1>
        <div class="roomBookingDataForm">
            <div>
                <img src="<?php echo $ImagePath; ?>">
                <div class="roomDetailsCard">
                    <input type="text" name="RoomID" value=" <?php echo $roomId; ?>" required>
                    <div>Room Name: <?php echo $roomName; ?></div>
                    <div>Room Type: <?php echo $roomType; ?></div>
                </div>
                <div class="roomDetailsCard">
                    <div>Attach Bathroom: <?php echo $attachBathroom; ?></div>
                    <div>Non-Smoking Room: <?php echo $nonSmokingRoom; ?></div>
                </div>
                <div class="roomDetailsCard">
                    <div>Total Occupancy: <?php echo $totalOccupancy; ?></div>
                    <div>Availabilities: <?php echo $availabilities; ?></div>
                </div>
                <div class="roomDetailsCard">
                    <div>Price: <?php echo $price; ?></div>
                </div>

                <div>
                    <div class="inputField">
                        <input type="text" name="fullName" id="fullName" required>
                        <label for="fullName">Full Name</label>
                    </div>
                    <div class="inputField" id="guestEmail">
                        <input type="email" name="guestEmail" id="guestEmail" required>
                        <label for="guestEmail">Email</label>
                        <input type="text" name="guestCountry" id="guestCountry" required>
                        <label for="guestCountry">Country</label>
                    </div>
                    <div class="inputField">
                        <input type="number" name="guestPhone" id="guestPhone" required>
                        <label for="guestPhone">Phone Number</label>
                        <input type="text" name="guestVerifyID" id="guestVerifyID" required>
                        <label for="guestVerifyID">ID Verification</label>
                    </div>
                    <div class="book_RoomButton">
                        <button class="book_Room_Button" data-roomid="<?php echo $roomId; ?>"
                            data-guestno="<?php echo $numberGuest; ?>" data-checkin="<?php echo $checkInDate; ?>"
                            data-checkout="<?php echo $checkOutDate; ?>">Book Room</button>
                    </div>

                </div>


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

    <script src="javascript/book.js"></script>
</body>

</html>