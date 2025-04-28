<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Wedding Dashboard 1</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="/public/assets/js/VendorWeddingDashboard.js"></script>
    <link rel="stylesheet" href="/public/assets/css/VendorWeddingDashboard.css">
    </script>
</head>

<body>
    <div class="page-wrapper">
        <header>
            <div class="nav-bar-logo-container">
                <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />

            </div>
            <button class="scheduleButton" id="scheduleButtonId">
                <img src="https://static.vecteezy.com/system/resources/previews/005/261/230/original/event-schedule-icon-free-vector.jpg" alt="Schedule Icon" title="Schedule" class="scheduleIcon" />
            </button>


        </header>

        <div class="main-container">
            <main>
                <a href="#" class="go-back"><img src="/public/assets/images/right-arrow-svgrepo-com.svg" alt="Go back arrow" class="go-back-arrow" /><span>Back to all weddings</span></a>
                <div class="time-remaining-container">
                    <h2 id="days-left"></h2>
                </div>

                <div class="progress-bars">

                    <div class="wedding-progress-area">

                        <div class="Text">Progress</div>
                        <div class="Precentage" id="weddingProgressPrecentage"></div>
                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                        </div>
                    </div>


                </div>



                <div class="slide-container">
                    <button id="backBtn">
                        <img src="/public/assets/images/left-arrow-svgrepo-com.svg" alt="Left arrow" />
                    </button>

                    <div class="slide-content">
                        <!-- dynamic insertion of cards -->
                    </div>

                    <button id="nextBtn">
                        <img src="/public/assets/images/right-arrow-svgrepo-com.svg" alt="Right arrow" />
                    </button>
                </div>


                <div id="eventModal" class="modal">
                    <div class="modal-content">
                        <span class="close-button" id="closeModalButton">&times;</span>
                        <h2>Add Event</h2>
                        <form id="eventForm">
                            <label for="eventDescription">Event Description:</label>
                            <input type="text" id="eventDescription" name="eventDescription" placeholder="Enter event description" required>

                            <label for="eventDate">Event Date:</label>
                            <input type="date" id="eventDate" name="eventDate" required>

                            <label for="eventTime">Event Time:</label>
                            <input type="time" id="eventTime" name="eventTime" required>

                            <button type="submit" class="submitButton">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="schedule-list-container" id="scheduleListContainer">
                    <div class="schedule-header">
                        <h3>Scheduled Events</h3>
                        <button id="addEventButton" class="add-event-button">&#x2795;</button>
                        
                    </div>
                    <div class="schedule-list" id="scheduleList">
                        <!-- Dynamic schedule items will be inserted here -->
                       
                        
                    </div>
                </div>
            </main>

            <aside class="chat-container">
                <div class="chat-all-area">
                    <div class="chat-show-area">
                    </div>
                    <div class="chat-action-area">
                        <div class="image-upload-container">
                            <label>
                                <img src="http://cdn.blissfulbeginnings.com/common-icons/chat-attachment.png" alt="Upload Image" title="Upload an image" class='upload-image-icon'>
                                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                            </label>
                        </div>
                        <div class="chat-type-area">
                            <input type="text" id="chat-type-field" class="chat-type-field" placeholder="Type your message here...">
                        </div>
                        <div class="send-button-area" id="send-button"><img src='http://cdn.blissfulbeginnings.com/common-icons/chat-send.png' alt="Send" class="send-button-icon"></div>


                    </div>

                </div>
            </aside>
        </div>
    </div>
</body>

</html>