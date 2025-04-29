<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrideName's and GroomName's Wedding</title>
    <link rel="stylesheet" href="/public/assets/css/CustomerWeddingDashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>

    <div id="loading-screen">
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>
    <div id="main-content" style="display: none;">
        <header>
            <div class="nav-bar-logo-container">
                <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
            </div>
            <div class="wedding-title-container">
                <h1 class="wedding-title"></h1>
            </div>
            <div class="top-right">

                <ul>
                    <li>
                        <button class="eventButton" id="scheduleButtonId">Events</button>
                    </li>
                    <li>
                        <a href="#">Profile ▼</a>
                        <ul class="dropdown">
                            <li><a href="#" class="edit-profile" id="edit-profile">Edit Profile</a></li>
                            <li><a href="#" class="delete-profile" id="delete-profile">Delete Profile</a></li>
                            <li><a class="logout-button top-right-item" id="log-out">Log Out</a></li>
                        </ul>
                    </li>
                    <li>
                        <button class="pay-now">Pay Now</button>
                    </li>
                </ul>
            </div>
        </header>

        <div class="main-container">


            <main>

                <div class="schedule-list-container" id="scheduleListContainer">
                    <div class="schedule-header">
                        <h3>Scheduled Events</h3>
                        

                    </div>
                    <div class="schedule-list" id="scheduleList">
                        <!-- Dynamic schedule items will be inserted here -->


                    </div>
                </div>
                <div class="time-remaining-container">
                    <h2 id="days-left"></h2>
                </div>

                <div class="progress-area">
                    <div class="wedding-progress-area">

                        <div class="Text">Wedding Progress</div>
                        <div class="Precentage" id="weddingProgressPrecentage"></div>
                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="budget-progress-area">
                        <div class="Text">Budget Progress</div>
                        <div class="Precentage" id="budgetProgressPrecentage"></div>
                        <div class="progress-container">
                            <div class="progress-bar" id="budgetBar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="vendor-grid">

                </div>
            </main>

            <aside class="chat-container">
                <div class='chat-all-area'>
                    <div id="chat-show-area" class='chat-show-area'>

                    </div>
                    <div class="chat-action-area">
                        <div class="image-upload-container">
                            <label>
                                <img src="http://cdn.blissfulbeginnings.com/common-icons/chat-attachment.png" alt="Upload Image" title="Upload an image" class='upload-image-icon'>
                                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                            </label>
                        </div>
                        <div class="chat-type-area">
                            <input type='text' id="chat-type-field" class="chat-type-field" placeholder="Type your message here...">
                        </div>
                        <div id="chat-send-button" class="send-button-area"><img src='http://cdn.blissfulbeginnings.com/common-icons/chat-send.png' alt="Send" class="send-button-icon"></div>
                    </div>
                </div>

            </aside>
        </div>
    </div>

    <!-- modal for delete profile -->
    <div class="modal-container" id="modal-container">
        <div class="modal-delete">
            <div class="modal-header">
                <h2>Delete Profile</h2>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your profile? </p>
            </div>
            <div class="modal-footer">
                <button class="cancel-button">Cancel</button>
                <button class="delete-button">Delete</button>
            </div>
        </div>
    </div>

    <!-- modal for edit profile -->
    <div id="edit-modal-container" class="edit-modal-container">
        <div class="edit-modal">
            <div class="modal-header">
                <h2>Edit Profile</h2>
                <span class="close-button">&times;</span>
            </div>

            <!-- Page 1 -->
            <div class="modal-page" data-page="1">
                <div class="modal-body">
                    <h3>Login Information</h3>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" disabled>
                    </div>
                    <div class="form-group">
                        <a href="">Forgot Password</a>
                    </div>
                </div>
            </div>

            <!-- Page 2 -->
            <div class="modal-page" data-page="2">
                <div class="modal-body">
                    <h3>Wedding Details</h3>
                    <div class="box-container">
                        <div class="left">
                            <div class="form-group">
                                <label for="wedding-date">Date:</label>
                                <input type="date" id="wedding-date" name="wedding-date" disabled>
                            </div>
                            <div class="form-group">
                                <label for="day-night">Day/Night:</label>
                                <select id="day-night" name="day-night">
                                    <option value="Day">Day</option>
                                    <option value="Night">Night</option>
                                </select>
                            </div>
                        </div>
                        <div class="right">
                            <div class="form-group">
                                <label for="wedding-location">Location:</label>
                                <input type="text" id="wedding-location" name="wedding-location">
                            </div>
                            <div class="form-group">
                                <label for="wedding-theme">Theme:</label>
                                <input type="text" id="wedding-theme" name="wedding-theme">
                            </div>
                            <div class="form-group">
                                <label for="wedding-budget">Expected Budget:</label>
                                <input type="number" id="wedding-budget" name="wedding-budget" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page 3 -->
            <div class="modal-page" data-page="3">
                <div class="modal-body">
                    <h3>Bride Details</h3>
                    <div class="box-container">
                        <div class="left">
                            <div class="form-group">
                                <label for="bride-name">Bride Name:</label>
                                <input type="text" id="bride-name" name="bride-name" disabled>
                            </div>
                            <div class="form-group">
                                <label for="bride-email">Email:</label>
                                <input type="email" id="bride-email" name="bride-email" disabled>
                            </div>
                            <div class="form-group">
                                <label for="bride-contact">Contact:</label>
                                <input type="text" id="bride-contact" name="bride-contact">
                            </div>
                        </div>
                        <div class="right">
                            <div class="form-group">
                                <label for="bride-address">Address:</label>
                                <input type="text" id="bride-address" name="bride-address">
                            </div>
                            <div class="form-group">
                                <label for="bride-age">Age:</label>
                                <input type="number" id="bride-age" name="bride-age" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page 4 -->
            <div class="modal-page" data-page="4">
                <div class="modal-body">
                    <h3>Groom Details</h3>
                    <div class="box-container">
                        <div class="left">
                            <div class="form-group">
                                <label for="groom-name">Groom Name:</label>
                                <input type="text" id="groom-name" name="groom-name" disabled>
                            </div>
                            <div class="form-group">
                                <label for="groom-email">Email:</label>
                                <input type="email" id="groom-email" name="groom-email" disabled>
                            </div>
                            <div class="form-group">
                                <label for="groom-contact">Contact:</label>
                                <input type="text" id="groom-contact" name="groom-contact">
                            </div>
                        </div>
                        <div class="right">
                            <div class="form-group">
                                <label for="groom-address">Address:</label>
                                <input type="text" id="groom-address" name="groom-address">
                            </div>
                            <div class="form-group">
                                <label for="groom-age">Age:</label>
                                <input type="number" id="groom-age" name="groom-age" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="edit-modal-footer">
                <div class="pagination-dots">
                    <span class="dot active" data-page="1"></span>
                    <span class="dot" data-page="2"></span>
                    <span class="dot" data-page="3"></span>
                    <span class="dot" data-page="4"></span>
                </div>
                <div class="button-group">
                    <button class="prev-button" disabled>Previous</button>
                    <button class="next-button">Next</button>
                    <button class="submit-button">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/assets/js/CustomerWeddingDashboard.js"></script>
</body>

</html>