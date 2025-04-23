function showNotification(message, color) {
  // Create notification element
  const notification = document.createElement("div");
  notification.textContent = message;
  notification.style.position = "fixed";
  notification.style.bottom = "20px";
  notification.style.left = "20px";
  notification.style.backgroundColor = color;
  notification.style.color = "white";
  notification.style.padding = "10px 20px";
  notification.style.borderRadius = "5px";
  notification.style.zIndex = 1000;
  notification.style.fontSize = "16px";

  // Append to body
  document.body.appendChild(notification);

  // Remove after 3 seconds
  setTimeout(() => {
    notification.remove();
  }, 3000);
}

document.addEventListener("DOMContentLoaded", function () {
  const loadingScreen = document.getElementById("loading-screen");
  const mainContent = document.querySelector(".dashboard");
  const modalContainer = document.querySelector(".modal-container");
  const calendarModalContainer = document.querySelector(
    ".calendar-modal-container"
  );
  const calendarModalContainer2 = document.querySelector('.calendar-modal2-container');
  const cancelBtn = document.querySelector(".calendar-modal .cancel-button");
  const confirmBtn = document.querySelector(".calendar-modal .confirm-button");
  const cancelBtn2 = document.querySelector(".calendar-modal2 .cancel-button");
  const confirmBtn2 = document.querySelector(".calendar-modal2 .confirm-button");


// CSS to style unavailable days
const styleId = 'unavailable-day-style';
if (!document.getElementById(styleId)) {
    const style = document.createElement('style');
    style.id = styleId;
    style.textContent = `
    .unavailable-day {
            position: relative;
     }
 .unavailable-day::after {
    content: '';
    position: absolute;
    top: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
    display: block !important;
    z-index: 1;
}
    `;
    document.head.appendChild(style);
}
async function fetchUnavailableDates() {
  try {
      const response = await fetch(`/get-unavailable`, {
          method: 'GET',
          headers: {
              'Authorization': `Bearer ${localStorage.getItem('authToken')}`
          }
      });
      
      if (!response.ok) throw new Error('Failed to fetch unavailable dates');
      
      const data = await response.json();
      
      // Convert object to array if needed
      if (Array.isArray(data)) {
          return data; // Already an array
      } else if (data && typeof data === 'object') {
          // If it's an object, extract the keys (dates)
          return Object.values(data);
      } else {
          // If it's neither array nor object, return empty array
          return [];
      }
      
  } catch (error) {
      console.error('Error fetching unavailable dates:', error);
      return []; // Return empty array on error
  }
}


  // Define an array to store events
  let events = [];

  // letiables to store event input fields and reminder list
  let eventDateInput = document.getElementById("eventDate");
  let eventTitleInput = document.getElementById("eventTitle");
  let eventDescriptionInput = document.getElementById("eventDescription");
  let reminderList = document.getElementById("reminderList");

  // Counter to generate unique event IDs
  let eventIdCounter = 1;

  // Function to generate a range of
  // years for the year select input
  function generate_year_range(start, end) {
    let years = "";
    for (let year = start; year <= end; year++) {
      years += "<option value='" + year + "'>" + year + "</option>";
    }
    return years;
  }

  // Initialize date-related letiables
  today = new Date();
  currentMonth = today.getMonth();
  currentYear = today.getFullYear();
  selectYear = document.getElementById("year");
  selectMonth = document.getElementById("month");

  createYear = generate_year_range(currentYear - 1, currentYear + 2);

  document.getElementById("year").innerHTML = createYear;

  let calendar = document.getElementById("calendar");

  let months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  let days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

  $dataHead = "<tr>";
  for (dhead in days) {
    $dataHead += "<th data-days='" + days[dhead] + "'>" + days[dhead] + "</th>";
  }
  $dataHead += "</tr>";

  document.getElementById("thead-month").innerHTML = $dataHead;

  monthAndYear = document.getElementById("monthAndYear");
  showCalendar(currentMonth, currentYear);

  document.getElementById("next").addEventListener("click", next);
  document.getElementById("previous").addEventListener("click", previous);
  document.getElementById("jump").addEventListener("click", jump);

  // Function to navigate to the next month
  function next() {
    currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
  }

  // Function to navigate to the previous month
  function previous() {
    currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
    currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
  }

  // Function to jump to a specific month and year
  function jump() {
    currentYear = parseInt(selectYear.value);
    currentMonth = parseInt(selectMonth.value);
    showCalendar(currentMonth, currentYear);
  }

  // Function to display the calendar
   async function showCalendar(month, year) {
    let firstDay = new Date(year, month, 1).getDay();
    tbl = document.getElementById("calendar-body");
    tbl.innerHTML = "";
    monthAndYear.innerHTML = months[month] + " " + year;
    selectYear.value = year;
    selectMonth.value = month;
     // Fetch unavailable dates
     const unavailableDates = await fetchUnavailableDates();
     console.log('Unavailable dates:', unavailableDates);
  
    
     // Ensure we have an array of dates to work with
     const unavailableDatesArray = Array.isArray(unavailableDates)
         ? unavailableDates
         : Object.values(unavailableDates || {});

    let date = 1;
    for (let i = 0; i < 6; i++) {
      let row = document.createElement("tr");
      for (let j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          cell = document.createElement("td");
          cellText = document.createTextNode("");
          cell.appendChild(cellText);
          row.appendChild(cell);
        } else if (date > daysInMonth(month, year)) {
          break;
        } else {
          cell = document.createElement("td");
          cell.setAttribute("data-date", date);
          cell.setAttribute("data-month", month + 1);
          cell.setAttribute("data-year", year);
          cell.setAttribute("data-month_name", months[month]);
          cell.className = "date-picker";
          cell.innerHTML = "<span>" + date + "</span";
          // Check if this date is unavailable
          const currentDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
          if (unavailableDatesArray.includes(currentDateStr)) {
              cell.classList.add("unavailable-day");
          }
          
          cell.addEventListener("click", function() {
              openCalendarModal(this);
          });
          
          if (
              date === today.getDate() &&
              year === today.getFullYear() &&
              month === today.getMonth()
          ) {
              cell.className = "date-picker selected";
              // Ensure we don't lose the unavailable-day class if this day is also unavailable
              const currentDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
              if (unavailableDatesArray.includes(currentDateStr)) {
                  cell.classList.add("unavailable-day");
              }
          }

          

          // Check if there are events on this date
          if (hasEventOnDate(date, month, year)) {
            cell.classList.add("event-marker");
            cell.appendChild(createEventTooltip(date, month, year));
          }

          row.appendChild(cell);
          date++;
        }
      }
      tbl.appendChild(row);
    }
  }

  //modal for calendar
  function openCalendarModal(clickedCell) {
  

    const date = clickedCell.getAttribute("data-date");
    const month = clickedCell.getAttribute("data-month");
    const year = clickedCell.getAttribute("data-year");

    if (date && month && year) {
      selectedDate = `${year}-${month.padStart(2, "0")}-${date.padStart(
        2,
        "0"
      )}`;

      const displayDate = new Date(selectedDate);

      displayDate.toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
      const isUnavailable=clickedCell.classList.contains('unavailable-day');
        // Update modal text based on availability status
        if (isUnavailable) {
          calendarModalContainer2.classList.add('show');
            
      } else {
          calendarModalContainer.classList.add('show');
      }

      return selectedDate;
    }
  }
  function closeCalendarModal() {
    calendarModalContainer.classList.remove("show");
  }
  function closeCalendarModal2() {
    calendarModalContainer2.classList.remove('show');
    
}

  // Event Listeners
  if (calendarModalContainer && cancelBtn) {
    // Close modal when clicking cancel button
    cancelBtn.addEventListener("click", closeCalendarModal);
  }
  if (calendarModalContainer && confirmBtn) {
    confirmBtn.addEventListener("click", () => {
      if (!selectedDate) {
        showNotification("Please select a date first", "red");
        return;
      }
      console.log(selectedDate);
      fetch(`/set-unavailable`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("authToken")}`,
        },
        body: JSON.stringify({ date: selectedDate }),
      })
        .then((response) => {
          if (!response.ok) {
            if (response.status === 409) {
              closeCalendarModal();
              showNotification(" Date is already marked as unavailable", "red");
              return Promise.reject("Conflict - Date already marked");
            }

            throw new Error("Failed to set unavailable date");
          }
          return response.json();
        })

        .then((data) => {
          showNotification("Date marked as unavailable", "green");
          closeCalendarModal();
          console.log("hi");
          // Refresh calendar to show the unavailable date
          showCalendar(currentMonth, currentYear);
        })

        .catch((error) => {
          if (error !== "Conflict - Date already marked") {
            closeCalendarModal();
            showNotification("Failed to set unavailable date", "red");
          }
        });
    });
  }
   // For re-availability popup
   if (calendarModalContainer2&&cancelBtn2) {

    // Close modal when clicking cancel button
    cancelBtn2.addEventListener('click', closeCalendarModal2);
}
if (calendarModalContainer2 && confirmBtn2) {
    confirmBtn2.addEventListener('click', () => {  
        if (!selectedDate) {
            showNotification("Please select a date first", "red");
            return;
        }
        fetch(`/remove-unavailable`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            },
            body: JSON.stringify({ date: selectedDate })
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    closeCalendarModal2();
                    showNotification("Date not found or already available", "red");
                    return Promise.reject('Not Found - Date already available');
                }

                throw new Error('Failed to remove unavailable date');
            }
            return response.json();
        })
        .then(data => {
            showNotification("Date marked as available", "green");
            closeCalendarModal2();
            // Refresh calendar to show the date is now available
            showCalendar(currentMonth, currentYear);
        })
        .catch(error => {
            if (error !== 'Not Found - Date already available') {
                closeCalendarModal2();
                showNotification("Failed to make date available", "red");
            }
        });


});
}





  // Function to create an event tooltip
  function createEventTooltip(date, month, year) {
    let tooltip = document.createElement("div");
    tooltip.className = "event-tooltip";
    let eventsOnDate = getEventsOnDate(date, month, year);
    for (let i = 0; i < eventsOnDate.length; i++) {
      let event = eventsOnDate[i];
      let eventDate = new Date(event.date);
      let eventText = `<strong>${event.title}</strong> - 
            ${event.description} on 
            ${eventDate.toLocaleDateString()}`;
      let eventElement = document.createElement("p");
      eventElement.innerHTML = eventText;
      tooltip.appendChild(eventElement);
    }
    return tooltip;
  }

  // Function to get events on a specific date
  function getEventsOnDate(date, month, year) {
    return events.filter(function (event) {
      let eventDate = new Date(event.date);
      return (
        eventDate.getDate() === date &&
        eventDate.getMonth() === month &&
        eventDate.getFullYear() === year
      );
    });
  }

  // Function to check if there are events on a specific date
  function hasEventOnDate(date, month, year) {
    return getEventsOnDate(date, month, year).length > 0;
  }

  // Function to get the number of days in a month
  function daysInMonth(iMonth, iYear) {
    return 32 - new Date(iYear, iMonth, 32).getDate();
  }

  

  const modal = document.getElementById("modal");
  const modalContent = document.getElementById("modal-content");
  modalContent.classList.add("modal-content");
  modalContent.innerHTML = `
      <span class="close-button">&times;</span>
     
      <div class="search-container">
            <input type="text" placeholder="Search" class="search-input" />
        </div>
      <div class="package-grid">
        <!-- Vendor information will be populated here -->
      </div>
      <button class="submit-button">Reccomend Packages</button>
    
  `;
  // Assuming you have a function to fetch notifications from the backend
  const notificationContainer = document.querySelector(
    ".notification-container"
  );
  fetch("/notifications", {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.status === 401) {
        window.location.href = "/signin";
      } else if (response.status === 200) {
        return response.json();
      } else if (response.status === 500) {
        throw new Error("Internal Server Error");
      } else if (response.status === 204) {
        throw new Error("No Notifications Found");
      }
    })
    .then((notifications) => {
      if (notifications.length === 0) return;
      notifications.forEach((notification) => {
        const notificationDiv = document.createElement("div");
        notificationDiv.id = notification.id;
        notificationDiv.classList.add("notification");
        notificationDiv.innerHTML = `
          <h3>${notification.title}</h3>
          <p>${notification.message}</p>
        `;
        notificationContainer.appendChild(notificationDiv);
        console.log(notification);
        if (notification.title === "New Vendor") {
          notificationDiv.classList.add("type-new-vendor");
          notificationDiv.addEventListener("click", () => {
            window.location.href = `/vendor/${notification.reference}`;
          });
        } else if (notification.title === "New Package") {
          notificationDiv.classList.add("type-new-package");
          notificationDiv.addEventListener("click", () => {
            window.location.href = `/new-package/${notification.reference}`;
          });
        }
      });
    })
    .catch((error) => {
      if (error.message === "No Notifications Found") {
        return;
      }
      console.error(error);
    });

  // Get the notification container

  const weddingCardsContainer = document.querySelector(".wedding-cards");

  function createWeddingCards(weddings) {
    if (weddings.length > 0) {
      weddings.forEach((wedding) => {
        const card = document.createElement("div");
        card.classList.add("wedding-card");
        card.id = wedding.weddingID;

        card.innerHTML = `
         <h3>${wedding.brideName} & ${wedding.groomName} </h3>
          <p>${wedding.date}</p>
          <p>${wedding.dayNight}</p>
          <p>${wedding.location}</p>
          <p>${wedding.theme}</p>            
      `;

        if (wedding.weddingState == "new") {
          card.innerHTML = `
         <h3>${wedding.brideName} & ${wedding.groomName} </h3>
          <p><b>Date:</b>${wedding.date}</p>
          <p><b>Day/Night</b>:${wedding.dayNight}</p>
          <p><b>Location:</b>${wedding.location}</p>
          <p><b>Theme:</b>${wedding.theme}</p>
          
      
      `;
          card.classList.add("new");
          card.id = wedding.weddingID;
          const acceptButton = document.createElement("button");
          acceptButton.classList.add("acceptButton");
          acceptButton.textContent = "Accept";
          acceptButton.addEventListener("click", () => {
            window.location.href = `/selectPackages/${wedding.weddingID}`;
          });
          card.appendChild(acceptButton);

          const rejectButton = document.createElement("button");
          rejectButton.classList.add("rejectButton");
          rejectButton.textContent = "Reject";
          rejectButton.addEventListener("click", (e) => {
            const confirmed = confirm("Are you sure you want to delete?");
            if (confirmed) {
              e.stopPropagation();

              fetch("/delete-wedding", {
                method: "DELETE",
                headers: {
                  "Content-Type": "application/json",
                  Authorization: `Bearer ${localStorage.getItem("authToken")}`,
                },
                body: JSON.stringify({
                  weddingID: wedding.weddingID,
                }),
              })
                .then((res) => {
                  if (res.status === 401) {
                    alert("You are not logged in");
                    window.location.href = "/signin";
                  } else if (res.status === 200) {
                    return res.json();
                  } else {
                    throw new Error("Network response was not ok");
                  }
                })
                .then((data) => {
                  console.log("in here");
                  console.log(wedding.weddingID);
                  console.log(document.getElementById(wedding.weddingID));
                  document.getElementById(wedding.weddingID).remove();
                })
                .catch((error) => {
                  console.error("Error deleting wedding:", error);
                });
            }
          });
          card.appendChild(rejectButton);
        }

        if (wedding.weddingState == "unassigned") {
          card.innerHTML = `
         <h3>${wedding.brideName} & ${wedding.groomName} </h3>
          <p><b>Date:</b>${wedding.date}</p>
          <p><b>Day/Night</b>:${wedding.dayNight}</p>
          <p><b>Location:</b>${wedding.location}</p>
          <p><b>Theme:</b>${wedding.theme}</p>
      `;
          card.id = wedding.weddingID;
          card.classList.add("Unassigned");
          card.addEventListener("click", (e) => {
            e.stopPropagation();
            window.location.href = "/wedding/" + card.id;
          });
        }

        if (wedding.weddingState == "ongoing") {
          card.innerHTML = `
        <h3>${wedding.brideName} & ${wedding.groomName} </h3>
          <p><b>Date:</b>${wedding.date}</p>
          <p><b>Day/Night</b>:${wedding.dayNight}</p>
          <p><b>Location:</b>${wedding.location}</p>
          <p><b>Theme:</b>${wedding.theme}</p>
         
     
     `;
          card.classList.add("ongoing");
          card.addEventListener("click", (event) => {
            window.location.href = `/wedding/${wedding.weddingID}`;
          });
        }

        weddingCardsContainer.appendChild(card);
      });
      loadingScreen.style.display = "none";
      mainContent.style.display = "flex";
    } else {
      const noWeddingsMessage = document.createElement("p");
      noWeddingsMessage.textContent =
        "No weddings found. Please check back later.";
      weddingCardsContainer.appendChild(noWeddingsMessage);
    }
  }

  function displayAllweddings() {
    fetch("/fetch-wedding-data", {
      method: "GET",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.status == 401) {
          window.location.href = "/signin";
        } else if (response.status == 500) {
          showNotification("error", "Something went wrong");
        }
        return response.json();
      })
      .then((weddings) => createWeddingCards(weddings))
      .catch((error) => console.error("Error fetching wedding data:", error));
  }

  displayAllweddings();

  const logoutbutton = document.querySelector(".LogOut");
  if (logoutbutton) {
    logoutbutton.addEventListener("click", () => {
      const confirmed = confirm("Are you sure you want to log out?");
      if (confirmed) {
        fetch("/planner-logout", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            "Content-Type": "application/json",
          },
          method: "POST",
        })
          .then((response) => response.json())
          .then((data) => {
            alert(data.message);
            window.location.href =
              "http://planner.blissfulbeginnings.local/signin";
          })
          .catch((error) => console.error("Error logging out", error));
      }
    });
  }

  const searchButton = document.querySelector(".search-button");
  const searchInput = document.getElementById("search_id");

  function searchWedding() {
    const searchInput = document
      .getElementById("search_id")
      .value.toLowerCase()
      .trim();

    if (!searchInput) {
      alert("Please enter something to search.");
      return;
    }
    const str1 = searchInput.split(/[ &]/)[0];
    const str2 = searchInput
      .substring(searchInput.lastIndexOf(" ") + 1)
      .split("&")
      .pop();
    weddingCardsContainer.innerHTML = "";

    fetch(`/fetch_details_for_search`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      },
      body: JSON.stringify({
        str1: str1,
        str2: str2,
      }),
    })
      .then((response) => {
        if (response.status === 401) {
          window.location.href = "/signin";
        } else {
          return response.json();
        }
      })
      .then((data) => {
        if (data.status === "success" && data.weddings.length > 0) {
          createWeddingCards(data.weddings);
        } else {
          const noResults = document.createElement("p");
          noResults.textContent =
            "No weddings found for the given search criteria.";
          weddingCardsContainer.appendChild(noResults);
        }
      })
      .catch((error) => {
        console.error("Error fetching wedding:", error);
      });
  }
  searchButton.addEventListener("click", searchWedding);
  searchInput.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      searchWedding();
    }
  });
});
