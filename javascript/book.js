$(document).on('click', '.book_Room_Button', function () {
  console.log("Book Button Click");
  
  var RoomID = $(this).data('roomid');
  var MaxGuest = $(this).data('guestno');
  var CheckOut = $(this).data('checkout');
  var CheckIn = $(this).data('checkin');
  var FullName = $('input[name="fullName"]').val();
  var Phone = $('input[name="guestPhone"]').val();
  var VerifyID = $('input[name="guestVerifyID"]').val();
  var Country = $('input[name="guestCountry"]').val();
  var Email = $('input[name="guestEmail"]').val();
  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (FullName === null || FullName === '') {
    alert("Full Name Can't be Empty");
    return;
  } else if (Country === null || Country === '') {
    alert("Country Can't be Empty");
    return;
  } else if (VerifyID === null || VerifyID === '') {
    alert("Verify ID Can't be Empty");
    return;
  } else if (Phone.length <= 9) {
    alert("Invalid Phone");
    return;
  } else if (!Email.match(emailPattern)) {
    alert("Invalid Email");
    return;
  } else {
    // Create the data object
    var data = {
      RoomID: RoomID,
      MaxGuest: MaxGuest,
      CheckOut: CheckOut,
      CheckIn: CheckIn,
      FullName: FullName,
      Phone: Phone,
      VerifyID: VerifyID,
      Country: Country,
      Email: Email,
    };

    // Make the AJAX request
    $.ajax({
      url: 'php/roomBooked.php',
      method: 'POST',
      dataType: 'json',
      data: data,
      success: function(response) {
        if (response.success) {
          alert('Success: ' + response.success);
        } else if (response.error) {
          alert('Error: ' + response.error);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  }
});
