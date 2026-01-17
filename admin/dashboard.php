<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Check session timeout
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

$_SESSION['login_time'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hotel Shayogi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fa-solid fa-hotel"></i>
                <span>Hotel Shayogi</span>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="user-details">
                    <div class="user-name"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="#" class="nav-link" data-page="dashboard">
                        <i class="fa-solid fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="rooms">
                        <i class="fa-solid fa-door-open"></i>
                        <span>Rooms</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="beds">
                        <i class="fa-solid fa-bed"></i>
                        <span>Beds</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="users">
                        <i class="fa-solid fa-user-cog"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="calendar">
                        <i class="fa-solid fa-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="room-images">
                        <i class="fa-solid fa-images"></i>
                        <span>Room Images</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="page-title">Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="search-bar">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="header-user">
                    <div class="user-avatar-small">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Dashboard Page -->
            <div class="page" id="dashboard-page">
                <!-- Quick Actions -->
                <div class="quick-actions-bar">
                    <button class="btn btn-primary" onclick="showAddUserModal()">
                        <i class="fa-solid fa-user-plus"></i> Add User
                    </button>
                    <button class="btn btn-primary" onclick="showAddRoomModal()">
                        <i class="fa-solid fa-door-closed"></i> Add Room
                    </button>
                    <button class="btn btn-primary" onclick="showCalendarModal()">
                        <i class="fa-solid fa-calendar-plus"></i> Update Calendar
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="totalRooms">0</div>
                            <div class="stat-label">Total Rooms</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="totalUsers">0</div>
                            <div class="stat-label">Total Users</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="totalBookings">0</div>
                            <div class="stat-label">Bookings Today</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="revenue">NPR 0</div>
                            <div class="stat-label">Revenue</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Recent Activity</h3>
                    </div>
                    <div class="card-content">
                        <div id="recentActivity">
                            <p>Loading recent activity...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rooms Page -->
            <div class="page" id="rooms-page" style="display: none;">
                <div class="page-header">
                    <h2>Room Management</h2>
                    <button class="btn btn-primary" onclick="showAddRoomModal()">
                        <i class="fa-solid fa-plus"></i> Add Room
                    </button>
                </div>
                <div class="content-card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Custom No</th>
                                        <th>Room</th>
                                        <th>Bed Type</th>
                                        <th>Number of Bed</th>
                                        <th>Attach Bathroom</th>
                                        <th>Non-Smoking</th>
                                        <th>Total Occupancy</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="roomdataTable">
                                    <tr><td colspan="10" style="text-align: center;">Loading room data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Beds Page -->
            <div class="page" id="beds-page" style="display: none;">
                <div class="page-header">
                    <h2>Bed Management</h2>
                    <button class="btn btn-primary" onclick="showAddBedModal()">
                        <i class="fa-solid fa-plus"></i> Add Bed
                    </button>
                </div>
                <div class="content-card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Bed ID</th>
                                        <th>Room ID</th>
                                        <th>Bed Type</th>
                                        <th>Number of Beds</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="beddataTable">
                                    <tr><td colspan="5" style="text-align: center;">Loading bed data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Page -->
            <div class="page" id="users-page" style="display: none;">
                <div class="page-header">
                    <h2>User Management</h2>
                    <button class="btn btn-primary" onclick="showAddUserModal()">
                        <i class="fa-solid fa-plus"></i> Add User
                    </button>
                </div>
                <div class="content-card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    <tr><td colspan="5" style="text-align: center;">Loading user data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Page -->
            <div class="page" id="calendar-page" style="display: none;">
                <div class="page-header">
                    <h2>Booking Calendar</h2>
                    <button class="btn btn-primary" onclick="showCalendarModal()">
                        <i class="fa-solid fa-calendar-plus"></i> Update Calendar
                    </button>
                </div>
                
                <!-- Room Availability Summary -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Room Availability Status</h3>
                    </div>
                    <div class="card-content">
                        <div class="room-availability-grid" id="roomAvailabilityGrid">
                            <div class="loading">Loading room availability...</div>
                        </div>
                    </div>
                </div>
                
                <div class="content-card">
                    <div class="card-header">
                        <h3>Calendar View</h3>
                    </div>
                    <div class="card-content">
                        <div class="calendar-wrapper">
                            <div class="calendar">
                                <header>
                                    <div class="current-date">January 2024</div>
                                    <div class="icons">
                                        <span id="prev" class="calendar-nav">&lt;</span>
                                        <span id="next" class="calendar-nav">&gt;</span>
                                    </div>
                                </header>
                                <div class="calendar-grid">
                                    <ul class="weeks">
                                        <li>Sun</li><li>Mon</li><li>Tue</li><li>Wed</li><li>Thu</li><li>Fri</li><li>Sat</li>
                                    </ul>
                                    <ul class="days" id="days"></ul>
                                </div>
                            </div>
                            <div class="calendar-info">
                                <h4>Selected Date</h4>
                                <div id="selectedDateDisplay">No date selected</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Images Page -->
            <div class="page" id="room-images-page" style="display: none;">
                <div class="page-header">
                    <h2>Room Images Management</h2>
                </div>
                <div class="content-card">
                    <div class="card-content">
                        <iframe src="dashboard/roomphp/manageRoomImages.php" width="100%" height="800px" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modals -->
    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add User</h3>
                <button class="modal-close" onclick="hideModal('addUserModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="userName">Name</label>
                        <input type="text" id="userName" name="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="userUsername">Username</label>
                        <input type="text" id="userUsername" name="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" id="userEmail" name="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" id="userPassword" name="Password" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="hideModal('addUserModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal" id="addRoomModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Room</h3>
                <button class="modal-close" onclick="hideModal('addRoomModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRoomForm">
                    <div class="form-group">
                        <label for="roomCustomName">Custom Name</label>
                        <input type="text" id="roomCustomName" name="customname" required>
                    </div>
                    <div class="form-group">
                        <label for="roomType">Room Type</label>
                        <select id="roomType" name="roomtype" required>
                            <option value="">Select Room Type</option>
                            <option value="Twin/Double">Twin/Double</option>
                            <option value="Family">Family</option>
                            <option value="Single">Single</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="roomBedType">Bed Type</label>
                        <select id="roomBedType" name="bedtype" required>
                            <option value="">Select Bed Type</option>
                            <option value="Full bed / 131-150 cm wide">Full bed / 131-150 cm wide</option>
                            <option value="King bed / 181-210 cm wide">King bed / 181-210 cm wide</option>
                            <option value="Twin">Twin</option>
                            <option value="Queen">Queen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="roomPrice">Price (NPR)</label>
                        <input type="number" id="roomPrice" name="price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="roomNumberOfBeds">Number of Beds</label>
                        <input type="number" id="roomNumberOfBeds" name="numberofbeds" min="1" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="roomTotalOccupancy">Total Occupancy</label>
                        <input type="number" id="roomTotalOccupancy" name="totaloccupancy" min="1" value="1" required>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="attachbathroom" value="1">
                                <span class="checkmark"></span>
                                Attach Bathroom
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="nonsmokingroom" value="1">
                                <span class="checkmark"></span>
                                Non-Smoking Room
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="hideModal('addRoomModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal" id="editRoomModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Room</h3>
                <button class="modal-close" onclick="hideModal('editRoomModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRoomForm">
                    <input type="hidden" id="editRoomId" name="roomId">
                    <div class="form-group">
                        <label for="editRoomCustomName">Custom Name</label>
                        <input type="text" id="editRoomCustomName" name="customname" required>
                    </div>
                    <div class="form-group">
                        <label for="editRoomType">Room Type</label>
                        <select id="editRoomType" name="roomtype" required>
                            <option value="">Select Room Type</option>
                            <option value="Twin/Double">Twin/Double</option>
                            <option value="Family">Family</option>
                            <option value="Single">Single</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editRoomBedType">Bed Type</label>
                        <select id="editRoomBedType" name="bedtype" required>
                            <option value="">Select Bed Type</option>
                            <option value="Full bed / 131-150 cm wide">Full bed / 131-150 cm wide</option>
                            <option value="King bed / 181-210 cm wide">King bed / 181-210 cm wide</option>
                            <option value="Twin">Twin</option>
                            <option value="Queen">Queen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editRoomPrice">Price (NPR)</label>
                        <input type="number" id="editRoomPrice" name="price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="editRoomNumberOfBeds">Number of Beds</label>
                        <input type="number" id="editRoomNumberOfBeds" name="numberofbeds" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="editRoomTotalOccupancy">Total Occupancy</label>
                        <input type="number" id="editRoomTotalOccupancy" name="totaloccupancy" min="1" required>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="attachbathroom" value="1">
                                <span class="checkmark"></span>
                                Attach Bathroom
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="nonsmokingroom" value="1">
                                <span class="checkmark"></span>
                                Non-Smoking Room
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="hideModal('editRoomModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bed Modal -->
    <div class="modal" id="addBedModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Bed</h3>
                <button class="modal-close" onclick="hideModal('addBedModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addBedForm">
                    <div class="form-group">
                        <label for="bedRoomId">Room</label>
                        <select id="bedRoomId" name="roomId" required>
                            <option value="">Select Room</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bedType">Bed Type</label>
                        <select id="bedType" name="bedtype" required>
                            <option value="">Select Bed Type</option>
                            <option value="Full bed / 131-150 cm wide">Full bed / 131-150 cm wide</option>
                            <option value="King bed / 181-210 cm wide">King bed / 181-210 cm wide</option>
                            <option value="Twin">Twin</option>
                            <option value="Queen">Queen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bedNumberOfBeds">Number of Beds</label>
                        <input type="number" id="bedNumberOfBeds" name="numberofbeds" min="1" value="1" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="hideModal('addBedModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Bed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal" id="calendarModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Calendar</h3>
                <button class="modal-close" onclick="hideModal('calendarModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="calendarForm">
                    <div class="form-group">
                        <label for="calendarRoom">Room</label>
                        <select id="calendarRoom" name="room" required>
                            <option value="">Select Room</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="calendarStartDate">Start Date</label>
                        <input type="date" id="calendarStartDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="calendarEndDate">End Date</label>
                        <input type="date" id="calendarEndDate" name="endDate" required>
                    </div>
                    <div class="form-group">
                        <label for="calendarAvailableRooms">Available Rooms</label>
                        <input type="number" id="calendarAvailableRooms" name="availableRooms" min="0" max="10" value="1" required>
                        <small>Number of rooms available for this date range</small>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="hideModal('calendarModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Calendar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currYear = new Date().getFullYear();
        let currMonth = new Date().getMonth();
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        $(document).ready(function() {
            // Initialize
            loadDashboardData();
            renderCalendar();
            
            // Navigation
            $('.nav-link').on('click', function(e) {
                e.preventDefault();
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
                
                const page = $(this).data('page');
                $('.page').hide();
                $(`#${page}-page`).show();
                $('.page-title').text($(this).find('span').text());
                
                if (page === 'rooms') loadRoomData();
                if (page === 'beds') loadBedData();
                if (page === 'users') loadUserData();
                if (page === 'calendar') {
                    loadRoomAvailability();
                    renderCalendar();
                }
                if (page === 'room-images') {
                    // Refresh the iframe by resetting its src
                    const iframe = $('#room-images-page iframe');
                    const currentSrc = iframe.attr('src');
                    iframe.attr('src', '');
                    setTimeout(() => {
                        iframe.attr('src', currentSrc);
                    }, 100);
                }
            });

            // Mobile menu
            $('#menuToggle').on('click', function() {
                $('.sidebar').toggleClass('active');
            });

            // Forms
            $('#addUserForm').on('submit', handleAddUser);
            $('#addRoomForm').on('submit', handleAddRoom);
            $('#editRoomForm').on('submit', handleEditRoom);
            $('#addBedForm').on('submit', handleAddBed);
            $('#calendarForm').on('submit', handleCalendarUpdate);

            // Calendar navigation
            $('#prev, #next').on('click', function() {
                currMonth = $(this).attr('id') === 'prev' ? currMonth - 1 : currMonth + 1;
                if (currMonth < 0 || currMonth > 11) {
                    currYear += $(this).attr('id') === 'next' ? 1 : -1;
                    currMonth = $(this).attr('id') === 'next' ? 0 : 11;
                }
                renderCalendar();
            });
        });

        function loadDashboardData() {
            // Load stats
            $.get('dashboard/roomphp/showRoomData.php', function(data) {
                $('#totalRooms').text(data.length || 0);
            });

            $.get('dashboard/show_Data.php', function(data) {
                $('#totalUsers').text(data.length || 0);
            });

            $('#totalBookings').text('24');
            $('#revenue').text('NPR 45,280');
            
            // Load recent activity
            $('#recentActivity').html(`
                <div class="activity-item">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>New user registered</span>
                    <span class="activity-time">2 hours ago</span>
                </div>
                <div class="activity-item">
                    <i class="fa-solid fa-door-closed"></i>
                    <span>Room added: Deluxe Suite</span>
                    <span class="activity-time">5 hours ago</span>
                </div>
                <div class="activity-item">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>New booking received</span>
                    <span class="activity-time">1 day ago</span>
                </div>
            `);
        }

        function loadRoomData() {
            $.get('dashboard/roomphp/showRoomData.php', function(data) {
                let output = '';
                
                // Parse JSON if it's a string
                let roomData = typeof data === 'string' ? JSON.parse(data) : data;
                
                // Ensure we have an array
                if (Array.isArray(roomData) && roomData.length > 0) {
                    roomData.forEach(function(room) {
                        output += `
                            <tr>
                                <td>${room.CustomNo || ''}</td>
                                <td>${room.RoomType || ''} ${room.RoomName || ''}</td>
                                <td>${room.BedType || ''}</td>
                                <td>${room.NumberOfBeds || ''}</td>
                                <td>${room.AttachBathroom == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.NonSmokingRoom == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.TotalOccupancy || ''}</td>
                                <td>NPR ${room.Price || ''}</td>
                                <td>
                                    <button class="action-btn-small edit" onclick="editRoom(${room.RoomId})">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <button class="action-btn-small delete" onclick="deleteRoom(${room.RoomId})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    output = '<tr><td colspan="10" style="text-align: center;">No rooms found</td></tr>';
                }
                $('#roomdataTable').html(output);
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#roomdataTable').html('<tr><td colspan="10" style="text-align: center; color: red;">Error loading room data</td></tr>');
            });
        }

        function loadUserData() {
            $.get('dashboard/show_Data.php', function(data) {
                console.log('User data response:', data); // Debug log
                
                let output = '';
                
                // Parse JSON if it's a string
                let userData = typeof data === 'string' ? JSON.parse(data) : data;
                
                console.log('Parsed user data:', userData); // Debug log
                
                // Ensure we have an array
                if (Array.isArray(userData) && userData.length > 0) {
                    userData.forEach(function(user) {
                        output += `
                            <tr>
                                <td>${user.ID || ''}</td>
                                <td>${user.Name || ''}</td>
                                <td>${user.Username || ''}</td>
                                <td>${user.Email || ''}</td>
                                <td>
                                    <button class="action-btn-small edit" onclick="editUser(${user.ID})">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <button class="action-btn-small delete" onclick="deleteUser(${user.ID})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    output = '<tr><td colspan="5" style="text-align: center;">No users found</td></tr>';
                }
                $('#userTableBody').html(output);
            }).fail(function(xhr, status, error) {
                console.error('User AJAX Error:', error);
                console.error('Response Text:', xhr.responseText);
                $('#userTableBody').html('<tr><td colspan="5" style="text-align: center; color: red;">Error loading user data</td></tr>');
            });
        }

        function loadRoomAvailability() {
            // Load room data and calendar data
            $.get('dashboard/roomphp/showRoomData.php', function(roomData) {
                let rooms = typeof roomData === 'string' ? JSON.parse(roomData) : roomData;
                
                if (!Array.isArray(rooms)) {
                    $('#roomAvailabilityGrid').html('<div class="loading">No rooms found</div>');
                    return;
                }
                
                let output = '';
                rooms.forEach(function(room) {
                    // Get today's date
                    const today = new Date().toISOString().split('T')[0];
                    
                    // Get availability for today (you can enhance this to fetch from calendar)
                    const availability = Math.floor(Math.random() * 5) + 1; // Mock data - replace with actual calendar data
                    const status = availability > 3 ? 'available' : (availability > 0 ? 'limited' : 'unavailable');
                    const statusText = availability > 3 ? 'Available' : (availability > 0 ? 'Limited' : 'Unavailable');
                    
                    output += `
                        <div class="room-availability-card">
                            <div class="room-availability-header">
                                <div class="room-name">${room.CustomNo || ''}</div>
                                <div class="room-type">${room.RoomType || ''}</div>
                            </div>
                            <div class="room-details">
                                <div class="room-detail">
                                    <i class="fa-solid fa-bed"></i>
                                    <span>${room.BedType || 'N/A'}</span>
                                </div>
                                <div class="room-detail">
                                    <i class="fa-solid fa-users"></i>
                                    <span>${room.TotalOccupancy || 0} Guests</span>
                                </div>
                                <div class="room-detail">
                                    <i class="fa-solid fa-bath"></i>
                                    <span>${room.AttachBathroom == 1 ? 'Yes' : 'No'}</span>
                                </div>
                                <div class="room-detail">
                                    <i class="fa-solid fa-smoking-ban"></i>
                                    <span>${room.NonSmokingRoom == 1 ? 'Non-Smoking' : 'Smoking'}</span>
                                </div>
                            </div>
                            <div class="room-price">NPR ${room.Price || 0}</div>
                            <div class="room-availability-status">
                                <span class="status-${status}">${availability} rooms ${statusText}</span>
                            </div>
                        </div>
                    `;
                });
                
                $('#roomAvailabilityGrid').html(output);
            }).fail(function(xhr, status, error) {
                console.error('Room availability AJAX Error:', error);
                $('#roomAvailabilityGrid').html('<div class="loading">Error loading room availability</div>');
            });
        }

        function renderCalendar() {
            const firstDay = new Date(currYear, currMonth, 1).getDay();
            const daysInMonth = new Date(currYear, currMonth + 1, 0).getDate();
            
            $('.current-date').text(`${months[currMonth]} ${currYear}`);
            
            let html = '';
            for (let i = 0; i < firstDay; i++) {
                html += '<li class="inactive"></li>';
            }
            for (let i = 1; i <= daysInMonth; i++) {
                html += `<li onclick="selectDate(${i})">${i}</li>`;
            }
            $('.days').html(html);
        }

        function selectDate(day) {
            const date = new Date(currYear, currMonth, day);
            $('#selectedDateDisplay').text(date.toLocaleDateString());
        }

        function showAddUserModal() {
            $('#addUserModal').show();
            $('body').css('overflow', 'hidden');
        }

        function showAddRoomModal() {
            $('#addRoomModal').show();
            $('body').css('overflow', 'hidden');
        }

        function showCalendarModal() {
            // Load rooms for dropdown
            $.get('dashboard/roomphp/showRoomData.php', function(data) {
                let roomData = typeof data === 'string' ? JSON.parse(data) : data;
                let options = '<option value="">Select Room</option>';
                
                if (Array.isArray(roomData)) {
                    roomData.forEach(function(room) {
                        options += `<option value="${room.RoomId}">${room.CustomNo} - ${room.RoomType}</option>`;
                    });
                }
                
                $('#calendarRoom').html(options);
                $('#calendarModal').show();
                $('body').css('overflow', 'hidden');
            });
        }

        function hideModal(modalId) {
            $(`#${modalId}`).hide();
            $('body').css('overflow', 'auto');
        }

        function handleAddUser(e) {
            e.preventDefault();
            const formData = $('#addUserForm').serialize();
            
            $.post('dashboard/userphp/addUser.php', formData, function(response) {
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    alert('User added successfully!');
                    hideModal('addUserModal');
                    loadUserData();
                    $('#addUserForm')[0].reset();
                } else {
                    alert('Error adding user: ' + (result.message || response));
                }
            }).fail(function(xhr, status, error) {
                alert('Error adding user. Please check your connection.');
                console.error('AJAX Error:', error);
            });
        }

        function handleAddRoom(e) {
            e.preventDefault();
            const formData = $('#addRoomForm').serialize();
            
            console.log('Adding room with data:', formData); // Debug log
            
            $.post('dashboard/roomphp/addRoom.php', formData, function(response) {
                console.log('Server response:', response); // Debug log
                
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    alert('Room added successfully!');
                    hideModal('addRoomModal');
                    loadRoomData();
                    $('#addRoomForm')[0].reset();
                } else {
                    alert('Error adding room: ' + (result.message || response));
                }
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Response Text:', xhr.responseText);
                alert('Error adding room. Please check your connection.\n\nError: ' + error + '\nResponse: ' + xhr.responseText);
            });
        }

        function handleEditRoom(e) {
            e.preventDefault();
            const formData = $('#editRoomForm').serialize();
            
            $.post('dashboard/roomphp/editRoom.php', formData, function(response) {
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    alert('Room updated successfully!');
                    hideModal('editRoomModal');
                    loadRoomData();
                } else {
                    alert('Error updating room: ' + (result.message || response));
                }
            }).fail(function(xhr, status, error) {
                alert('Error updating room. Please check your connection.');
                console.error('AJAX Error:', error);
            });
        }

        function editRoom(id) {
            // Load room data for editing
            $.get('dashboard/roomphp/showRoomData.php', function(data) {
                // Parse JSON if it's a string
                let roomData = typeof data === 'string' ? JSON.parse(data) : data;
                
                // Ensure we have an array
                if (Array.isArray(roomData)) {
                    const room = roomData.find(r => r.RoomId == id);
                    if (room) {
                        // Populate edit form
                        $('#editRoomId').val(room.RoomId);
                        $('#editRoomCustomName').val(room.CustomNo || '');
                        $('#editRoomType').val(room.RoomType || '');
                        $('#editRoomBedType').val(room.BedType || '');
                        $('#editRoomPrice').val(room.Price || '');
                        $('#editRoomNumberOfBeds').val(room.NumberOfBeds || 1);
                        $('#editRoomTotalOccupancy').val(room.TotalOccupancy || 1);
                        
                        // Set checkboxes
                        $('input[name="attachbathroom"]').prop('checked', room.AttachBathroom == 1);
                        $('input[name="nonsmokingroom"]').prop('checked', room.NonSmokingRoom == 1);
                        
                        // Show modal
                        $('#editRoomModal').show();
                        $('body').css('overflow', 'hidden');
                    } else {
                        alert('Room not found!');
                    }
                } else {
                    alert('Error loading room data!');
                }
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Error loading room data. Please check your connection.');
            });
        }

        function deleteRoom(id) {
            if (confirm('Are you sure you want to delete this room?')) {
                $.post('dashboard/roomphp/delRoom.php', {ID: id}, function(response) {
                    console.log('Delete response:', response); // Debug log
                    
                    const result = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (result.success) {
                        alert('Room deleted successfully!');
                        loadRoomData();
                    } else {
                        alert('Error deleting room: ' + (result.message || response));
                    }
                }).fail(function(xhr, status, error) {
                    console.error('Delete AJAX Error:', error);
                    console.error('Response Text:', xhr.responseText);
                    alert('Error deleting room. Please check your connection.\n\nError: ' + error);
                });
            }
        }

        function loadBedData() {
            $.get('dashboard/bedphp/showBedData.php', function(data) {
                let output = '';
                
                // Parse JSON if it's a string
                let bedData = typeof data === 'string' ? JSON.parse(data) : data;
                
                // Ensure we have an array
                if (Array.isArray(bedData) && bedData.length > 0) {
                    bedData.forEach(function(bed) {
                        output += `
                            <tr>
                                <td>${bed.BedTypeId || ''}</td>
                                <td>${bed.RoomId || ''}</td>
                                <td>${bed.BedType || ''}</td>
                                <td>${bed.NumberOfBeds || ''}</td>
                                <td>
                                    <button class="action-btn-small edit" onclick="editBed(${bed.BedTypeId})">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <button class="action-btn-small delete" onclick="deleteBed(${bed.BedTypeId})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    output = '<tr><td colspan="5" style="text-align: center;">No beds found</td></tr>';
                }
                $('#beddataTable').html(output);
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#beddataTable').html('<tr><td colspan="5" style="text-align: center; color: red;">Error loading bed data</td></tr>');
            });
        }

        function showAddBedModal() {
            // Load rooms for dropdown
            $.get('dashboard/roomphp/showRoomData.php', function(data) {
                let roomData = typeof data === 'string' ? JSON.parse(data) : data;
                let options = '<option value="">Select Room</option>';
                
                if (Array.isArray(roomData)) {
                    roomData.forEach(function(room) {
                        options += `<option value="${room.RoomId}">${room.CustomNo} - ${room.RoomType}</option>`;
                    });
                }
                
                $('#bedRoomId').html(options);
                $('#addBedModal').show();
                $('body').css('overflow', 'hidden');
            });
        }

        function handleAddBed(e) {
            e.preventDefault();
            const formData = $('#addBedForm').serialize();
            
            console.log('Adding bed with data:', formData); // Debug log
            
            $.post('dashboard/bedphp/addBed.php', formData, function(response) {
                console.log('Server response:', response); // Debug log
                
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    alert('Bed added successfully!');
                    hideModal('addBedModal');
                    loadBedData();
                    $('#addBedForm')[0].reset();
                } else {
                    alert('Error adding bed: ' + (result.message || response));
                }
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Response Text:', xhr.responseText);
                alert('Error adding bed. Please check your connection.\n\nError: ' + error + '\nResponse: ' + xhr.responseText);
            });
        }

        function editBed(id) {
            alert('Edit bed functionality coming soon');
        }

        function deleteBed(id) {
            if (confirm('Are you sure you want to delete this bed?')) {
                $.post('dashboard/bedphp/deleteBed.php', {ID: id}, function(response) {
                    const result = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (result.success) {
                        alert('Bed deleted successfully!');
                        loadBedData();
                    } else {
                        alert('Error deleting bed: ' + (result.message || response));
                    }
                }).fail(function(xhr, status, error) {
                    console.error('Delete AJAX Error:', error);
                    console.error('Response Text:', xhr.responseText);
                    alert('Error deleting bed. Please check your connection.\n\nError: ' + error);
                });
            }
        }

        function handleCalendarUpdate(e) {
            e.preventDefault();
            const formData = $('#calendarForm').serialize();
            
            console.log('Updating calendar with data:', formData); // Debug log
            
            $.post('dashboard/calendarphp/updateCalendar.php', formData, function(response) {
                console.log('Calendar response:', response); // Debug log
                alert(response);
                hideModal('calendarModal');
                $('#calendarForm')[0].reset();
            }).fail(function(xhr, status, error) {
                console.error('Calendar AJAX Error:', error);
                console.error('Response Text:', xhr.responseText);
                alert('Error updating calendar. Please check your connection.\n\nError: ' + error);
            });
        }

        function editUser(id) {
            alert('Edit user functionality coming soon');
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.post('dashboard/userphp/deleteUser.php', {ID: id}, function(response) {
                    const result = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (result.success) {
                        alert('User deleted successfully!');
                        loadUserData();
                    } else {
                        alert('Error deleting user: ' + (result.message || response));
                    }
                }).fail(function(xhr, status, error) {
                    console.error('Delete AJAX Error:', error);
                    console.error('Response Text:', xhr.responseText);
                    alert('Error deleting user. Please check your connection.\n\nError: ' + error);
                });
            }
        }
    </script>

    <style>
        .activity-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-time {
            margin-left: auto;
            color: #666;
            font-size: 0.85rem;
        }
        .calendar-nav {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }
        .calendar-nav:hover {
            background: #3498db;
            color: white;
        }
        
        /* Room Availability Grid */
        .room-availability-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .room-availability-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .room-availability-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .room-availability-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .room-name {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .room-type {
            background: rgba(255,255,255,0.2);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .room-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        
        .room-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }
        
        .room-detail i {
            width: 20px;
            text-align: center;
        }
        
        .room-price {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 15px;
            text-align: center;
        }
        
        .room-availability-status {
            margin-top: 15px;
            padding: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            text-align: center;
        }
        
        .status-available {
            color: #2ecc71;
            font-weight: bold;
        }
        
        .status-limited {
            color: #f39c12;
            font-weight: bold;
        }
        
        .status-unavailable {
            color: #e74c3c;
            font-weight: bold;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        /* Enhanced Calendar Styles */
        .calendar-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            align-items: start;
        }
        
        .calendar-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        
        .calendar-info h4 {
            margin-bottom: 15px;
            color: #495057;
        }
        
        #selectedDateDisplay {
            font-size: 1.2rem;
            font-weight: bold;
            color: #3498db;
            padding: 10px;
            background: white;
            border-radius: 5px;
            text-align: center;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .room-availability-grid {
                grid-template-columns: 1fr;
            }
            
            .calendar-wrapper {
                grid-template-columns: 1fr;
            }
            
            .room-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
