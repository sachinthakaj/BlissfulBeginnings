const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];

function render() {
    const scrollContainer = document.querySelector(".slide-content");
    const deleteProfile = document.querySelector('.delete-profile');
    const modalContainer = document.querySelector('.modal-container');
    const calendarModalContainer = document.querySelector('.calendar-modal-container');
    const calendarModalContainer2 = document.querySelector('.calendar-modal2-container');
    const cancelBtn = document.querySelector(".calendar-modal .cancel-button");
    const confirmBtn = document.querySelector(".calendar-modal .confirm-button");
    const cancelBtn2 = document.querySelector(".calendar-modal2 .cancel-button");
    const confirmBtn2 = document.querySelector(".calendar-modal2 .confirm-button");

    const cancelButton = document.querySelector('.cancel-button');
    const deleteButton = document.querySelector('.delete-button');
    const editProfile = document.querySelector('.edit-profile');
    const editModalContainer = document.querySelector('#edit-modal-container');
    const confirmButton = document.querySelector('.confirm-button');
    const closeButton = editModalContainer.querySelector('.close-button');
    const prevButton = editModalContainer.querySelector('.prev-button');
    const nextButton = editModalContainer.querySelector('.next-button');
    const submitButton = editModalContainer.querySelector('.submit-button');
    const modalPages = editModalContainer.querySelectorAll('.modal-page');
    const paginationDots = editModalContainer.querySelectorAll('.dot');
    const navigateEditProfileButton = document.querySelector('.view-packages-button');
 
// Update CSS to style unavailable days
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

// Add this function to fetch unavailable dates
async function fetchUnavailableDates() {
    try {
        const response = await fetch(`/vendor/get-unavailable/${vendorID}`, {
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

    createYear = generate_year_range(currentYear-1, currentYear+2);

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
   

    document.getElementById("next").addEventListener("click", next);
  document.getElementById("previous").addEventListener("click", previous);
   document.getElementById("jump").addEventListener("click", jump);
    
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
async function showCalendar(month, year) {
    let firstDay = new Date(year, month, 1).getDay();
    tbl = document.getElementById("calendar-body");
    tbl.innerHTML = "";
    monthAndYear.innerHTML = months[month] + " " + year;
    selectYear.value = year;
    selectMonth.value = month;
    
    // Fetch unavailable dates
    const unavailableDates = await fetchUnavailableDates();
  
    
    // Ensure we have an array of dates to work with
    const unavailableDatesArray = Array.isArray(unavailableDates)
        ? unavailableDates
        : Object.values(unavailableDates || {});
console.log('Unavailable dates array:', unavailableDatesArray);
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
                cell.innerHTML = "<span>" + date + "</span>";
                
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
    //showCalendar(currentMonth, currentYear);




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

    // fetch cards
    async function fetchCards() {
        try {
            console.log(vendorID);
            const response = await fetch(`/vendor/${vendorID}/get-weddings`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                },

            });
            if (response.status == 401) {
                window.location.href = "/signin"
            }
            return response.json();
        } catch (error) {
            console.error('Error fetching cards:', error);
            showNotification("Could not fetch weddings", "red");
            return [];
        }
    }


    // initialize cards
    async function initializeCards() {
        const vendorData = await fetchCards();
        if (vendorData.vendorState ==   'new') {
            messageDiv = document.createElement('div');
            messageDiv.classList.add('message');
            messageDiv.innerHTML = '<h2>Awaiting Planner Approval</h2>';
            scrollContainer.appendChild(messageDiv);
            navigateEditProfileButton.disabled = true;

        } else {
            navigateEditProfileButton.addEventListener('click', navigateEditProfile);
            const cardsData = vendorData.weddings;
            if (Array.isArray(cardsData) && cardsData.length > 0) {
                loadCards(cardsData);
                document.querySelectorAll('.card').forEach(card => {
                    console.log('Adding event listener')
                    card.addEventListener('click', () => {
                        
                        window.location.href = `/vendor/${vendorID}/assignment/${card.id}`
                    })
                })
            } else {
                showNotification("No weddings assigned", "red");
            }
        }
       
    }

    function navigateEditProfile() {
        window.location.href = `/packages/${vendorID}`;
    }



    function createCard(cardData) {
        return `
            <div class="card" id=${cardData.assignmentID}>
                <div class="image-content">
                    <span class="overlay"></span>
                    <div class="card-image">
                        <img src="${cardData.imgSrc}" alt="" class="card-img">
                    </div>
                </div>
                <div class="card-content">
                    <h2 class="name">${cardData.weddingTitle}'s Wedding</h2>
                    <div class="content">
                        <h4 class="description">Date: ${cardData.date}</h4>
                        <h4 class="description">Time: ${cardData.dayNight}</h4>
                        <h4 class="description">Location: ${cardData.location}</h4>
                        <h4 class="description">Wedding Progress: </h4> 
                        <div class="progress-bar-container">
                            <div class="progress-bar wedding-progress-bar" style="width: ${cardData.progress}%"></div>
                        </div>
                        <h4 class="description">Wedding Budget: </h4> 
                        <div class="progress-bar-container">
                             <div class="progress-bar budget-progress-bar" style="width: ${cardData.budget}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function loadCards(cards) {
        let cardWrappersHTML = "";

        // 3 cards in card-wrapper and appending the rest
   
            const cardsInGroup = cards
                .map((card) => createCard(card))
                .join("");
            cardWrappersHTML += cardsInGroup;
        

        // inserting into slide-content
        scrollContainer.innerHTML = cardWrappersHTML;

    }

    // loadCards(cardsData);

    initializeCards();
    document.getElementById('search_id').addEventListener('keyup', (event) => {
        const searchQuery = event.target.value.toLowerCase();
        const cards = document.querySelectorAll('.card');
        cards.forEach((card) => {
            const weddingTitle = card.querySelector('.name').textContent.toLowerCase();
            if (weddingTitle.includes(searchQuery)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

  //modal for calendar
  function openCalendarModal(clickedCell) {
   
    
    const date = clickedCell.getAttribute('data-date');
    const month = clickedCell.getAttribute('data-month');
    const year = clickedCell.getAttribute('data-year');
    
    if (date && month && year) {
        selectedDate = `${year}-${month.padStart(2, '0')}-${date.padStart(2, '0')}`;
        
        const displayDate = new Date(selectedDate);
        
            displayDate.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            const isUnavailable = clickedCell.classList.contains('unavailable-day');
        
            console.log(isUnavailable)
            console.log(clickedCell)
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
        calendarModalContainer.classList.remove('show');
        
    }
    function closeCalendarModal2() {
        calendarModalContainer2.classList.remove('show');
        
    }
   
    // Event Listeners
    if (calendarModalContainer&&cancelBtn) {

        // Close modal when clicking cancel button
        cancelBtn.addEventListener('click', closeCalendarModal);

    }
    if (calendarModalContainer && confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            
            
            if (!selectedDate) {
                showNotification("Please select a date first", "red");
                return;
            }
    console.log(selectedDate);
            fetch(`/vendor/set-unavailable/${vendorID}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                },
                body: JSON.stringify({ date: selectedDate })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 409) {
                        closeCalendarModal();
                        showNotification(" Date is already marked as unavailable", "red");
                        return Promise.reject('Conflict - Date already marked');
                    }
                        
                    throw new Error('Failed to set unavailable date');
                }
                return response.json();
               
            })
           
            .then(data => {
                showNotification("Date marked as unavailable", "green");
                closeCalendarModal();
                // Refresh calendar to show the unavailable date
                showCalendar(currentMonth, currentYear);
            })
        
            .catch(error => {
                if(error !== 'Conflict - Date already marked') {
                    closeCalendarModal();
                showNotification("Failed to set unavailable date", "red");
            }});

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
            fetch(`/vendor/remove-unavailable/${vendorID}`, {
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

    // modal for delete profile
    function openModal() {
        modalContainer.classList.add('show');
    }

    function closeModal() {
        modalContainer.classList.remove('show');
    }

    // Event Listeners
    if (deleteProfile && modalContainer) {
        deleteProfile.addEventListener('click', openModal);

        // Close modal when clicking cancel button
        cancelButton.addEventListener('click', closeModal);

        // Handle delete action
        deleteButton.addEventListener('click', () => {
            fetch('/delete-profile/vendor-details/' + vendorID, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                },
            })
                .then(response => {

                    if (response.status === 204) {
                        showNotification(" There is no vendor in this vendorID", "red");
                    }
                    if (!response.ok) {
                        if (response.status === 409) {
                            closeModal();
                            showNotification(" This vendor has assigned weddings", "red");
                            return
                        }

                    }
                })
            showNotification("Profile deleted", "red");
            window.location.href = '/register';
            closeModal();

        });

        // Close modal when clicking outside
        modalContainer.addEventListener('click', (event) => {
            if (event.target === modalContainer) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modalContainer.classList.contains('show')) {
                closeModal();
            }
        });
    }

    // modal for edit profile
    let currentPage = 1;
    const totalPages = modalPages.length;

    function updateModalPage() {
        // Update pages
        modalPages.forEach(page => {
            page.classList.remove('active');
            if (parseInt(page.dataset.page) === currentPage) {
                page.classList.add('active');
            }
        });

        // Update dots
        paginationDots.forEach(dot => {
            dot.classList.remove('active');
            if (parseInt(dot.dataset.page) === currentPage) {
                dot.classList.add('active');
            }
        });

        // Update buttons
        prevButton.disabled = currentPage === 1;
        if (currentPage === totalPages) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }
    }

    // edit modal open
    function openEditModal() {
        editModalContainer.classList.add('show');
        currentPage = 1;
        updateModalPage();

        fetch('/get-profile-details/vendor-details/' + vendorID, {
            method: 'GET',
            headers:
            {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
            },
        }).then(response => {

            return response.json();
        }).then(vendorData => {
            let changedFields = {};
            document.querySelectorAll('.form-input').forEach(input => {
                input.value = vendorData[input.id];
                input.addEventListener('change', () => {
                    changedFields[input.id] = input.value;
                })
            })
            document.querySelector('.submit-button').addEventListener('click', () => {
                console.log(changedFields);
                if (Object.keys(changedFields).length > 0) {
                    fetch('/update-profile/vendor-details/' + vendorID, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(changedFields)
                    }).then(response => {
                        return response.json();
                    }).then(data => {
                        Object.keys(changedFields).forEach((column) => {
                            vendorData[column] = changedFields[column];
                        });
                        closeEditModal();
                    }).catch(error => {
                        console.error(error);
                    });
                }
            })
        })
    }


    function closeEditModal() {
        editModalContainer.classList.remove('show');
    }

    // Event Listeners
    if (editProfile && editModalContainer) {
        editProfile.addEventListener('click', openEditModal);

        // Close modal with close button
        closeButton.addEventListener('click', closeEditModal);

        // Close modal when clicking outside
        editModalContainer.addEventListener('click', (event) => {
            if (event.target === editModalContainer) {
                closeEditModal();
            }
        });

        // Navigation buttons
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updateModalPage();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateModalPage();
            }
        });

        // Pagination dots
        paginationDots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentPage = parseInt(dot.dataset.page);
                updateModalPage();
            });
        });



        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && editModalContainer.classList.contains('show')) {
                closeEditModal();
            }
        });
    }


}
}

document.addEventListener('DOMContentLoaded', render);
