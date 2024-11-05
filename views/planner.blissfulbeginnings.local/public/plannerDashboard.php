<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wedding Planners - Dashboard</title>
    <link rel="stylesheet" href="./public/assets/css/dashboardStyles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
    <div class="dashboard">
      <header>
        <div class="nav-bar-logo-container">
          <img
            src="./public/assets/images/Logo.png"
            alt="Blissful Beginnings Logo"
            class="nav-bar-logo"
          />
        </div>
        <h1 class="wedding-dashboard-title">Wedding Planners - Dashboard</h1>
        <button class="LogOut" onclick="window.location.href='/SignIn'">Log Out</button>
      </header>
      <div class="content-wrapper">
        <main>
          
          <div class="wedding-search-and-cards">
           
            <div class="search-bar-container">
              <input
                type="text"
                id="search"
                placeholder="Search Weddings"
                class="search-bar"
              />
              <button type="button" class="search-button">Search</button>
            </div>
            
            <div class="wedding-cards"></div>
          </div>
        </main>
        <aside class="calendar-container"></aside>
      </div>
    </div>
    <script src="./public/assets/js/script.js"></script>
  </body>
</html>
