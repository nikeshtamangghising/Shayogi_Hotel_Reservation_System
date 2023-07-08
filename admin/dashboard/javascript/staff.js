// Global Variables

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
          output += "<tr><td>" + data[i].staff_fullname + "</td><td>" + data[i].staff_position + "</td><td>" + data[i].staff_salary + "</td><td>" + data[i].staff_phone + "</td><td>" + data[i].staff_email + "</td><td>" + data[i].balance + "</td><td>" + data[i].hire_date + "</td><td><button class='delete-button' data-id='" + data[i].ID + "'><img src='img/button/delete.png' alt='Delete'></button><button class='edit-button' data-id='" + data[i].ID + "' data-name='" + data[i].Name + "' data-username='" + data[i].Username + "' data-email='" + data[i].Email + "'><img src='img/button/edit.png' alt='Edit'></button></td></tr>";
            }
        $('#staffdataTable').html(output);
    console.log(data);
        }
    });
}



// Call the showRoomData function to initially populate the data
showStaffData();
