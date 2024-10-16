<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - New Wedding Dashboard</title>
    <link rel="stylesheet" href="/public/assets/css//VendorNewWeddingDashboard.css">
    <link href="https://fonts.googleapis.com/css?family=Gwendolyn&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="nav-bar-logo-container">
            <img src="../assets//images//Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title"><span id="bride-name"></span> & <span id="groom-name">'s Wedding</span></h1>
        </div>
    </header>

    <main class="main-content">
        <div class="main-left">
            <a href="#" class="go-back"><img src="/public/assets/images/VendorNewWeddingDashboard/right-arrow-svgrepo-com.svg" alt="Go back arrow" class="go-back-arrow" /><span>Back to all weddings</span></a>

            <div class="bride-groom-details">
                <div class="bride-details">
                    <h2>Bride Details</h2>
                    <span class="bg-details">Name:</span><span id="bride-details-name"></span><br>
                    <span class="bg-details">Email:</span><span id="bride-email"></span><br>
                    <span class="bg-details">Contact:</span><span id="bride-contact"></span>
                </div>
                <div class="groom-details">
                    <h2>Groom Details</h2>
                    <span class="bg-details">Name:</span><span id="groom-details-name"></span><br>
                    <span class="bg-details">Email:</span><span id="groom-email"></span><br>
                    <span class="bg-details">Contact:</span><span id="groom-contact"></span>
                </div>
            </div>
            
            <div class="bottom-section">
                <div class="wedding-details">
                    <h2>Wedding Details</h2>
                    <span class="bg-details">Date:</span><span id="wedding-date"></span><br>
                    <span class="bg-details">Location:</span><span id="wedding-location"></span><br>
                    <span class="bg-details">Theme:</span><span id="wedding-theme"></span><br>
                </div>
                <div class="package-details">
                    <h2>Package Details</h2>
                    <span class="bg-details">Name:</span><span id="package-name"></span><br>
                    <span class="bg-details">Level:</span><span id="package-level"></span><br>
                    <span class="bg-details">Price:</span>LKR <span id="package-price"></span><br>
                </div>
            </div>

            <div class="bottom-buttons">
                <button class="reject-button">Reject</button>
                <button class="accept-button">Accept</button>
            </div>
        </div>

        <div class="main-right">
            <img src="/public/assets/images/VendorNewWeddingDashboard/Champagne Tulle Gold Appliques Off The Shoulder Wedding Dress.jpg Tulle Gold Appliques Off The Shoulder Wedding Dress.jpg" alt="Bride and Groom" class="bride-groom-image" />
        </div>
    </main>

    <script src="/public/assets/images/VendorNewWeddingDashboard.js"></script> 
</body>
</html>
