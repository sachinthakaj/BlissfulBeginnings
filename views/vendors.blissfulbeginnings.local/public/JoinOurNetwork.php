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
    <!-- Header Section -->
    <header>
        <div class="nav-bar-logo-container">
            <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title">Join Our Network</h1>
        </div>
    </header>

    <!-- Sign Up Form Section -->
    <main class="main-content">
            
        <form id="signup-form">
            <div class="vendor-left">
                <h2>Vendor Sign Up</h2>
                <!-- Profile Photo Upload -->
                <div class="form-group">
                    <label for="photo">Upload Profile Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <!-- <div class="drop-zone" id="drop-zone">
                        <img src="/public/assets/images/upload.png" alt="Upload Icon">
                        <h3>Upload File</h3>
                        <p>Drag & Drop your file here or click to select</p>
                        <input type="file" id="photo" name="photo" accept="image/*">
                    </div> -->
                </div>
                <!-- Business Name -->
                <div class="form-group">
                    <label for="business-name">Business Name<span class="required">*</span></label>
                    <input type="text" id="business-name" name="name" placeholder="Enter business name" required>
                </div>
                <!-- Business Type -->
                <div class="form-group">
                    <label for="businessType">Type<span class="required">*</span></label>
                    <select id="businessType" name="businessType" required>
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
                <!-- Social Media Links -->
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
                <div class="vendor-middle">
                    <h2>Account Details</h2>
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email<span class="required">*</span></label>
                        <input type="text" id="email" name="email" placeholder="Email" required>
                    </div>
                    <!-- Confirm Email -->
                    <div class="form-group">
                        <label for="confirmEmail">Confirm Email<span class="required">*</span></label>
                        <input type="text" id="conf-email" name="confirmEmail" placeholder="confirm Email" required>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password<span class="required">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password<span class="required">*</span></label>
                        <input type="password" id="conf-password" name="confirmPassword" placeholder="Confirm Password" required>
                    </div>
                </div>

                <button type="submit" class="submit-button">Sign Up</button>

            </div>
        </form>            
    </main>
</body>
</html>
