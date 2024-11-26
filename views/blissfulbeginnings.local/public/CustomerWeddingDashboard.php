<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrideName's and GroomName's Wedding</title>
    <link rel="stylesheet" href="/public/assets/css/CustomerWeddingDashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
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
                        <a href="#">Profile ▼</a>
                        <ul class="dropdown">
                            <li><a href="#" class="edit-profile" id="edit-profile">Edit Profile</a></li>
                            <li><a href="#" class="delete-profile" id="delete-profile">Delete Profile</a></li>
                            <li><a class="logout-button top-right-item" onclick="window.location.href='/signin'">Log Out</a></li>
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
                <div class="time-remaining-container">
                    <h2 id="days-left"></h2>
                </div>

                <div class="progress-bars">
                    <div class="progress-bar-container">
                        <label>Wedding Progress</label>
                        <div class="bar"></div>
                        <div class="bar wedding-progress-bar" id="wedding-progress-bar"></div>
                    </div>
                    <div class="progress-bar-container">
                        <label>Budget Progress</label>
                        <div class="bar"></div>
                        <div class="bar budget-progress-bar" id="budget-progress-bar"></div>
                    </div>
                </div>

                <div class="vendor-grid">

                </div>
            </main>

            <aside style="flex: 1;">
                <div class="chat-container"></div>
                <div class="text-field">
                    <input class="chat-type-field">
                    <button class="chat-send-button">Send</button>
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
                    <h3>Basic Information</h3>
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                </div>
            </div>
    
            <!-- Page 2 -->
            <div class="modal-page" data-page="2">
                <div class="modal-body">
                    <h3>Business Information</h3>
                    <div class="form-group">
                        <label for="businessName">Business Name:</label>
                        <input type="text" id="businessName" name="businessName">
                    </div>
                    <div class="form-group">
                        <label for="businessType">Business Type:</label>
                        <select id="businessType" name="businessType">
                            <option value="">Select type</option>
                            <option value="photography">Photography</option>
                            <option value="catering">Catering</option>
                            <option value="decoration">Decoration</option>
                            <option value="venue">Venue</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="location">
                    </div>
                </div>
            </div>
    
            <!-- Page 3 -->
            <div class="modal-page" data-page="3">
                <div class="modal-body">
                    <h3>Additional Information</h3>
                    <div class="form-group">
                        <label for="description">Business Description:</label>
                        <textarea id="description" name="description" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="experience">Years of Experience:</label>
                        <input type="number" id="experience" name="experience">
                    </div>
                    <div class="form-group">
                        <label for="website">Website:</label>
                        <input type="url" id="website" name="website">
                    </div>
                </div>
            </div>
    
            <div class="edit-modal-footer">
                <div class="pagination-dots">
                    <span class="dot active" data-page="1"></span>
                    <span class="dot" data-page="2"></span>
                    <span class="dot" data-page="3"></span>
                </div>
                <div class="button-group">
                    <button class="prev-button" disabled>Previous</button>
                    <button class="next-button">Next</button>
                    <button class="submit-button" style="display: none;">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/assets/js/CustomerWeddingDashboard.js"></script>
</body>

</html>