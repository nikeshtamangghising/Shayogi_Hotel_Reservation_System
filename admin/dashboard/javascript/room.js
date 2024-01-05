// Global Variables
let roomID = 0;
let bedID = 0;
let Availability = 0;

// Show Room data Function
// Show Room data Function
function showRoomData() {
  console.log("Showing Room Data");
  let output = '';
  $.ajax({
    url: 'dashboard/roomphp/showRoomData.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      for (let i = 0; i < data.length; i++) {
        let attachBathroom = data[i].AttachBathroom === '1' ? 'Yes' : 'No';
        let nonSmokingRoom = data[i].NonSmokingRoom === '1' ? 'Yes' : 'No';
        output += "<tr><td>" + data[i].CustomNo + "</td><td>" + data[i].RoomType + ' ' + data[i].RoomName + "</td><td>" + data[i].BedType + "</td><td>" + data[i].NumberOfBeds + "</td><td>" + attachBathroom + "</td><td>" + nonSmokingRoom + "</td><td>" + data[i].TotalOccupancy + "</td><td>" + data[i].Price + "</td><td><button class='deleteroom-button' data-id='" + data[i].RoomId + "'><img src='img/button/delete.png' alt='Delete'></button><button class='editroom-button' data-bid='"+data[i].BedTypeId+"' data-id='" + data[i].RoomId+"' data-CustomNo='" + data[i].CustomNo + "' data-RoomType='" + data[i].RoomType + "' data-RoomName='" + data[i].RoomName + "' data-BedType='" + data[i].BedType + "' data-NumberOfBeds='" + data[i].NumberOfBeds + "' data-AttachBathroom='" + data[i].AttachBathroom + "' data-NonSmokingRoom='" + data[i].NonSmokingRoom + "' data-TotalOccupancy='" + data[i].TotalOccupancy + "' data-Price='" + data[i].Price + "'><img src='img/button/edit.png' alt='Edit'></button><button class='addbed-button' data-id='" + data[i].RoomId+"'>Add</button><button class='deletebed-button' data-bid='"+data[i].BedTypeId+"'>Delete</button><button class='addcalander-button' data-id='"+data[i].RoomId+"'>Add Date</button></td></tr>";
      }
      $('#roomdataTable').html(output);
    }
  });
}


// Delete Room data Function
$(document).on('click', '.deleteroom-button', function() {
  roomID = $(this).data('id');
  console.log("User Delete Key Click With ID: " + roomID);
  $.ajax({
    url: 'dashboard/roomphp/delRoom.php',
    method: 'POST',
    data: { ID: roomID },
    success: function(data) {
      alert(data);
      showRoomData();
    }
  });
});

// Delete Bed data Function
$(document).on('click', '.deletebed-button', function() {
  bedID = $(this).data('bid');
  console.log("User Delete Key Click With Bed ID: " + bedID);
  $.ajax({
    url: 'dashboard/roomphp/delbed.php',
    method: 'POST',
    data: {BID: bedID},
    success: function(data) {
      alert(data);
      showRoomData();
    }
  });
});

// Add Bed Button On Click
$(document).on('click', '.addbed-button', function () {
  roomID = $(this).data('id');
  // Convert variables to numbers if necessary
  roomID = parseInt(roomID);
  $('.editroomdetailBtn').hide();
  $('#addRoom form *[data-division="room"]').hide();
  $('#addRoom').show().css('z-index', 15);
  $('#addRoom form *[data-division="bed"]').show();

  console.log(roomID);
});

// ADD Calendar Function
$(document).on('click', '.addcalander-button', function () {
  roomID = $(this).data('id');
  Availability =  $(this).data('id');
  // Convert variables to numbers if necessary
  roomID = parseInt(roomID);
  Availability = parseInt(Availability);
  $('input[name="RoomId"]').val(roomID);
  $('input[name="Availability"]').val(Availability);
  $('#updatecalendarSection').show();
  console.log(roomID);
  console.log(Availability);
});
// Update Calendar Button On Click
$(document).on('click', '.update_RoomCalendar', function () {
    let roomID = $('input[name="RoomId"]').val();
    let Availability = $('input[name="Availability"]').val();
    let StartDate = $('input[name="StartDate"]').val();
    let EndDate =  $('input[name="EndDate"]').val();

    console.log(roomID);
    console.log(Availability);
    console.log(StartDate);
    console.log(EndDate);

    let data = {
        RoomId: roomID, // Use 'RoomId' instead of 'roomID'
        Availability: Availability,
        StartDate: StartDate,
        EndDate: EndDate
    };

    $.ajax({
        url: 'dashboard/datephp/updatecalendar.php',
        method: 'POST',
        data: data,
        success: function (data) {
          alert(data);
          refreshCalendar();
        }
    });
});
// Delete Calendar Button On Click
$(document).on('click', '.delete_RoomCalendar', function () {
    let roomID = $('input[name="RoomId"]').val();
    console.log(roomID);

    let data = {
        RoomId: roomID, // Use 'RoomId' instead of 'roomID'
    };

    $.ajax({
        url: 'dashboard/datephp/deletecalendar.php',
        method: 'POST',
        data: data,
        success: function (data) {
            alert(data);
        }
    });
});

