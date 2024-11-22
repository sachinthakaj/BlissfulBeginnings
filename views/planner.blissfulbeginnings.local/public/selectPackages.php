<php?>
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
        <div>
            <div id="loading-screen">
                <div class="spinner"></div>
                <p>Loading...</p>
            </div>
            <header>
                <div class="nav-bar-logo-container">
                    <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
                </div>
                <div class="wedding-title-container">
                    <h1 class="wedding-title"></h1>
                </div>
            </header>
            <div class="above-main">
                <div class="main-body">
                    <div class="card-container">

                        <button class="card-button" onclick="window.location.href='/selectPackages-saloon'">
                            <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                            <h1>Salon</h1>
                        </button>
                        <button class="card-button" onclick="window.location.href='/selectPackages-dress-designer'">
                            <img src="/public/assets/images/dress_14383759 1.png" alt="Dress Maker" />
                            <h1>Dress Maker</h1>
                        </button>
                        <button class="card-button" onclick="window.location.href='/selectPackages-photographer'">
                            <img src="/public/assets/images/camera_1361782 1.png" alt="Photographer" />
                            <h1>Photographer</h1>
                        </button>
                        <button class="card-button" onclick="window.location.href='/selectPackages-decorator'">
                            <img src="/public/assets/images/nature_10601927 1.png" alt="Florist" />
                            <h1>Florist</h1>
                        </button>

                    </div>
                </div>
            </div>
        </div>



        <script src=" /public/assets/js/selectPackages.js"></script>

    </body>

    </html>