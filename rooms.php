<?php
$pageTitle = "Available Rooms - Hotel Shayogi";
include 'includes/header.php';
?>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }
        .rooms-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 100px 0 0 0;
            margin: 0;
            width: 100%;
        }
        
        .rooms-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        @media (max-width: 768px) {
            .rooms-page {
                padding: 90px 0 0 0;
            }
            
            .rooms-container {
                padding: 15px;
            }
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        
        .page-header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .page-header p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .search-info {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .search-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            text-align: center;
        }
        
        .search-info-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        
        .search-info-item i {
            font-size: 1.5rem;
            color: #3498db;
            margin-bottom: 5px;
        }
        
        .search-info-item label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .search-info-item span {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .filter-sort-bar {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-group label {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .filter-group select {
            padding: 8px 12px;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }
        
        .filter-group select:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .results-count {
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 14px;
        }
        
        .rooms-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 50px;
        }
        
        .room-list-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
        }
        
        .room-list-item:hover {
            background: #f8f9fa;
            border-color: #3498db;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .room-image-small {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            object-fit: cover;
            flex-shrink: 0;
        }
        
        .room-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }
        
        .room-basic-info {
            flex: 1;
        }
        
        .room-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        
        .room-type {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 8px;
        }
        
        .room-features-list {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }
        
        .feature-badge {
            background: #e9ecef;
            color: #6c757d;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .room-price-inline {
            text-align: right;
        }
        
        .price-display-inline {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        
        .price-currency {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .price-amount {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
        }
        
        .book-now-inline {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .book-now-inline:hover {
            background: #2980b9;
        }
        
        .no-rooms {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .no-rooms i {
            font-size: 4rem;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        
        .no-rooms h2 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .no-rooms p {
            font-size: 1.1rem;
            color: #6c757d;
        }
        
        .back-to-home {
            position: fixed;
            top: 30px;
            left: 30px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .back-to-home:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        @media (max-width: 768px) {
            .rooms-page {
                padding: 80px 20px 30px;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .rooms-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .filter-sort-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .room-features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="rooms-page">
        <a href="index.php" class="back-to-home">
            <i class="fa-solid fa-arrow-left"></i> Back to Home
        </a>
        
        <div class="rooms-container">
            <div class="page-header">
                <h1>Available Rooms</h1>
                <p>Find your perfect stay from our curated selection of rooms</p>
            </div>
            
            <div class="search-info" id="searchInfo">
                <div class="search-info-grid">
                    <div class="search-info-item">
                        <i class="fa-solid fa-calendar-check"></i>
                        <label>Check-in</label>
                        <span id="displayCheckIn">-</span>
                    </div>
                    <div class="search-info-item">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        <label>Check-out</label>
                        <span id="displayCheckOut">-</span>
                    </div>
                    <div class="search-info-item">
                        <i class="fa-solid fa-users"></i>
                        <label>Guests</label>
                        <span id="displayGuests">-</span>
                    </div>
                </div>
            </div>
            
            <div class="filter-sort-bar">
                <div class="filter-group">
                    <label for="sortBy">Sort by:</label>
                    <select id="sortBy">
                        <option value="default">Recommended</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="occupancy">Guest Capacity</option>
                        <option value="name">Room Name</option>
                    </select>
                </div>
                <div class="results-count" id="resultsCount">
                    Loading rooms...
                </div>
            </div>
            
            <div class="rooms-grid" id="roomsGrid">
                <div class="loading">
                    <i class="fa-solid fa-spinner fa-spin"></i> Finding perfect rooms for you...
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const checkInDate = urlParams.get('checkInDate');
            const checkOutDate = urlParams.get('checkOutDate');
            const numberGuest = urlParams.get('numberGuest');
            
            // Display search info
            if (checkInDate) {
                const formattedDate = new Date(checkInDate).toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });
                $('#displayCheckIn').text(formattedDate);
            }
            
            if (checkOutDate) {
                const formattedDate = new Date(checkOutDate).toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });
                $('#displayCheckOut').text(formattedDate);
            }
            
            if (numberGuest) {
                $('#displayGuests').text(numberGuest + ' Guest' + (numberGuest > 1 ? 's' : ''));
            }
            
            // Load rooms
            loadRooms(checkInDate, checkOutDate, numberGuest);
            
            // Sort functionality
            $('#sortBy').on('change', function() {
                const sortBy = $(this).val();
                sortRooms(sortBy);
            });
        });
        
        let allRooms = [];
        
        function loadRooms(checkInDate, checkOutDate, numberGuest) {
            $.ajax({
                url: 'php/show_rooms.php',
                method: 'POST',
                dataType: 'json',
                data: { 
                    checkInDate: checkInDate, 
                    checkOutDate: checkOutDate, 
                    numberGuest: numberGuest 
                },
                success: function(data) {
                    allRooms = data;
                    displayRooms(data);
                    updateResultsCount(data.length);
                },
                error: function(xhr, status, error) {
                    $('#roomsGrid').html(`
                        <div class="no-rooms">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <h2>Unable to Load Rooms</h2>
                            <p>Please check your dates and try again.</p>
                        </div>
                    `);
                }
            });
        }
        
        function displayRooms(rooms) {
            if (rooms.length === 0) {
                $('#roomsGrid').html(`
                    <div class="no-rooms">
                        <i class="fa-solid fa-bed"></i>
                        <h2>No Rooms Available</h2>
                        <p>Try adjusting your dates or guest count to find available rooms.</p>
                    </div>
                `);
                return;
            }
            
            let output = '';
            rooms.forEach(function(room) {
                const attachBathroom = room.AttachBathroom === '1' ? 'Yes' : 'No';
                const nonSmokingRoom = room.NonSmokingRoom === '1' ? 'Yes' : 'No';
                const badgeText = room.Availabilities > 3 ? 'Available' : (room.Availabilities > 0 ? 'Limited' : 'Sold Out');
                
                // Use multiple images if available, otherwise fallback to single image
                const imagePaths = room.ImagePaths || [];
                const imagePath = imagePaths.length > 0 ? imagePaths[0] : (room.imgpath || room.ImagePath || 'images/hotel/rooms/101.jpg');
                
                output += `
                    <div class="room-list-item" onclick='showRoomDetails(${JSON.stringify(room).replace(/'/g, "\\'")}); event.stopPropagation();'>
                        <img src="${imagePath}" alt="${room.RoomName}" class="room-image-small" onerror="this.src='images/hotel/rooms/101.jpg'">
                        <div class="room-info">
                            <div class="room-basic-info">
                                <div class="room-name">${room.RoomName}</div>
                                <div class="room-type">${room.RoomType}</div>
                                <div class="room-features-list">
                                    <span class="feature-badge"><i class="fa-solid fa-users"></i> ${room.TotalOccupancy} Guests</span>
                                    <span class="feature-badge"><i class="fa-solid fa-bath"></i> ${attachBathroom === 'Yes' ? 'Attached' : 'Shared'}</span>
                                    ${nonSmokingRoom === 'Yes' ? '<span class="feature-badge"><i class="fa-solid fa-ban-smoking"></i> Non-Smoking</span>' : ''}
                                </div>
                            </div>
                            <div class="room-price-inline">
                                <div class="price-display-inline">
                                    <span class="price-currency">NPR</span>
                                    <span class="price-amount">${room.DynamicPrice}</span>
                                </div>
                                <button class="book-now-inline" onclick='event.stopPropagation(); openBookingPHP(${JSON.stringify(room).replace(/'/g, "\\'")}); return false;'>
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            $('#roomsGrid').html(output);
            updateResultsCount(rooms.length);
        }
        
        function showRoomDetails(room) {
            // Create a modal or expand the current room item to show full details
            alert(`Full details for ${room.RoomName}:

Type: ${room.RoomType}
Capacity: ${room.TotalOccupancy} guests
Bathroom: ${room.AttachBathroom === '1' ? 'Yes' : 'No'}
Smoking: ${room.NonSmokingRoom === '1' ? 'Yes' : 'No'}
Price: NPR ${room.DynamicPrice}/night (Dynamic Price)

Click Book Now to continue!`);
        }
        
        function sortRooms(sortBy) {
            let sortedRooms = [...allRooms];
            
            switch(sortBy) {
                case 'price-low':
                    sortedRooms.sort((a, b) => parseFloat(a.Price) - parseFloat(b.Price));
                    break;
                case 'price-high':
                    sortedRooms.sort((a, b) => parseFloat(b.Price) - parseFloat(a.Price));
                    break;
                case 'occupancy':
                    sortedRooms.sort((a, b) => parseInt(b.TotalOccupancy) - parseInt(a.TotalOccupancy));
                    break;
                case 'name':
                    sortedRooms.sort((a, b) => a.RoomName.localeCompare(b.RoomName));
                    break;
                default:
                    // Recommended - keep original order
                    break;
            }
            
            displayRooms(sortedRooms);
        }
        
        function updateResultsCount(count) {
            $('#resultsCount').text(`${count} Room${count !== 1 ? 's' : ''} Found`);
        }
        
        function openBookingPHP(room) {
            const urlParams = new URLSearchParams({
                roomId: room.RoomId,
                roomName: room.RoomName,
                roomType: room.RoomType,
                attachBathroom: room.AttachBathroom === '1' ? 'Yes' : 'No',
                nonSmokingRoom: room.NonSmokingRoom === '1' ? 'Yes' : 'No',
                totalOccupancy: room.TotalOccupancy,
                availabilities: room.Availabilities,
                price: room.Price,
                ImagePath: room.imgpath,
                ImagePaths: JSON.stringify(room.ImagePaths),
                checkInDate: new URLSearchParams(window.location.search).get('checkInDate'),
                checkOutDate: new URLSearchParams(window.location.search).get('checkOutDate'),
                numberGuest: new URLSearchParams(window.location.search).get('numberGuest')
            });
            
            urlParams.append('dynamicPrice', room.DynamicPrice);
            window.location.href = `bookroom.php?${urlParams.toString()}`;
        }
    </script>
    <?php
    include 'includes/footer.php';
    ?>
