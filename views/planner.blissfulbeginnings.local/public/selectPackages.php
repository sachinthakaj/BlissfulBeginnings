    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Select Packeges</title>
        <link rel="stylesheet" href="/public/assets/css/selectPackages.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet" />
    </head>

    <body>

        <div id="loading-screen">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div class=main-content>


        <div id="main-content">
            <header>
                <div class="nav-bar-logo-container">
                    <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
                </div>
                <div class="wedding-title-container">
                    <h1 class="wedding-title"></h1>
                </div>
            </header>
            <div id="modal">
                <div id="modal-content">
                </div>
            </div>
            <div class="budget-container">
                <div class="budget-info">
                    <p>Total allocated budget: <span id="total-budget">0</span> 
                </div>
                <button id="proceed-button">Proceed</button></p>
            </div>
            <div class="above-main">
                <div class="main-body">
                    <div id="card-container">



                    </div>
                </div>
            </div>
        </div>



        <script src=" /public/assets/js/selectPackages.js"></script>

    </body>

    </html>