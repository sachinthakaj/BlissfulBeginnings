const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];

function render() {
    const scrollContainer = document.querySelector(".slide-content");
    const deleteProfile = document.querySelector('.delete-profile');
    const modalContainer = document.querySelector('.modal-container');
    const cancelButton = document.querySelector('.cancel-button');
    const deleteButton = document.querySelector('.delete-button');
    const editProfile = document.querySelector('.edit-profile');
    const editModalContainer = document.querySelector('#edit-modal-container');
    const closeButton = editModalContainer.querySelector('.close-button');
    const prevButton = editModalContainer.querySelector('.prev-button');
    const nextButton = editModalContainer.querySelector('.next-button');
    const submitButton = editModalContainer.querySelector('.submit-button');
    const modalPages = editModalContainer.querySelectorAll('.modal-page');
    const paginationDots = editModalContainer.querySelectorAll('.dot');

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
            const response = await fetch('/vendor/{vendorID}/get-weddings');

            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`);
            }

            const textData = await response.text();
            const data = textData ? JSON.parse(textData) : [];

            return data;
        } catch (error) {
            console.error('Error fetching cards:', error);
            showNotification("Could not fetch weddings", "red");
            return [];
        }
    }


    // initialize cards
    async function initializeCards() {
        const cardsData = await fetchCards();

        if (Array.isArray(cardsData) && cardsData.length > 0) {
            loadCards(cardsData);
        } else {
            showNotification("No wedding data available", "red");
        }
    }

    function createCard(cardData) {
        return `
            <div class="card">
                <div class="image-content">
                    <span class="overlay"></span>
                    <div class="card-image">
                        <img src="${cardData.imgSrc}" alt="" class="card-img">
                    </div>
                </div>
                <div class="card-content">
                    <h2 class="name">${cardData.bride} & ${cardData.groom}'s Wedding</h2>
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
        for (let i = 0; i < cards.length; i += 3) {
            const cardsInGroup = cards
                .slice(i, i + 3)
                .map((card) => createCard(card))
                .join("");
            cardWrappersHTML += `<div class="card-wrapper">${cardsInGroup}</div>`;
        }

        // inserting into slide-content
        scrollContainer.innerHTML = cardWrappersHTML;
    }

    // loadCards(cardsData);

    initializeCards();

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
                    'Content-Type': 'application/json'
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
            headers: {
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




document.addEventListener('DOMContentLoaded', render);