// Refresh Calendar Button On Click
function refreshCalendar() {
    $.ajax({
        url: 'dashboard/datephp/refreshcalendar.php',
        method: 'POST',
        success: function (data) {
            alert(data); // Display the response from the PHP script
        }
    });
}




$(document).ready(function () {
$('.addbeddetailBtn').click(function (e) {
    e.preventDefault();
  console.log('ADD Bed Button Click');
  ID = roomID;
    let BedType = $('#bedtypeselect').val(); 
  let NumberOfBeds = $('#bednoSelect').val();
  let data = { ID: ID,BedType: BedType, NumberOfBeds: NumberOfBeds};
    console.log(data);
  if (!BedType) {
      alert("Please Select BedType");
      return;
    } else if (!NumberOfBeds) {
      alert("Please Select NumberOfBeds");
      return;
    }else {
      $.ajax({
        url: 'dashboard/roomphp/addbed.php',
        method: 'POST',
        data: data,
        success: function (data) {
          $('#addRoom form')[0].reset();
          showRoomData();
        }
      });
    $('#addRoom form *[data-division="room"]').show().css('z-index', 15);
    $('#addRoom').hide().css('z-index', 0);
    $('#addRoom form *[data-division="bed"]').hide().css('z-index', 0);
    }
  });
});

// ADD Room Function
// ADD Room Function

$(document).ready(function () {
$('.addroomdetailBtn').click(function (e) {
    e.preventDefault();
    console.log('ADD Room Button Click');
    let CustomNo = $('input[name="customname"]').val();
    let RoomType = $('#room-select').val();
    let RoomName = $('#roomname-select').val(); 
    let BedType = $('#bedtypeselect').val(); 
    let NumberOfBeds = $('#bednoSelect').val();
    let AttachBathroom = $('input[name="AttachBathroom"]:checked').val() === 'Yes' ? 1 : 0;
    let NonSmokingRoom = $('input[name="Non-SmokingRoom"]:checked').val() === 'Yes' ? 1 : 0;
    let TotalOccupancy = $('#Totaloccupancy').val();
    let Price = $('input[name="Price"]').val();
    
    let data = { CustomNo: CustomNo, RoomType: RoomType, RoomName: RoomName, BedType: BedType, NumberOfBeds: NumberOfBeds, AttachBathroom: AttachBathroom, NonSmokingRoom: NonSmokingRoom, TotalOccupancy: TotalOccupancy, Price: Price };
    console.log(data);
    if (!CustomNo) {
      alert("CustomNo Can't be Empty");
      return;
    } else if (!RoomType) {
      alert("Please Select RoomType");
      return;
    } else if (!RoomName) {
      alert("Please Select RoomName");
      return;
    } else if (!BedType) {
      alert("Please Select BedType");
      return;
    } else if (!NumberOfBeds) {
      alert("Please Select NumberOfBeds");
      return;
    } else if (AttachBathroom !== 1 && AttachBathroom !== 0) {
      alert("Please Select if There is Attach Bathroom or Not");
      return;
    } else if (NonSmokingRoom !== 1 && NonSmokingRoom !== 0) {
      alert("Please Select Non-Smoking Room Policy");
      return;
    }else {
      $.ajax({
        url: 'dashboard/roomphp/addroomDetails.php',
        method: 'POST',
        data: data,
        success: function (data) {
          $('#addRoom form')[0].reset();
          showRoomData();

        }
      });
      $('#add_LoginUser')[0].reset();
    }
  });
  show_Data();
});

