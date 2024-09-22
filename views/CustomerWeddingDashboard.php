<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrideName's and GroomName's Wedding</title>
    <link rel="stylesheet" href="./assets/css/CustomerWeddingDashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <header>
        <div class="nav-bar-logo-container">
            <img src="./Assests/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title"></h1>
        </div>
        <button class="pay-now">Pay Now</button>
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
    <script src="./assets/js/CustomerWeddingDashboard.js"></script>
</body>

</html>