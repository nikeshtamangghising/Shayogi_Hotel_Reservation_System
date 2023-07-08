<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS Section Start -->
    <link rel="stylesheet" href="dashboard/css/dashboard.css">
    <link rel="stylesheet" href="dashboard/css/taskbar.css">
    <link rel="stylesheet" href="dashboard/css/menu.css">
    <link rel="stylesheet" href="dashboard/css/fileExplorer.css" defer>
    <!-- CSS Section End -->
</head>

<body>
    <div id="c_Panel">
        <!-- Navbar Section Start -->
        <div id="nav_Bar"></div>
        <!-- Navbar Section End -->

        <!-- Body Section Start -->
        <div id="content_Body">
            <!-- Manage USER WINDOW -->
            <div id="Manage_User">
                <div class="file_Explorer">
                    <div class="title_Explorer">
                        <div>
                            <button type="button" onclick="clsBtn('Manage_User')">
                                <img src="img/button/Close_Button.svg" alt="Close Button">
                            </button>
                            <button type="button" onclick="exp_Btn('Manage_User')">
                                <img src="img/button/Maximize_Button.svg" alt="Expand Button">
                            </button>
                            <button type="button">
                                <img src="img/button/Minimize_Button.svg" alt="Minimize Button">
                            </button>
                        </div>
                        <div class="windowHeading">Manage User</div>
                        <div>
                            <button type="button" id="btn_adduser">
                                <img src="img/button/adduser.png" alt="Add User Button">
                            </button>
                        </div>
                    </div>
                    <div class="explorer_Box">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="t_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add USER WINDOW -->
            <div id="Add_User">
                <div class="file_Explorer">
                    <div class="title_Explorer">
                        <div class="title_adjust">
                            <div class="title_Btn">
                                <button type="button" onclick="clsBtn('Add_User')">
                                    <img src="img/button/Close_Button.svg" alt="Close Button">
                                </button>
                                <button type="button" onclick="exp_Btn('Add_User')">
                                    <img src="img/button/Maximize_Button.svg" alt="Expand Button">
                                </button>
                                <button type="button">
                                    <img src="img/button/Minimize_Button.svg" alt="Minimize Button">
                                </button>
                            </div>
                            <div class="title_heading">Add User</div>
                        </div>
                    </div>
                    <div class="explorer_Box">
                        <div class="addUserData">
                            <form id="add_LoginUser">
                                <div class="inputField">
                                    <input type="text" name="Name" required>
                                    <label for="name">Name</label>
                                </div>
                                <div class="inputField">
                                    <input type="text" name="Username" required>
                                    <label for="username">Username</label>
                                </div>
                                <div class="inputField">
                                    <input type="password" name="Password" required>
                                    <label for="password">Password</label>
                                </div>
                                <div class="inputField">
                                    <input type="email" name="Email" required>
                                    <label for="email">Email</label>
                                </div>

                                <button id="add_User">Add User</button>
                                <button id="edit_User">Edit User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu Section Start -->
            <div id="explorerBox">
                <div class="menuBox">
                    <button onclick="openBtn('Manage_User')">
                        <img src="img/button/manageuser.png" alt="Manage User" class="menuImg"><br>Manage User
                    </button>
                    <button onclick="openBtn('staff_Section')">
                        <img src="img/button/managestaff.png" alt="Manage Staff" class="menuImg"><br>Manage Staff
                    </button>
                    <button onclick="openBtn('manageRoom')">
                        <img src="img/button/manageroom.png" alt="Manage Room" class="menuImg"><br>Manage Room
                    </button><br>
                    <button>Manage User</button>
                    <button>Manage User</button>
                    <button>Manage User</button>
                    <button>Manage User</button>
                    <button>Manage User</button>
                </div>
            </div>
            <!--Manage Room-->
            <div id="manageRoom">
                <div class="file_Explorer">
                    <div class="title_Explorer">
                        <div>
                            <button type="button" onclick="clsBtn('manageRoom')">
                                <img src="img/button/Close_Button.svg" alt="Close Button">
                            </button>
                            <button type="button" onclick="exp_Btn('manageRoom')">
                                <img src="img/button/Maximize_Button.svg" alt="Expand Button">
                            </button>
                            <button type="button">
                                <img src="img/button/Minimize_Button.svg" alt="Minimize Button">
                            </button>
                        </div>
                        <div class="windowHeading">Manage Rooms</div>
                        <div class="rightNavBar">
                            <button type="button" onclick="openBtn('addRoom')">
                                <img src="img/button/add.png" alt="Add Button"><img src="img/button/room.png"
                                    alt="Rooms">
                            </button>
                        </div>
                    </div>
                    <div class="explorer_Box">
                        <table>
                            <thead>
                                <tr>
                                    <th>Custom No</th>
                                    <th>Room</th>
                                    <th>Bed Type</th>
                                    <th>Number of Bed</th>
                                    <th>Attach Bathroom</th>
                                    <th>Non-Smoking Room</th>
                                    <th>Total occupancy</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="roomdataTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Staff Section End -->
            <!-- Room Section Start -->
            <div id="addRoom">
                <div class="file_Explorer">
                    <div class="title_Explorer">
                        <div class="title_adjust">
                            <div class="title_Btn">
                                <button type="button" onclick="clsBtn('addRoom')">
                                    <img src="img/button/Close_Button.svg" alt="Close Button">
                                </button>
                                <button type="button" onclick="exp_Btn('addRoom')">
                                    <img src="img/button/Maximize_Button.svg" alt="Expand Button">
                                </button>
                                <button type="button">
                                    <img src="img/button/Minimize_Button.svg" alt="Minimize Button">
                                </button>
                            </div>
                            <div class="title_heading">Manage Room</div>
                        </div>
                    </div>
                    <div class="explorer_Box">
                        <form>
                            <div class="inputField" id="inputFieldcustomname" data-division="room">
                                <input type="text" name="customname" required>
                                <label for="customname">Custom Name</label>
                            </div>
                            <div data-division="room">
                                <select id="room-select">
                                    <option value="" disabled selected>Select a Room Type</option>
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                    <option value="Twin/Double">Twin/Double</option>
                                    <option value="Triple">Triple</option>
                                    <option value="Quad">Quad</option>
                                    <option value="Family">Family</option>
                                    <option value="Suite">Suite</option>
                                    <option value="Studio">Studio</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Dorm Room">Dorm Room</option>
                                    <option value="Bed in Dorm">Bed in Dorm</option>
                                    <option value="Vacation Home">Vacation Home</option>
                                    <option value="Trailer">Trailer</option>
                                    <option value="Tent">Tent</option>
                                </select>
                            </div>
                            <div data-division="room">
                                <select id="roomname-select">
                                    <option value="" disabled selected>Select a Room Name</option>
                                    <option value="Budget  Room">Budget Room</option>
                                    <option value="Business  Room with Gym Access">Business Room with Gym Access
                                    </option>
                                    <option value="Deluxe  Room">Deluxe Room</option>
                                    <option value="Deluxe  Room (1 adult + 1 child)">Deluxe Room (1 adult + 1 child)
                                    </option>
                                    <option value="Deluxe  Room (1 adult + 2 children)">Deluxe Room (1 adult + 2
                                        children)</option>
                                    <option value="Deluxe  Room (2 Adults + 1 Child)">Deluxe Room (2 Adults + 1 Child)
                                    </option>
                                    <option value="Deluxe  Room with Balcony">Deluxe Room with Balcony</option>
                                    <option value="Deluxe  Room with Balcony and Sea View">Deluxe Room with Balcony and
                                        Sea View</option>
                                    <option value="Deluxe  Room with Bath">Deluxe Room with Bath</option>
                                    <option value="Deluxe  Room with Castle View">Deluxe Room with Castle View</option>
                                    <option value="Deluxe  Room with Extra Bed">Deluxe Room with Extra Bed</option>
                                    <option value="Deluxe  Room with Sea View">Deluxe Room with Sea View</option>
                                    <option value="Deluxe  Room with Shower">Deluxe Room with Shower</option>
                                    <option value="Deluxe  Room with Side Sea View">Deluxe Room with Side Sea View
                                    </option>
                                    <option value="Deluxe  or Twin Room">Deluxe or Twin Room</option>
                                    <option value="Deluxe King Room">Deluxe King Room</option>
                                    <option value="Deluxe Queen Room">Deluxe Queen Room</option>
                                    <option value="Deluxe Room">Deluxe Room</option>
                                    <option value="Deluxe Room (1 adult + 1 children)">Deluxe Room (1 adult + 1
                                        children)</option>
                                    <option value="Deluxe Room (1 adult + 2 children)">Deluxe Room (1 adult + 2
                                        children)</option>
                                    <option value="Deluxe Room (2 Adults + 1 Child)">Deluxe Room (2 Adults + 1 Child)
                                    </option>
                                    <option value=" Room"> Room</option>
                                    <option value=" Room (1 Adult + 1 Child)"> Room (1 Adult + 1 Child)</option>
                                    <option value=" Room - Disability Access"> Room - Disability Access</option>
                                    <option value=" Room with Balcony"> Room with Balcony</option>
                                    <option value=" Room with Balcony (2 Adults + 1 Child)"> Room with Balcony (2 Adults
                                        + 1 Child)</option>
                                    <option value=" Room with Balcony (3 Adults)"> Room with Balcony (3 Adults)</option>
                                    <option value=" Room with Balcony and Sea View"> Room with Balcony and Sea View
                                    </option>
                                    <option value=" Room with Extra Bed"> Room with Extra Bed</option>
                                    <option value=" Room with Garden View"> Room with Garden View</option>
                                    <option value=" Room with Lake View"> Room with Lake View</option>
                                    <option value=" Room with Mountain View"> Room with Mountain View</option>
                                    <option value=" Room with Patio"> Room with Patio</option>
                                    <option value=" Room with Pool View"> Room with Pool View</option>
                                    <option value=" Room with Private Bathroom"> Room with Private Bathroom</option>
                                    <option value=" Room with Private External Bathroom"> Room with Private External
                                        Bathroom</option>
                                    <option value=" Room with Sea View"> Room with Sea View</option>
                                    <option value=" Room with Shared Bathroom"> Room with Shared Bathroom</option>
                                    <option value=" Room with Shared Toilet"> Room with Shared Toilet</option>
                                    <option value=" Room with Spa Bath"> Room with Spa Bath</option>
                                    <option value=" Room with Terrace"> Room with Terrace</option>
                                    <option value="Economy  Room">Economy Room</option>
                                    <option value="King Room">King Room</option>
                                    <option value="King Room - Disability Access">King Room - Disability Access</option>
                                    <option value="King Room with Balcony">King Room with Balcony</option>
                                    <option value="King Room with Garden View">King Room with Garden View</option>
                                    <option value="King Room with Lake View">King Room with Lake View</option>
                                    <option value="King Room with Mountain View">King Room with Mountain View</option>
                                    <option value="King Room with Pool View">King Room with Pool View</option>
                                    <option value="King Room with Roll-In Shower">King Room with Roll-In Shower</option>
                                    <option value="King Room with Sea View">King Room with Sea View</option>
                                    <option value="King Room with Spa Bath">King Room with Spa Bath</option>
                                    <option value="- Disability Access">- Disability Access</option>
                                    <option value="Large  Room">Large Room</option>
                                    <option value="Queen Room">Queen Room</option>
                                    <option value="Queen Room - Disability Access">Queen Room - Disability Access
                                    </option>
                                    <option value="Queen Room with Balcony">Queen Room with Balcony</option>
                                    <option value="Queen Room with Garden View">Queen Room with Garden View</option>
                                    <option value="Queen Room with Pool View">Queen Room with Pool View</option>
                                    <option value="Queen Room with Sea View">Queen Room with Sea View</option>
                                    <option value="Queen Room with Shared Bathroom">Queen Room with Shared Bathroom
                                    </option>
                                    <option value="Queen Room with Spa Bath">Queen Room with Spa Bath</option>
                                    <option value="Small  Room">Small Room</option>
                                    <option value="Standard  Room">Standard Room</option>
                                    <option value="Standard  Room with Fan">Standard Room with Fan</option>
                                    <option value="Standard  Room with Shared Bathroom">Standard Room with Shared
                                        Bathroom</option>
                                    <option value="Standard King Room">Standard King Room</option>
                                    <option value="Standard Queen Room">Standard Queen Room</option>
                                    <option value="Superior  Room">Superior Room</option>
                                    <option value="Superior King Room">Superior King Room</option>
                                    <option value="Superior Queen Room">Superior Queen Room</option>
                                </select>
                            </div>
                            <div>
                                <select id="bedtypeselect">
                                    <option value="" disabled selected>Select a Bed Type</option>
                                    <option value="Twin bed / 90-130 cm wide">Twin bed / 90-130 cm wide</option>
                                    <option value="Full bed / 131-150 cm wide">Full bed / 131-150 cm wide</option>
                                    <option value="Queen bed 151-180 cm wide">Queen bed 151-180 cm wide</option>
                                    <option value="King bed / 181-210 cm wide">King bed / 181-210 cm wide</option>
                                    <option value="Bunk bed / Variable size">Bunk bed / Variable size</option>
                                    <option value="Sofa bed Variable size">Sofa bed Variable size</option>
                                    <option value="Futon bed / Variable size">Futon bed / Variable size</option>
                                    <option value="Bunk bed / Variable size">Bunk bed / Variable size</option>
                                </select>
                            </div>
                            <div id="divbednoSelect">Number of Bed
                                <select id="bednoSelect">
                                    <?php
