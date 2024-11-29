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
  // script.js

  // Define an array to store events
  let events = [];

  // letiables to store event input fields and reminder list
  let eventDateInput =
    document.getElementById("eventDate");
  let eventTitleInput =
    document.getElementById("eventTitle");
  let eventDescriptionInput =
    document.getElementById("eventDescription");
  let reminderList =
    document.getElementById("reminderList");

  // Counter to generate unique event IDs
  let eventIdCounter = 1;


  // Function to generate a range of 
  // years for the year select input
  function generate_year_range(start, end) {
    let years = "";
    for (let year = start; year <= end; year++) {
      years += "<option value='" +
        year + "'>" + year + "</option>";
    }
    return years;
  }

  // Initialize date-related letiables
  today = new Date();
  currentMonth = today.getMonth();
  currentYear = today.getFullYear();
  selectYear = document.getElementById("year");
  selectMonth = document.getElementById("month");

  createYear = generate_year_range(1970, 2050);

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
    "December"
  ];
  let days = [
    "Sun", "Mon", "Tue", "Wed",
    "Thu", "Fri", "Sat"];

  $dataHead = "<tr>";
  for (dhead in days) {
    $dataHead += "<th data-days='" +
      days[dhead] + "'>" +
      days[dhead] + "</th>";
  }
  $dataHead += "</tr>";

  document.getElementById("thead-month").innerHTML = $dataHead;

  monthAndYear =
    document.getElementById("monthAndYear");
  showCalendar(currentMonth, currentYear);

  // Function to navigate to the next month
  function next() {
    currentYear = currentMonth === 11 ?
      currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
  }

  // Function to navigate to the previous month
  function previous() {
    currentYear = currentMonth === 0 ?
      currentYear - 1 : currentYear;
    currentMonth = currentMonth === 0 ?
      11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
  }

  // Function to jump to a specific month and year
  function jump() {
    currentYear = parseInt(selectYear.value);
    currentMonth = parseInt(selectMonth.value);
    showCalendar(currentMonth, currentYear);
  }

  // Function to display the calendar
  function showCalendar(month, year) {
    let firstDay = new Date(year, month, 1).getDay();
    tbl = document.getElementById("calendar-body");
    tbl.innerHTML = "";
    monthAndYear.innerHTML = months[month] + " " + year;
    selectYear.value = year;
    selectMonth.value = month;

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

          if (
            date === today.getDate() &&
            year === today.getFullYear() &&
            month === today.getMonth()
          ) {
            cell.className = "date-picker selected";
          }

          // Check if there are events on this date
          if (hasEventOnDate(date, month, year)) {
            cell.classList.add("event-marker");
            cell.appendChild(
              createEventTooltip(date, month, year)
            );
          }

          row.appendChild(cell);
          date++;
        }
      }
      tbl.appendChild(row);
    }

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

  // Call the showCalendar function initially to display the calendar
  showCalendar(currentMonth, currentYear);
  // Assuming you have a function to fetch notifications from the backend
  const notificationContainer = document.querySelector('.notification-container');
  fetch('/notifications', {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      if (response.status === 401) {
        window.location.href = '/signin';
      } else if (response.status === 200) {
        return response.json();
      } else if (response.status === 500) {
        throw new Error('Internal Server Error');  
      } else if(response.status === 204) {
        throw new Error('No Notifications Found');
      }
    })
    .then(notifications => {
      if (notifications.length === 0)
        return;
      notifications.forEach(notification => {
        const notificationDiv = document.createElement('div');
        notificationDiv.id = notification.id;
        notificationDiv.classList.add('notification');
        notificationDiv.innerHTML = `
          <h3>${notification.title}</h3>
          <p>${notification.message}</p>
        `;
        notificationContainer.appendChild(notificationDiv);
        console.log(notification)
        if (notification.title === 'New Vendor') {
          notificationDiv.classList.add('type-new-vendor');
          notificationDiv.addEventListener('click', () => {
            window.location.href = `/vendor/${notification.reference}`;
          });
        } else if (notification.title === 'New Package') {
          notificationDiv.classList.add('type-new-package');
          notificationDiv.addEventListener('click', () => {
            window.location.href = `/new-package/${notification.reference}`;
          });
        }
      });
    }).catch(error => {
      if(error.message === 'No Notifications Found') {
        return;
      }
      console.error(error);
    });

  // Get the notification container



  const weddingCardsContainer = document.querySelector(".wedding-cards");

  fetch("/fetch-wedding-data", {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
      'Content-Type': 'application/json'
    }
  })
    .then((response) => {
      if (response.status == 401) {
        window.location.href = '/signin';
      } else if (response.status == 500) {
        showNotification("error", "Something went wrong");
      }
      return response.json();
    })
    .then((weddings) => {
      weddings.forEach((wedding) => {
        const card = document.createElement("div");
        card.classList.add("wedding-card");
        card.id=wedding.weddingID;

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
          acceptButton.addEventListener('click', () => {
            window.location.href = `/selectPackages/${wedding.weddingID}`
          })
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
                  'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                },
                body: JSON.stringify({
                  weddingID: wedding.weddingID,
                }),
              })
                .then((res) => {
                  if (res.status === 401) {
                    alert("You are not logged in");
                    window.location.href = '/signin';
                  } else if (res.status === 200) {
                    return res.json();
                  } else {
                    throw new Error("Network response was not ok");
                  }
                  
                }).then((data) => {
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
    })
    .catch((error) => console.error("Error fetching wedding data:", error));

  const logoutbutton = document.querySelector(".LogOut");
  if (logoutbutton) {
    logoutbutton.addEventListener("click", () => {
      const confirmed = confirm("Are you sure you want to log out?");
      if (confirmed) {
        fetch("/planner-logout", {

          headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
            'Content-Type': 'application/json'
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
});
