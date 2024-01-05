// Global Variables
let staffID = 0;
  let WstaffID = 0;

// Show Room data Function
// Show Room data Function
function showStaffData() {
console.log("Showing Staff Data");
let output = '';
$.ajax({
    url: 'dashboard/staffphp/showStaffData.php',
    method: 'GET',
    dataType: 'json',
    success: function (data) {
            for (let i = 0; i < data.length; i++) {
          output += "<tr><td>" + data[i].staff_fullname + "</td><td>" + data[i].staff_position + "</td><td>" + data[i].staff_salary + "</td><td>" + data[i].staff_phone + "</td><td>" + data[i].staff_email + "</td><td>" + data[i].balance + "</td><td>" + data[i].hire_date + "</td><td><button class='deletestaff-button' data-id='" + data[i].staff_id + "'><img src='img/button/delete.png' alt='Delete'></button><button class='editstaff-button' data-id='" + data[i].staff_id + "' data-name='" + data[i].staff_fullname + "' data-position='" + data[i].staff_position + "' data-salary='" + data[i].staff_salary + "' data-hireon='" + data[i].hire_date + "' data-balance='" + data[i].balance + "' data-phone='" + data[i].staff_phone + "'  data-email='" + data[i].staff_email + "'><img src='img/button/edit.png' alt='Edit'></button><button class='withdrawalamount-button' data-id='" + data[i].staff_id + "'><img src='img/button/edit.png' alt='Withdrawal'></button></td></tr>";
            }
        $('#staffdataTable').html(output);
        }
    });
}

// Delete Room data Function
$(document).on('click', '.deletestaff-button', function() {
  staffID = $(this).data('id');
  console.log("User Delete Key Click With ID: " + staffID);
  $.ajax({
    url: 'dashboard/staffphp/delStaff.php',
    method: 'POST',
    data: { ID: staffID },
    success: function(data) {
      alert(data);
      showStaffData();
    }
  });
});
// withdrawalamount form open
$(document).on('click', '.withdrawalamount-button', function() {
  WstaffID = $(this).data('id');
  staffID = $(this).data('id');
  $('#withdrawsection').show().css({'z-index': '15'});
        $('#withdrawsection table').hide();
});


// Checking Withdrawal Statement form open
$(document).on('click', '.withdrawstatementdetailBtn', function () {
  let ID = WstaffID;
  $('#withdrawsection table').show();
  let output = '';
  $.ajax({
    url: 'dashboard/staffphp/showstatement.php', // Update the URL path to the correct location
    method: 'POST',
    dataType: 'json',
    data: { staff_id: ID },
    success: function (data) {
      console.log(data);
      $('#withdrawdetailtable').show();
     for (let i = 0; i < data.length; i++) {
        output += "<tr><td>" + data[i].withdrawal_date + "</td><td>" + data[i].withdrawal_amount + "</td><td>" + data[i].withdrawal_reason + "</td></tr>";
      }
      $('#withdrawdetailtable').html(output); // Display the data in the table
    }
  });
});



// Edit Room Button On Click
$(document).on('click', '.editstaff-button', function () {
  staffID = $(this).data('id');
  let Fullname = $(this).data('name');
  let Position = $(this).data('position');
  let Salary = $(this).data('salary');
  let HireOn = $(this).data('hireon');
  let Phone = $(this).data('phone');
  let Email = $(this).data('email');

  // Convert variables to numbers if necessary
  staffID = parseInt(staffID);
  Salary = parseInt(Salary);

  $('input[name="StaffName"]').val(Fullname);
  $('input[name="Position"]').val(Position);
  $('input[name="Salary"]').val(Salary);
  $('input[name="Phone"]').val(Phone);
  $('input[name="Staffemail"]').val(Email);
  $('input[name="HireOn"]').val(HireOn);
  $('.editstaffdetailBtn').show();
  $('#addstaffSection').show().css({'z-index': '15'});
  $('.addstaffdetailBtn').hide();
  $('.withdrawdetailBtn').hide();
  $('.withdrawdetailBtn').hide();
});


//On Edit Button Process
$(document).on('click', '.editstaffdetailBtn', function (e) {
  e.preventDefault();
  console.log('Edit Staff Button Click and Processing');
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  let ID = staffID;
  let Fullname = $('input[name="StaffName"]').val();
  let Position =$('input[name="Position"]').val();
  let Salary = $('input[name="Salary"]').val();
  let HireOn = $('input[name="HireOn"]').val();
  let Phone = $('input[name="Phone"]').val();
  let Email = $('input[name="Staffemail"]').val();
   let data = {
      staffID: ID,
      Fullname: Fullname,
      Position: Position,
      Salary: Salary,
      HireOn: HireOn,
      Phone: Phone,
      Email: Email
    };
  
  if (!Fullname) {
    alert("Fullname can't be empty");
    return;
  } else if (!Position) {
    alert("Position can't be empty");
    return;
  } else if (!Salary) {
    alert("Salary can't be empty");
    return;
  } else if (!HireOn) {
    alert("HireOn can't be empty");
    return;
  } else if (!Phone) {
    alert("Phone can't be empty");
    return;
  }else if (!Email.match(emailPattern)) {
      alert("Invalid Email");
      return;
  }
  else {
       $.ajax({
      url: 'dashboard/staffphp/editstaff.php',
      method: 'POST',
      data: data,
      success: function (data) {
        alert(data);
        showStaffData();
        $('.addstaffdetailBtn').show();
        $('#addstaffSection').hide();
        $('.editstaffdetailBtn').hide();
        $('#addstaffSection form')[0].reset();
      }
    });
  }
});

// Withdrawal Amount
// Withdrawal Amount

$(document).ready(function () {
  $('.withdrawdetailBtn').click(function (e) {
    e.preventDefault();
    console.log('ADD Bed Button Click');
    let ID = staffID;
    let withdrawal_amount = $('input[name="withdrawamount"]').val();
    let withdrawal_date = $('input[name="Withdrawaldate"]').val();
    let withdrawal_reason = $('input[name="withdrawreason"]').val();
    let data = { staff_id: ID, withdrawal_date: withdrawal_date, withdrawal_amount: withdrawal_amount, withdrawal_reason: withdrawal_reason };
    if (!withdrawal_amount) {
      alert("Please Enter Amount To Withdraw");
      return;
    } else if (!withdrawal_date) {
      alert("Please Select Date");
      return;
    } else if (!withdrawal_reason) {
      alert("Please Write Reason For Withdraw Money");
      return;
    }
    else {
      $.ajax({
        url: 'dashboard/staffphp/withdrawamount.php',
        method: 'POST',
        data: data,
        success: function (data) {
          $('#addRoom form')[0].reset();
          showStaffData();
        }
      });
      $('#withdrawsection').hide();
      $('#withdrawsection table').hide();
      $('#withdrawsection form')[0].reset();
    }
  });
  });
// Withdrawal Amount
// Withdrawal Amount


// Call the showRoomData function to initially populate the data
showStaffData();
