document.addEventListener("DOMContentLoaded", function () {
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


  const weddingCardsContainer = document.querySelector(".wedding-cards");

  fetch("/fetch-wedding-data")
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((weddings) => {
      weddings.forEach((wedding) => {
        const card = document.createElement("div");
        card.classList.add("wedding-card");

        card.innerHTML = `
           <h4>${wedding.brideName} & ${wedding.groomName} </h4>
            <p>${wedding.date}</p>
            <p>${wedding.dayNight}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
           

            
        `;

        if (wedding.weddingState == "new") {
          card.innerHTML = `
           <h4>${wedding.brideName} & ${wedding.groomName} </h4>
            <p>${wedding.date}</p>
            <p>${wedding.dayNight}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
            
        
        `;
          card.classList.add("new");
          const acceptButton = document.createElement("button");
          acceptButton.classList.add("acceptButton");
          acceptButton.textContent = "Accept";
          acceptButton.addEventListener("click", (e) => {
            const confirmed = confirm("Are you sure you want to accept?");
            if (confirmed) {
              e.stopPropagation();

              fetch("/update-wedding-state", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  weddingID: wedding.weddingID,
                }),
              })
                .then((res) => res.json())
                .then((data) => {
                  if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                  } else {
                    alert("Error" + data.message);
                  }
                })
                .catch((error) => {
                  console.error("Error updating wedding state:", error);
                });
            }
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
                },
                body: JSON.stringify({
                  weddingID: wedding.weddingID,
                }),
              })
                .then((res) => res.json())
                .then((data) => {
                  if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                  } else {
                    alert("Error" + data.message);
                  }
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
           <h4>${wedding.brideName} & ${wedding.groomName} </h4>
            <p>${wedding.date}</p>
            <p>${wedding.dayNight}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
            
        
        `;
          card.classList.add("Unassigned");
          const selectPackagesButton = document.createElement("button");
          selectPackagesButton.classList.add("selectPackagesButton");
          selectPackagesButton.textContent = "Select Packages";
          selectPackagesButton.addEventListener("click", (e) => {
            e.stopPropagation();
            window.location.href = "/selectPackages";
          });
          card.appendChild(selectPackagesButton);
        }

        if (wedding.weddingState == "ongoing") {
          card.innerHTML = `
          <h4>${wedding.brideName} & ${wedding.groomName} </h4>
           <p>${wedding.date}</p>
           <p>${wedding.dayNight}</p>
           <p>${wedding.location}</p>
           <p>${wedding.theme}</p>
           
       
       `;
          card.classList.add("ongoing");
          card.addEventListener("click", () => {
            window.location.href = "/plannerWedding";
          });
        }

        weddingCardsContainer.appendChild(card);
      });
    })
    .catch((error) => console.error("Error fetching wedding data:", error));

  const logoutbutton = document.querySelector(".LogOut");
  if (logoutbutton) {
    logoutbutton.addEventListener("click", () => {
      const confirmed = confirm("Are you sure you want to log out?");
      if (confirmed) {
        fetch("/planner-logout", {
          method: "POST",
        })
          .then((response) => response.json())
          .then((data) => {
            alert(data.message);
            window.location.href =
              "http://planner.blissfulbeginnings.local/SignIn";
          })
          .catch((error) => console.error("Error logging out", error));
      }
    });
  }
});
