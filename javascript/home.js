showGuestData();
// Image Slider and Image Javascript
document.addEventListener("DOMContentLoaded", function () {
    const navBtns = document.querySelectorAll(".nav_btn");
    const imgSlides = document.querySelectorAll(".img_slide");

    function SliderNav(index) {
        navBtns.forEach((btn) => {
            btn.classList.remove("active");
        });
        imgSlides.forEach((slide) => {
            slide.classList.remove("active");
        });

        navBtns[index].classList.add("active");
        imgSlides[index].classList.add("active");
    }

    navBtns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            SliderNav(i);
        });
    });
});


// Image Slider and Image Javascript

const ReviewScrolls = document.querySelectorAll(".Reviewarea");
let isDragging = false;
let currentElement = null;
const arrowBtns = document.querySelectorAll(".reviewwrapper i");

arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        const reviewArea = btn.closest(".reviewwrapper").querySelector(".Reviewarea");
        const reviewCards = reviewArea.querySelectorAll(".reviewCard");
        const cardWidth = reviewCards[0].offsetWidth + parseInt(getComputedStyle(reviewCards[0]).marginRight);
        
        reviewArea.scrollLeft += btn.classList.contains("fa-chevron-left") ? -cardWidth : cardWidth;
    });
});

const dragStart = () => {
    isDragging = true;
    if (currentElement) {
        currentElement.classList.add("dragging");
    }
}

const dragEnd = () => {
    isDragging = false;
    if (currentElement) {
        currentElement.classList.remove("dragging");
    }
    currentElement = null;
}

const dragging = (e) => {
    if (!isDragging || !currentElement) return;
    currentElement.scrollLeft -= e.movementX;
}

ReviewScrolls.forEach(element => {
    element.addEventListener("mousedown", () => {
        currentElement = element;
        dragStart();
    });
    element.addEventListener("mouseup", dragEnd);
    element.addEventListener("mouseleave", dragEnd);
    element.addEventListener("mousemove", dragging);
});

//Gallery Javascript
//Gallery Javascript
//selecting all required elements
const filterItem = document.querySelector(".galleryitems");
const filterImg = document.querySelectorAll(".gallery .image");

Window.onload = ()=>{ //after window loaded
  filterItem.onclick = (selectedItem)=>{ //if user click on filterItem div
    if(selectedItem.target.classList.contains("item")){ //if user selected item has .item class
      filterItem.querySelector(".active").classList.remove("active"); //remove the active class which is in first item
      selectedItem.target.classList.add("active"); //add that active class on user selected item
      let filterName = selectedItem.target.getAttribute("data-name"); //getting data-name value of user selected item and store in a filtername variable
      filterImg.forEach((image) => {
        let filterImges = image.getAttribute("data-name"); //getting image data-name value
        //if user selected item data-name value is equal to images data-name value
        //or user selected item data-name value is equal to "all"
        if((filterImges == filterName) || (filterName == "all")){
          image.classList.remove("hide"); //first remove the hide class from the image
          image.classList.add("show"); //add show class in image
        }else{
          image.classList.add("hide"); //add hide class in image
          image.classList.remove("show"); //remove show class from the image
        }
      });
    }
  }
  for (let i = 0; i < filterImg.length; i++) {
    filterImg[i].setAttribute("onclick", "preview(this)"); //adding onclick attribute in all available images
  }
}

//fullscreen image preview function
//selecting all required elements
const previewBox = document.querySelector(".preview-box"),
categoryName = previewBox.querySelector(".title p"),
previewImg = previewBox.querySelector("img"),
closeIcon = previewBox.querySelector(".icon"),
shadow = document.querySelector(".shadow");

function preview(element){
  //once user click on any image then remove the scroll bar of the body, so user cant scroll up or down
  document.querySelector("body").style.overflow = "hidden";
  let selectedPrevImg = element.querySelector("img").src; //getting user clicked image source link and stored in a variable
  let selectedImgCategory = element.getAttribute("data-name"); //getting user clicked image data-name value
  previewImg.src = selectedPrevImg; //passing the user clicked image source in preview image source
  categoryName.textContent = selectedImgCategory; //passing user clicked data-name value in category name
  previewBox.classList.add("show"); //show the preview image box
  shadow.classList.add("show"); //show the light grey background
  closeIcon.onclick = ()=>{ //if user click on close icon of preview box
    previewBox.classList.remove("show"); //hide the preview box
    shadow.classList.remove("show"); //hide the light grey background
    document.querySelector("body").style.overflow = "auto"; //show the scroll bar on body
  }
}

