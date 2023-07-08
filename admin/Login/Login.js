$(document).ready(function () {
  $('#LoginIn').click(function (e) {
    e.preventDefault();
    console.log('Login Button Click');
    let Username = $('input[name="Username"]').val();
    let Password = $('input[name="Password"]').val();
    if (Username == null || Username === "") {
      $('#error_msg').html("Please Enter Username");
      return;
    } else if (Password.length < 6) {
      $('#error_msg').html("Password should be More than 6");
      return;
    }
      let data = {Username:Username, Password:Password};
    $.ajax({
      url: 'Login/Login.php',
      method:'POST',
      data:data,
      success: function (data) {
          $('#error_msg').html(data);
          if (data == "Success"){
              window.location.href = "dashboard.php";
              $('#error_msg').html("");
          }
      }
    });
      $('#login_Form')[0].reset();
  });
});
