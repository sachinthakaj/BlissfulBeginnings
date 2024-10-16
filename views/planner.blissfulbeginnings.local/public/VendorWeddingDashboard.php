<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Wedding Dashboard 1</title>
    <link rel="stylesheet" href="Styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="../assets/js/VendorWeddingDashboard.js"></script>
</head>

<body>
    <header>
        <div class="nav-bar-logo-container">
            <img src="../assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title"></h1>
        </div>
    </header>

    <div class="main-container">
        <main>
            <a href="#" class="go-back"><img src="./images/right-arrow-svgrepo-com.svg" alt="Go back arrow" class="go-back-arrow" /><span>Back to all weddings</span></a>
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
    
            <div class="slide-container">
                <button id="backBtn">
                    <img src="./images/left-arrow-svgrepo-com.svg" alt="Left arrow" />
                </button>
                
                <div class="slide-content">
                    <!-- dynamic insertion of cards -->
                </div>
        
                <button id="nextBtn">
                    <img src="./images/right-arrow-svgrepo-com.svg" alt="Right arrow" />
                </button>
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
</body>
</html>
