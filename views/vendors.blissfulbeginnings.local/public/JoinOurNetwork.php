<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Gwendolyn&display=swap" rel="stylesheet">
    <link href="/public/assets/css/JoinOurNetwork.css" rel="stylesheet">
    <script src="/public/assets//js/JoinOurNetwork.js" defer></script>
</head>
<body>
    <header>
        <div class="nav-bar-logo-container">
            <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title">Join Our Network</h1>
        </div>
    </header>

    <!-- <main class="main-content">
        <form id="signup-form">
            <div class="vendor-left">
            <div class="vendor-middle">
                    <h2>Account Details</h2>
                    <div class="form-group">
                        <label for="email">Email<span class="required">*</span></label>
                        <input type="text" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmEmail">Confirm Email<span class="required">*</span></label>
                        <input type="text" id="conf-email" name="confirmEmail" placeholder="confirm Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password<span class="required">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password<span class="required">*</span></label>
                        <input type="password" id="conf-password" name="confirmPassword" placeholder="Confirm Password" required>
                    </div>
                </div>
            </div>
            <div class="vendor-middle">
                <h2>Vendor Sign Up</h2>
                <div class="form-group">
                    <label for="business-name">Business Name<span class="required">*</span></label>
                    <input type="text" id="business-name" name="name" placeholder="Enter business name" required>
                </div>
                <div class="form-group">
                    <label for="businessType">Type<span class="required">*</span></label>
                    <select id="businessType" name="businessType" required>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description<span class="required">*</span></label>
                    <textarea id="description" name="description" placeholder="Enter business description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="contact">Contact Number<span class="required">*</span></label>
                    <input type="tel" id="contact" name="contact" placeholder="Enter contact number" pattern="[0-9]{10}" required>
                </div>
                <div class="form-group">
                    <label for="websiteLink">Web Site Link<span class="required">*</span></label>
                    <textarea id="websiteLink" name="websiteLink" placeholder="Enter social media links" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="address">Address<span class="required">*</span></label>
                    <textarea id="address" name="address" placeholder="Enter Address" rows="3" required></textarea>
                </div>


            </div>
            <div class="vendor-right">
            <h2>Vendor Sign Up</h2>
                <div class="form-group">
                    <label for="photo">Upload Profile Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>

                <button type="submit" class="submit-button">Sign Up</button>
            </div>
        </form>            
    </main> -->

    <main class="main-content">
        <!-- Step indicator -->
        <div class="step-indicator">
            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>
        </div>
            
        <form id="signup-form">
            <!-- Modal 1: Account Details -->
            <div class="modal-section active">
                <div class="vendor-left">
                    <div class="vendor-middle">
                        <h2>Account Details</h2>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email<span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="Email" required>
                        </div>
                        <!-- Confirm Email -->
                        <div class="form-group">
                            <label for="conf-email">Confirm Email<span class="required">*</span></label>
                            <input type="email" id="conf-email" name="confirmEmail" placeholder="Confirm Email" required>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password<span class="required">*</span></label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </div>
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="conf-password">Confirm Password<span class="required">*</span></label>
                            <input type="password" id="conf-password" name="confirmPassword" placeholder="Confirm Password" required>
                        </div>
                        
                        <div class="navigation-buttons">
                            <button type="button" id="prev-button" class="nav-button" disabled>Previous</button>
                            <button type="button" id="next-button" class="nav-button">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal 2: Business Information -->
            <div class="modal-section">
                <div class="vendor-middle">
                    <h2>Vendor Information</h2>
                    <!-- Business Name -->
                    <div class="form-group">
                        <label for="business-name">Business Name<span class="required">*</span></label>
                        <input type="text" id="business-name" name="name" placeholder="Enter business name" required>
                    </div>
                    <!-- Business Type -->
                    <div class="form-group">
                        <label for="businessType">Type<span class="required">*</span></label>
                        <select id="businessType" name="businessType" required>
                            <!-- options -->
                        </select>
                    </div>
                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description<span class="required">*</span></label>
                        <textarea id="description" name="description" placeholder="Enter business description" rows="4" required></textarea>
                    </div>
                    <!-- Contact Number -->
                    <div class="form-group">
                        <label for="contact">Contact Number<span class="required">*</span></label>
                        <input type="tel" id="contact" name="contact" placeholder="Enter contact number" pattern="[0-9]{10}" required>
                    </div>
                    <!-- Website Link -->
                    <div class="form-group">
                        <label for="websiteLink">Web Site Link<span class="required">*</span></label>
                        <textarea id="websiteLink" name="websiteLink" placeholder="Enter website link" rows="1" required></textarea>
                    </div>
                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Address<span class="required">*</span></label>
                        <textarea id="address" name="address" placeholder="Enter Address" rows="3" required></textarea>
                    </div>
                    
                    <div class="navigation-buttons">
                        <button type="button" id="prev-button" class="nav-button">Previous</button>
                        <button type="submit" id="submit-button" class="submit-button">Sign Up</button>
                    </div>
                </div>
            </div>
        </form>            
            
        <form>
            <!-- Modal 3: Contact and Upload Section -->
            <div class="modal-section">
                <div class="vendor-right">
                    <h2>Profile Photo</h2>
                    <!-- Profile Photo Upload -->
                    <div class="form-group">
                        <label for="photo">Upload Profile Photo</label>
                        <input type="file" id="photo" name="photo" accept="image/*">
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" id="prev-button" class="nav-button" disabled>Previous</button>
                        <button id="save-button" class="save-button">Save</button>
                        <!-- <button type="submit" id="submit-button" class="submit-button">Sign Up</button> -->
                    </div>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
