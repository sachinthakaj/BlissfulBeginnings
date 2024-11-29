<?php
session_start();

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

?>

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
    rel="stylesheet" />
</head>

<body>
<div id="loading-screen">
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>
  <div class="dashboard">
    <header>
      <div class="nav-bar-logo-container">
        <img
          src="./public/assets/images/Logo.png"
          alt="Blissful Beginnings Logo"
          class="nav-bar-logo" />
      </div>
      <h1 class="wedding-dashboard-title">Wedding Planners - Dashboard</h1>

    </header>
    <div class="content-wrapper">
      <main>
        <div class="image-links-container">
          <a href="/salons">
            <img
              src="/public/assets/images/desk-chair_341178 1 copy.png"
              alt="Wedding Planner Background"
              class="image-link" />
          </a>
          <a href="/photographers">
            <img
              src="/public/assets/images/camera_1361782 1 copy.png"
              alt="Photographer Background"
              class="image-link" />
          </a>
          <a href="/dress-designers">
            <img
              src="/public/assets/images/dress_14383759 1 copy.png"
              alt="Dress Designer Background"
              class="image-link" />
          </a>
          <a href="/florists">
            <img
              src="/public/assets/images/nature_10601927 1 copy.png"
              alt="Vendor Background"
              class="image-link" />
          </a>
        </div>
        <div class="wedding-search-and-cards">

          <div class="search-bar-container">
            <input
              type="text"
              id="search"
              placeholder="Search Weddings"
              class="search-bar" />
            <button type="button" class="search-button">Search</button>
          </div>

          <div class="wedding-cards"></div>
        </div>
      </main>
      <aside class="calendar-container">
        <div id="right">
          <h3 id="monthAndYear"></h3>
          <div class="button-container-calendar">
            <button id="previous"
              onclick="previous()">
              ‹
            </button>
            <button id="next"
              onclick="next()">
              ›
            </button>
          </div>
          <table class="table-calendar"
            id="calendar"
            data-lang="en">
            <thead id="thead-month"></thead>
            <!-- Table body for displaying the calendar -->
            <tbody id="calendar-body"></tbody>
          </table>
          <div class="footer-container-calendar">
            <label for="month">Jump To: </label>
            <!-- Dropdowns to select a specific month and year -->
            <select id="month" onchange="jump()">
              <option value=0>Jan</option>
              <option value=1>Feb</option>
              <option value=2>Mar</option>
              <option value=3>Apr</option>
              <option value=4>May</option>
              <option value=5>Jun</option>
              <option value=6>Jul</option>
              <option value=7>Aug</option>
              <option value=8>Sep</option>
              <option value=9>Oct</option>
              <option value=10>Nov</option>
              <option value=11>Dec</option>
            </select>
            <!-- Dropdown to select a specific year -->
            <select id="year" onchange="jump()"></select>
          </div>
        </div>
        <div class="notification-container">
          <!-- notifications will be dynamically generated here -->
        </div>
      </aside>
    </div>
  </div>
  <script src="./public/assets/js/script.js"></script>
</body>

</html>