for ($i = 1; $i <= 50; $i++) {
    echo "<option value='$i'>$i</option>";
}
?>
                                </select>
                            </div>
                            <div id="divAttachBathroom" data-division="room">
                                Attach Bathroom<input type="radio" id="Yes" name="AttachBathroom" value="Yes">
                                <label for="Yes">Yes</label>
                                <input type="radio" id="NO" name="AttachBathroom" value="No">
                                <label for="No">No</label>
                            </div>
                            <div id="divNon-SmokingRoom" data-division="room">
                                Non-Smoking Room<input type="radio" id="Yes" name="Non-SmokingRoom" value="Yes">
                                <label for="Yes">Yes</label>
                                <input type="radio" id="No" name="Non-SmokingRoom" value="No">
                                <label for="No">No</label>
                            </div>
                            <div id="divTotaloccupancy" data-division="room">Total occupancy<select id="Totaloccupancy">
                                    <?php
for ($i = 1; $i <= 50; $i++) {
    echo "<option value='$i'>$i</option>";
}
?>
                                </select></div>
                            <div class="inputField" data-division="room">
                                <input type="text" name="Price" required>
                                <label for="username">Price</label>
                            </div>
                            <button class="addroomdetailBtn" data-division="room">Add Room</button>
                            <button class="editroomdetailBtn">Edit Room</button>
                            <button class="addbeddetailBtn" data-division="bed">Add Bed</button>

                        </form>
                    </div>
                </div>


            </div>
            <!-- Room Section End -->

            <!--Manage Room-->
            <div id="staff_Section">
                <div class="file_Explorer">
                    <div class="title_Explorer">
                        <div>
                            <button type="button" onclick="clsBtn('staff_Section')">
                                <img src="img/button/Close_Button.svg" alt="Close Button">
                            </button>
                            <button type="button" onclick="exp_Btn('staff_Section')">
                                <img src="img/button/Maximize_Button.svg" alt="Expand Button">
                            </button>
                            <button type="button">
                                <img src="img/button/Minimize_Button.svg" alt="Minimize Button">
                            </button>
                        </div>
                        <div class="windowHeading">Manage Staff</div>
                        <div class="rightNavBar">
                            <button type="button" onclick="openBtn('addstaffSection')">
                                <img src="img/button/add.png" alt="Add Button"><img src="img/button/room.png"
                                    alt="Rooms">
                            </button>
                        </div>
                    </div>
                    <div class="explorer_Box">
                        <table>
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Position</th>
                                    <th>Salary</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Balance</th>
                                    <th>Hire On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="staffdataTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Staff Section End -->
            <!-- Room Section Start -->
            <div id="addstaffSection">
                <div class="file_Explorer">
                    <div class="title_Explorer">
                        <div class="title_adjust">
                            <div class="title_Btn">
                                <button type="button" onclick="clsBtn('addstaffSection')">
                                    <img src="img/button/Close_Button.svg" alt="Close Button">
                                </button>
                                <button type="button" onclick="exp_Btn('addstaffSection')">
                                    <img src="img/button/Maximize_Button.svg" alt="Expand Button">
                                </button>
                                <button type="button">
                                    <img src="img/button/Minimize_Button.svg" alt="Minimize Button">
                                </button>
                            </div>
                            <div class="title_heading">Manage Room</div>
                        </div>
                    </div>
                    <div class="explorer_Box">

                    </div>
                </div>


            </div>
            <!-- Room Section End -->
        </div>
        <!-- Body Section End -->

        <!-- Taskbar Section Start -->
        <div id="task_Bar">
            <button id="show_MenuBox">
                <img src="img/button/Menu.svg" alt="Menu Button" />
            </button>
        </div>
        <!-- Taskbar Section End -->
    </div>

    <!-- JavaScript Section Start -->
    <script src="dashboard/javascript/winCon.js"></script>
    <script src="dashboard/javascript/dataManu.js"></script>
    <script src="dashboard/javascript/room.js"></script>
    <script src="dashboard/javascript/staff.js"></script>
</body>

</html>