// Edit Room Button On Click
$(document).on('click', '.editroom-button', function () {
  roomID = $(this).data('id');
  bedID  = $(this).data('bid');
  let CustomNo = $(this).data('customno');
  let RoomType = $(this).data('roomtype');
  let RoomName = $(this).data('roomname');
  let BedType = $(this).data('bedtype');
  let NumberOfBeds = $(this).data('numberofbeds');
  let AttachBathroom = $(this).data('attachbathroom');
  let NonSmokingRoom = $(this).data('nonsmokingroom');
  let TotalOccupancy = $(this).data('totaloccupancy');
  let Price = $(this).data('price');

  // Convert variables to numbers if necessary
  bedID = parseInt(bedID);
  roomID = parseInt(roomID);
  CustomNo = parseInt(CustomNo);
  NumberOfBeds = parseInt(NumberOfBeds);
  AttachBathroom = parseInt(AttachBathroom);
  NonSmokingRoom = parseInt(NonSmokingRoom);
  TotalOccupancy = parseInt(TotalOccupancy);

  // Convert boolean values to Yes or No strings
  AttachBathroomvalue = AttachBathroom ? 'Yes' : 'No';
  NonSmokingRoomvalue = NonSmokingRoom ? 'Yes' : 'No';

  $('input[name="customname"]').val(CustomNo);
  $('input[name="Price"]').val(Price);
  $('select[id="room-select"]').val(RoomType);
  $('select[id="roomname-select"]').val(RoomName);
  $('select[id="bedtypeselect"]').val(BedType);
  $('select[id="bednoSelect"]').val(NumberOfBeds);
$('input[name="AttachBathroom"]').filter('[value="' + AttachBathroomvalue + '"]').prop('checked', true);
$('input[name="Non-SmokingRoom"]').filter('[value="' + NonSmokingRoomvalue + '"]').prop('checked', true);
  $('select[id="Totaloccupancy"]').val(TotalOccupancy);
  $('.editroomdetailBtn').show();
  $('#addRoom').show().css({'z-index': '15'});
    $('.addroomdetailBtn').hide();
});



 // Edit User Function
  // Edit User Function
$(document).on('click', '.editroomdetailBtn', function (e) {
  e.preventDefault();
  console.log('Edit Room Button Click and Processing');
  let ID = roomID;
  let BID = bedID;
  let CustomNo = $('input[name="customname"]').val();
  let RoomType = $('#room-select').val();
  let RoomName = $('#roomname-select').val(); 
  let BedType = $('#bedtypeselect').val(); 
  let NumberOfBeds = $('#bednoSelect').val();
  let AttachBathroom = $('input[name="AttachBathroom"]:checked').val() === 'Yes' ? 1 : 0;
  let NonSmokingRoom = $('input[name="Non-SmokingRoom"]:checked').val() === 'Yes' ? 1 : 0;
  let TotalOccupancy = $('#Totaloccupancy').val();
  let Price = $('input[name="Price"]').val();
  
  if (!CustomNo) {
    alert("CustomNo can't be empty");
    return;
  } else if (!RoomType) {
    alert("Please select RoomType");
    return;
  } else if (!RoomName) {
    alert("Please select RoomName");
    return;
  } else if (!BedType) {
    alert("Please select BedType");
    return;
  } else if (!NumberOfBeds) {
    alert("Please select NumberOfBeds");
    return;
  } else if (AttachBathroom !== 1 && AttachBathroom !== 0) {
    alert("Please select whether there is an attached bathroom or not");
    return;
  } else if (NonSmokingRoom !== 1 && NonSmokingRoom !== 0) {
    alert("Please select Non-Smoking Room policy");
    return;
  } else {
    let data = {
      BID: BID,
      ID: ID,
      CustomNo: CustomNo,
      RoomType: RoomType,
      RoomName: RoomName,
      BedType: BedType,
      NumberOfBeds: NumberOfBeds,
      AttachBathroom: AttachBathroom,
      NonSmokingRoom: NonSmokingRoom,
      TotalOccupancy: TotalOccupancy,
      Price: Price
    };

    $.ajax({
      url: 'dashboard/roomphp/editroom.php',
      method: 'POST',
      data: data,
      success: function (data) {
        alert(data);
        showRoomData();
        $('#addroomdetailBtn').show().css('z-index', 10);
      $('#editroomdetailBtn').hide().css('z-index', 0);
        $('#addRoom').hide().css('z-index', 0);
        $('#addRoom form')[0].reset();
      }
    });
  }
});


// Call the showRoomData function to initially populate the data
showRoomData();