//Gallery Javascript
//Gallery Javascript
// Show Guest Review 
// Show Guest Review 
function showGuestData() {
  let output = '';
  $.ajax({
    url: 'php/Showreview.php',
    method: 'GET',
    dataType: 'json',
      success: function (data) {
      for (let i = 0; i < data.length; i++) {
          output += "<li class='reviewCard'><div class='guestImg'><img class='reviewImg' draggable='false' src='" + data[i].image_path + "'></div><h2>" + data[i].FullName + "</h2><p>" + data[i].Review + "</p></li >"
      }
      $('.Reviewarea').html(output);
    }
  });
}
// Show Guest Review 
// Show Guest Review 


$(document).on('click', '.ShowroomOn', function () {
  // Today's Date Format
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
  const day = String(currentDate.getDate()).padStart(2, '0');
  const todayDate = `${year}-${month}-${day}`;
  
  // Get Check-in and Check-out Dates
  let checkInDate = $('#checkin_Room').val(); 
  let checkOutDate = $('#checkout_Room').val(); 
  let numberGuest = $('#guestNumber').val(); 
  
  
  if (checkInDate >= checkOutDate) {
    alert("Invalid Date. Please Choose Correct Dates.");
    return;
  } 
  else if (checkInDate < todayDate || todayDate >= checkOutDate) {
    alert("Invalid Date Range. Check-in date should be later than today, and Check-out date should be later than Check-in date.");
    return;
  }
  else {
    let output = "";
    $.ajax({
    url: 'php/ShowroomON.php',
    method: 'POST',
    dataType: 'json',
    data: { checkInDate : checkInDate, checkOutDate: checkOutDate , numberGuest : numberGuest},
      success: function (data) {
        console.log(data);
        for (let i = 0; i < data.length; i++) {
        let attachBathroom = data[i].AttachBathroom === '1' ? 'Yes' : 'No';
        let nonSmokingRoom = data[i].NonSmokingRoom === '1' ? 'Yes' : 'No';
        output += "<li class='roomCard'><div'><img src='" + data[i].imgpath + "'></div><div class='roomdetailsCard><div><i class='fa-solid fa-bed'></i> " + data[i].RoomName + " With " + data[i].RoomType + "</div><div>Available: " + data[i].Availabilities + " Room</div><div>Max Guest: " + data[i].TotalOccupancy + " <i class='fa-solid fa-person'></i></div><div>Attach Bathroom: " + attachBathroom + " </div><div>Non Smoking Room: " + nonSmokingRoom + " </div><div>Room Price: $" + data[i].Price + " </div><div><button onclick='openBookingPHP(this)' class='bookNowBtn' data-roomId='" + data[i].RoomId + "' data-roomName='" + data[i].RoomName + "' data-roomType='" + data[i].RoomType + "' data-AttachBathroom='" + attachBathroom + "' data-NonSmokingRoom='" + nonSmokingRoom + "' data-TotalOccupancy='" + data[i].TotalOccupancy + "' data-Availabilities='" + data[i].Availabilities + "' data-Price='" + data[i].Price + "' data-ImagePath='" + data[i].imgpath + "'>Book Now</button></div></div></li > "
}
        $('.Roomarea').html(output);
    }
    });
    }
});
// Book Room Button Click


function openBookingPHP(button) {
    const roomId = button.getAttribute("data-roomId");
    const roomName = button.getAttribute("data-roomName");
    const roomType = button.getAttribute("data-roomType");
    const attachBathroom = button.getAttribute("data-AttachBathroom");
    const nonSmokingRoom = button.getAttribute("data-NonSmokingRoom");
    const totalOccupancy = button.getAttribute("data-TotalOccupancy");
    const availabilities = button.getAttribute("data-Availabilities");
    const price = button.getAttribute("data-Price");
  const ImagePath = button.getAttribute("data-ImagePath");
  let checkInDate = $('#checkin_Room').val(); 
  let checkOutDate = $('#checkout_Room').val(); 
  let numberGuest = $('#guestNumber').val(); 

    const queryParams = new URLSearchParams({
        roomId,
        roomName,
        roomType,
        attachBathroom,
        nonSmokingRoom,
        totalOccupancy,
        availabilities,
        price,
      ImagePath,
      numberGuest,
      checkOutDate,
        checkInDate
    });

    const bookingURL = "bookroom.php?" + queryParams.toString();
    window.location.href = bookingURL;
}






