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
  var closeWin = $(closeWinID);
  closeWin.hide().css('z-index', '0');
  closeFlagWindow[closeWinID] = true;

  if (closeFlagWindow['#addRoom']) {
    $('.editroomdetailBtn').hide();
    $('#addRoom form *[data-division="room"]').show();
    $('#addRoom form *[data-division="bed"]').hide();
    $('#addRoom form')[0].reset();
    closeFlagWindow[closeWinID] = false;
    return;
  }

  if (closeFlagWindow['#Add_User']) {
    $('.adduserdetailBtn').show();
    $('.edituserdetailBtn').hide();
    $('#Add_User form')[0].reset();
    closeFlagWindow[closeWinID] = false;
    return;
  }
  
  // Moved the if statement inside the clsBtn function
  if (closeFlagWindow['#addstaffSection']) {
    $('.addstaffdetailBtn').show();
    $('.editstaffdetailBtn').hide();
    $('#addstaffSection form')[0].reset();
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
  var openBtn = $(openWinID);
  openBtn.show().css('z-index', '15');
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








