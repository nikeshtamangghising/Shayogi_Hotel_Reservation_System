// Gobal Variables
// Gobal Variables
let delID = 0;
// Gobal Variables
// Gobal Variables


// Show data Function
// Show data Function

// Show User data Function
// Show User data Function
  function show_Data() {
    console.log("Showing User Data");
    let output = '';
    $.ajax({
      url: 'dashboard/show_Data.php',
      method: 'GET',
      dataType: 'json',
      success: function (data) {
                for (let i = 0; i < data.length; i++) {
          output += "<tr><td>" + data[i].ID + "</td><td>" + data[i].Name + "</td><td>" + data[i].Username + "</td><td>" + data[i].Password + "</td><td>" + data[i].Email + "</td><td><button class='delete-button' data-id='" + data[i].ID + "'><img src='img/button/delete.png' alt='Delete'></button><button class='edit-button' data-id='" + data[i].ID + "' data-name='" + data[i].Name + "' data-username='" + data[i].Username + "' data-email='" + data[i].Email + "'><img src='img/button/edit.png' alt='Edit'></button></td></tr>";
        }
        $('#t_body').html(output);
      }
    });
  }

  // ADD User Function
    // ADD User Function

$(document).ready(function () {
  $('.adduserdetailBtn').click(function (e) {
    e.preventDefault();
    console.log('ADD User Button Click');
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let Name = $('input[name="Name"]').val();
    let Email = $('input[name="Email"]').val();
    let Username = $('input[name="Username"]').val();
    let Password = $('input[name="Password"]').val();
    let data = { Name: Name, Email: Email, Username: Username, Password: Password };
    if (Name == null || Name == '') {
      alert("Name Can't be Empty");
      return;
    } else if (Username == null || Username == '') {
      alert("Username Can't be Empty");
      return;
    } else if (Password.length <= 6) {
      alert("Invalid Password It Must be Longer Then 6 in Length");
      return;
    } else if (!Email.match(emailPattern)) {
      alert("Invalid Email");
      return;
    } else {
      $.ajax({
        url: 'dashboard/addUser.php',
        method: 'POST',
        data: data,
        success: function (data) {
          console.log(data);
          show_Data();
        }
      });
      $('#add_LoginUser')[0].reset();
    }
  });
});
  // ADD User Function
    // ADD User Function


// Delete User Function
// Delete User Function
  $(document).on('click', '.delete-button', function () {
    let delID = $(this).data('id');
    console.log("User Delete Key Click With ID: " + delID);
    $.ajax({
      url: 'dashboard/del_User.php',
      method: 'POST',
      data: { ID: delID },
      success: function (data) {
        alert(data);
        show_Data();
      }
    });
  });
  // Delete User Function
    // Delete User Function



 // Attach event listener to edit button
  $(document).on('click', '.edit-button', function () {
    let editID = $(this).data('id');
    let editName = $(this).data('name');
    let editUsername = $(this).data('username');
    let editEmail = $(this).data('email');
    $('#Add_User').show().css({'z-index': '15'});
    $('.edituserdetailBtn').show();
    $('.adduserdetailBtn').hide();
    $('input[name="Name"]').val(editName);
    $('input[name="Email"]').val(editEmail);
    $('input[name="Username"]').val(editUsername);
    delID = editID;
  });


 // Edit User Function
  // Edit User Function
$(document).on('click', '.edituserdetailBtn', function (e) {

    e.preventDefault();
    console.log('Edit Button Click');

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let Name = $('input[name="Name"]').val();
    let Email = $('input[name="Email"]').val();
    let Username = $('input[name="Username"]').val();
  let Password = $('input[name="Password"]').val();
  let ID = delID;
  console.log(ID);

    let data = {
      ID: ID,
      Name: Name,
      Email: Email,
      Username: Username,
      Password: Password
    };

    if (Name == null || Name == '') {
      alert("Name Can't be Empty");
      return;
    } else if (Username == null || Username == '') {
      alert("Username Can't be Empty");
      return false;
    } else if (Password.length <= 6) {
      alert("Invalid Password. It must be longer than 6 characters");
      return false;
    } else if (!Email.match(emailPattern)) {
      alert("Invalid Email");
      return false;
    } else {
      $.ajax({
        url: 'dashboard/editUser.php',
        method: 'POST',
        data: data,
        success: function (data) {
          alert(data);
          show_Data();
          $('.edituserdetailBtn').show();
          $('.edituserdetailBtn').hide();
          $('#Add_User').hide().css('z-index', 0);
        }
      });
      $('#add_LoginUser')[0].reset();
    }
  });