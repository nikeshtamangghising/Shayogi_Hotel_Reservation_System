const daysTag = document.querySelector(".days");
const currentDate = document.querySelector(".current-date");
const prevNextIcon = document.querySelectorAll(".icons span");
const setectdate = document.querySelectorAll(".setectdate");
const setectAvilable = document.querySelectorAll(".setectdateAvilable");
var clickedFullDate;

let date = new Date();
let currYear = date.getFullYear();
let currMonth = date.getMonth();

const months = [
  "January", "February", "March", "April", "May", "June", "July",
  "August", "September", "October", "November", "December"
];

const renderCalendar = () => {
  let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
  let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
  let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
  let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
  let liTag = "";

  for (let i = firstDayofMonth; i > 0; i--) {
    liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
  }

  for (let i = 1; i <= lastDateofMonth; i++) {
    let isToday =
      i === date.getDate() &&
      currMonth === new Date().getMonth() &&
      currYear === new Date().getFullYear()
        ? "active"
        : "";
    liTag += `<li class="${isToday}" onclick="handleDateClick(${i})">${i}</li>`;
  }

  for (let i = lastDayofMonth; i < 6; i++) {
    liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
  }
  currentDate.innerText = `${months[currMonth]} ${currYear}`;
  daysTag.innerHTML = liTag;
};

renderCalendar();
prevNextIcon.forEach(icon => {
  icon.addEventListener("click", () => {
    currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

    if (currMonth < 0 || currMonth > 11) {
      date = new Date(currYear, currMonth, new Date().getDate());
      currYear = date.getFullYear();
      currMonth = date.getMonth();
    } else {
      date = new Date();
    }
    renderCalendar();
  });
});

function handleDateClick(clickedDate) {
  clickedFullDate = new Date(currYear, currMonth, clickedDate);
  setectdate.forEach(setectdate => {
    const ReservationsText = "Reservations On Date: ";
    setectdate.textContent = ReservationsText + " " + clickedFullDate.toLocaleDateString();
    Showbooking();
  });
  setectAvilable.forEach(setectAvilable => {
    const AvailableText = "Room Available On Date: ";
    setectAvilable.textContent = AvailableText + " " + clickedFullDate.toLocaleDateString();
    ShowAvailableroom();
  });
}



  function Showbooking() {
    // Parse the original date string to a Date object
    const dateObject = new Date(clickedFullDate);

    // Get the year, month, and day from the date object
    const year = dateObject.getFullYear();
    const month = String(dateObject.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so we add 1
    const day = String(dateObject.getDate()).padStart(2, '0');

    // Format the date in "yyyy-mm-dd" format
    const formattedDate = `${year}-${month}-${day}`;
    let output = '';
    $.ajax({
      url: 'dashboard/datephp/showbooking.php',
      method: 'POST',
      dataType: 'json',
      data: { Date: formattedDate },
      success: function (data) {
        console.log(data);
        for (let i = 0; i < data.length; i++) {
          output += "<div class='roomcard'><div class='guestRevName'><div>Name: "+ data[i].FullName +"</div><div>Email: "+data[i].Email +"</div><div>Country: "+ data[i].Country + "</div><div>Phone No: "+ data[i].Phone +"</div></div><div class='guestRevRoom'><div>Check IN: "+ data[i].CheckInDate +"</div><div>Stays: "+data[i].Stay +" Nights</div><div>Room: "+ data[i].RoomName +" With "+ data[i].RoomType + "</div><div>Check OUT: "+ data[i].CheckOutDate +"</div></div><div class='guestRevPrice'><div>Price: "+ data[i].Price +"</div><div>Custom Name: "+ data[i].CustomNo +"</div></div></div>";
        }
        $('.bookingdetails').html(output);
      }
    });
  }


  function ShowAvailableroom() {  
    // Parse the original date string to a Date object
    const dateObject = new Date(clickedFullDate);

    // Get the year, month, and day from the date object
    const year = dateObject.getFullYear();
    const month = String(dateObject.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so we add 1
    const day = String(dateObject.getDate()).padStart(2, '0');

    // Format the date in "yyyy-mm-dd" format
    const formattedDate = `${year}-${month}-${day}`;
    let output = '';
    $.ajax({
      url: 'dashboard/datephp/ShowAvailableroom.php',
      method: 'POST',
      dataType: 'json',
      data: { Date: formattedDate },
      success: function (data) {
        console.log(data);
        for (let i = 0; i < data.length; i++) {
          output += "<div class='Availablecard'><div>Room Custom Name: "+ data[i].CustomNo +"</div><div>Room Name: "+ data[i].RoomName +" with "+ data[i].RoomType +" </div><div>Room Available: "+ data[i].Availabilities +"</div></div>";
      
            }
        $('.Availabledetails').html(output);
      }
    });
  }



