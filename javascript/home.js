showGuestData();
// Set minimum date for date inputs and default values
document.addEventListener("DOMContentLoaded", function () {
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const todayStr = today.toISOString().split('T')[0];
    const tomorrowStr = tomorrow.toISOString().split('T')[0];
    
    const checkinInput = document.getElementById('checkin_Room');
    const checkoutInput = document.getElementById('checkout_Room');
    
    if (checkinInput) {
        checkinInput.setAttribute('min', todayStr);
        checkinInput.value = todayStr; // Set default to today
        
        checkinInput.addEventListener('change', function() {
            if (checkoutInput) {
                const selectedDate = new Date(this.value);
                const nextDay = new Date(selectedDate);
                nextDay.setDate(nextDay.getDate() + 1);
                const minCheckout = nextDay.toISOString().split('T')[0];
                checkoutInput.setAttribute('min', minCheckout);
                
                // If checkout is before the new minimum, update it
                if (checkoutInput.value && checkoutInput.value <= this.value) {
                    checkoutInput.value = minCheckout;
                }
            }
        });
    }
    
    if (checkoutInput) {
        checkoutInput.setAttribute('min', tomorrowStr);
        checkoutInput.value = tomorrowStr; // Set default to tomorrow
    }
});

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

window.onload = ()=>{ //after window loaded
  const filterItem = document.querySelector(".galleryitems");
  const filterImg = document.querySelectorAll(".gallery .image");
  
  if (filterItem) {
    filterItem.onclick = (selectedItem)=>{ //if user click on filterItem div
      if(selectedItem.target.classList.contains("item")){ //if user selected item has .item class
        filterItem.querySelector(".active").classList.remove("active"); //remove active class which is in first item
        selectedItem.target.classList.add("active"); //add that active class on user selected item
        let filterName = selectedItem.target.getAttribute("data-name"); //getting data-name value of user selected item and store in a filtername variable
        filterImg.forEach((image) => {
          let filterImges = image.getAttribute("data-name"); //getting image data-name value
          //if user selected item data-name value is equal to images data-name value
          //or user selected item data-name value is equal to "all"
          if((filterImges == filterName) || (filterName == "all")){
            image.classList.remove("hide"); //first remove the hide class from image
            image.classList.add("show"); //add show class in image
          }else{
            image.classList.add("hide"); //add hide class in image
            image.classList.remove("show"); //remove show class from the image
          }
        });
      }
    }
  }
  
  for (let i = 0; i < filterImg.length; i++) {
    filterImg[i].setAttribute("onclick", "preview(this)"); //adding onclick attribute in all available images
  }
}

// Enhanced fullscreen image preview function
const previewBox = document.querySelector(".preview-box"),
categoryName = previewBox?.querySelector(".title p"),
previewImg = previewBox?.querySelector("img"),
closeIcon = previewBox?.querySelector(".icon"),
shadow = document.querySelector(".shadow"),
prevBtn = previewBox?.querySelector(".preview-nav.prev"),
nextBtn = previewBox?.querySelector(".preview-nav.next"),
imageCounter = previewBox?.querySelector(".image-counter"),
zoomBtns = previewBox?.querySelectorAll(".zoom-btn");

let currentImageIndex = 0;
let currentZoom = 1;
let currentImages = [];

function preview(element) {
    // Get all visible images in the current filter
    currentImages = Array.from(document.querySelectorAll('.gallery .image:not(.hide)'));
    currentImageIndex = currentImages.indexOf(element);
    
    document.body.style.overflow = "hidden";
    
    updatePreviewImage(element);
    
    previewBox.classList.add("show");
    shadow.classList.add("show");
    
    // Close handlers
    closeIcon.onclick = closePreview;
    shadow.onclick = closePreview;
    
    // Navigation handlers
    prevBtn.onclick = navigatePrev;
    nextBtn.onclick = navigateNext;
    
    // Zoom handlers
    zoomBtns.forEach(btn => {
        btn.onclick = () => handleZoom(btn.dataset.zoom);
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', handleKeyboard);
}

function updatePreviewImage(element) {
    const selectedPrevImg = element.querySelector("img").src;
    const selectedImgCategory = element.getAttribute("data-name");
    
    if (previewImg && categoryName) {
        previewImg.src = selectedPrevImg;
        categoryName.textContent = selectedImgCategory;
        updateImageCounter();
        resetZoom();
    }
}

function updateImageCounter() {
    if (imageCounter) {
        imageCounter.textContent = `${currentImageIndex + 1} / ${currentImages.length}`;
    }
}

function navigatePrev() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        updatePreviewImage(currentImages[currentImageIndex]);
    }
}

function navigateNext() {
    if (currentImageIndex < currentImages.length - 1) {
        currentImageIndex++;
        updatePreviewImage(currentImages[currentImageIndex]);
    }
}

function handleZoom(action) {
    if (!previewImg) return;
    
    switch(action) {
        case 'in':
            currentZoom = Math.min(currentZoom + 0.2, 3);
            break;
        case 'out':
            currentZoom = Math.max(currentZoom - 0.2, 0.5);
            break;
        case 'reset':
            currentZoom = 1;
            break;
    }
    
    previewImg.style.transform = `scale(${currentZoom})`;
}

