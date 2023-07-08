//globalVariable
var closeFlagWindow = {};
//Menu Button Java Script
//Menu Button Java Script
//Menu Button Java Script
// Get the button element
const button = document.getElementById("show_MenuBox");
// Add an event listener for the click event
button.addEventListener("click", function() {
  // Do something when the button is clicked
    console.log("You clicked The Menu Button");
    var menu_BoxBtn = document.getElementById("explorerBox");
  if (menu_BoxBtn.style.display === 'flex') {
    menu_BoxBtn.style.display = 'none';
  } else {
    menu_BoxBtn.style.display = 'flex';
  }
});
//Menu Button Java Script
//Menu Button Java Script
//Menu Button Java Script

//Close Button Java Script
//Close Button Java Script
//Close Button Java Script
function clsBtn(closeWinID) {
  console.log("Close Button Clicked");
  let closeBtn = document.getElementById(closeWinID);
  closeBtn.style.display = 'none';
  closeBtn.style.zIndex = 1;
  closeFlagWindow[closeWinID] = true;

  if (closeFlagWindow['addRoom']) {
    $('#addRoom').css({
      'display': 'none',
      'z-index': '0'
    });
    $('.editroomdetailBtn').css({
      'display': 'none',
    });
    
    $('#addRoom form *[data-division="room"]').css({
      'display': ''
    });
    $('#addRoom form *[data-division="bed"]').css({
      'display': 'none'
    });
    closeFlagWindow[closeWinID] = false;
    return;
  }

  if (closeFlagWindow['Add_User']) {
    $('#add_User').show();
    $('#edit_User').hide();
    $('#add_LoginUser')[0].reset();
    closeFlagWindow[closeWinID] = false;
    return;
  }
}

//Close Button Java Script
//Close Button Java Script
//Close Button Java Script



//Open Button Java Script
//Open Button Java Script
//Open Button Java Script
function openBtn(openWinID) {
  console.log("Open Button Clicked");
  let openBtn = document.getElementById(openWinID);
  $(openBtn).show();
  openBtn.style.zIndex = 20;
}

//Open Button Java Script
//Open Button Java Script
//Open Button Java Script




//Expand Button Java Script
//Expand Button Java Script
//Expand Button Java Script
function exp_Btn(winIDexp) {
  console.log("Expand Button Clicked");
  console.log(winIDexp);
  let expandBtn = document.getElementById(winIDexp);
  var expandBtnBox = document.querySelector('#' + winIDexp + " .explorer_Box");

  if (expandBtn.style.width === '50%') {
    expandBtn.style.width = '100%';
    expandBtnBox.style.width = '95%';
    expandBtn.style.zIndex = '20';
  } else {
    expandBtn.style.width = '50%';
    expandBtnBox.style.width = '95%';
    expandBtn.style.zIndex = '20';
  }
}



//Expand Button Java Script
//Expand Button Java Script
//Expand Button Java Script






//Add User Button Javascript
//Add User Button Javascript
//Add User Button Javascript
const addBtn = document.getElementById("btn_adduser");
// Add an event listener for the click event
addBtn.addEventListener("click", function() {
  // Do something when the button is clicked
  console.log("You clicked Open User Button");
    var Add_UserBtn = document.getElementById("Add_User");
  Add_UserBtn.style.display = 'flex';
  Add_UserBtn.style.zIndex = 20;

  
});
//Add User Button Javascript
//Add User Button Javascript
//Add User Button Javascript