function resetZoom() {
    currentZoom = 1;
    if (previewImg) {
        previewImg.style.transform = `scale(1)`;
    }
}

function handleKeyboard(e) {
    switch(e.key) {
        case 'ArrowLeft':
            navigatePrev();
            break;
        case 'ArrowRight':
            navigateNext();
            break;
        case 'Escape':
            closePreview();
            break;
        case '+':
        case '=':
            handleZoom('in');
            break;
        case '-':
        case '_':
            handleZoom('out');
            break;
        case '0':
            handleZoom('reset');
            break;
    }
}

function closePreview() {
    previewBox.classList.remove("show");
    shadow.classList.remove("show");
    document.body.style.overflow = "auto";
    document.removeEventListener('keydown', handleKeyboard);
    resetZoom();
}

//Gallery Javascript
//Gallery Javascript
// Show Guest Review 
// Show Guest Review 
function showGuestData() {
  console.log('Loading guest reviews...');
  let output = '';
  $.ajax({
    url: 'php/show_reviews.php',
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      console.log('Reviews loaded:', data);
      if (data && data.length > 0) {
        for (let i = 0; i < data.length; i++) {
          output += "<li class='reviewCard'><div class='guestImg'><img class='reviewImg' draggable='false' src='" + data[i].image_path + "'></div><h2>" + data[i].FullName + "</h2><p>" + data[i].Review + "</p></li>";
        }
        $('.Reviewarea').html(output);
      } else {
        $('.Reviewarea').html("<li style='color: white; text-align: center; width: 100%; padding: 40px;'>No reviews available yet.</li>");
      }
    },
    error: function(xhr, status, error) {
      console.error('Error loading reviews:', error);
      $('.Reviewarea').html("<li style='color: white; text-align: center; width: 100%; padding: 40px;'>Unable to load reviews at this time.</li>");
    }
  });
}
// Show Guest Review 
// Show Guest Review 


$(document).on('click', '.ShowroomOn', function () {
  console.log('Show room button clicked');
  
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
  
  console.log('Check-in:', checkInDate, 'Check-out:', checkOutDate, 'Guests:', numberGuest);
  
  if (!checkInDate || !checkOutDate) {
    alert("Please select both check-in and check-out dates.");
    return;
  }
  
  if (checkInDate >= checkOutDate) {
    alert("Invalid Date. Check-out date must be after check-in date.");
    return;
  } 
  else if (checkInDate < todayDate) {
    alert("Invalid Date. Check-in date must be today or later.");
    return;
  }
  else {
    // Redirect to rooms page with search parameters
    const queryParams = new URLSearchParams({
        checkInDate: checkInDate,
        checkOutDate: checkOutDate,
        numberGuest: numberGuest
    });
    
    console.log('Redirecting to rooms.php with params:', queryParams.toString());
    window.location.href = `rooms.php?${queryParams.toString()}`;
  }
});
// Book Room Button Click


function openBookingPHP(buttonOrRoom) {
    // Check if it's a button element or a room object
    let roomData;
    
    if (typeof buttonOrRoom === 'object' && buttonOrRoom.RoomId) {
        // It's a room object from rooms.php
        roomData = {
            roomId: buttonOrRoom.RoomId,
            roomName: buttonOrRoom.RoomName,
            roomType: buttonOrRoom.RoomType,
            attachBathroom: buttonOrRoom.AttachBathroom === '1' ? 'Yes' : 'No',
            nonSmokingRoom: buttonOrRoom.NonSmokingRoom === '1' ? 'Yes' : 'No',
            totalOccupancy: buttonOrRoom.TotalOccupancy,
            availabilities: buttonOrRoom.Availabilities,
            price: buttonOrRoom.Price,
            ImagePath: buttonOrRoom.imgpath || buttonOrRoom.ImagePath
        };
        
        // Get dates from URL params if on rooms page
        const urlParams = new URLSearchParams(window.location.search);
        roomData.checkInDate = urlParams.get('checkInDate') || $('#checkin_Room').val();
        roomData.checkOutDate = urlParams.get('checkOutDate') || $('#checkout_Room').val();
        roomData.numberGuest = urlParams.get('numberGuest') || $('#guestNumber').val();
    } else {
        // It's a button element from home page
        roomData = {
            roomId: buttonOrRoom.getAttribute("data-roomId"),
            roomName: buttonOrRoom.getAttribute("data-roomName"),
            roomType: buttonOrRoom.getAttribute("data-roomType"),
            attachBathroom: buttonOrRoom.getAttribute("data-AttachBathroom"),
            nonSmokingRoom: buttonOrRoom.getAttribute("data-NonSmokingRoom"),
            totalOccupancy: buttonOrRoom.getAttribute("data-TotalOccupancy"),
            availabilities: buttonOrRoom.getAttribute("data-Availabilities"),
            price: buttonOrRoom.getAttribute("data-Price"),
            ImagePath: buttonOrRoom.getAttribute("data-ImagePath"),
            checkInDate: $('#checkin_Room').val(),
            checkOutDate: $('#checkout_Room').val(),
            numberGuest: $('#guestNumber').val()
        };
    }

    const queryParams = new URLSearchParams(roomData);
    const bookingURL = "bookroom.php?" + queryParams.toString();
    window.location.href = bookingURL;
}






