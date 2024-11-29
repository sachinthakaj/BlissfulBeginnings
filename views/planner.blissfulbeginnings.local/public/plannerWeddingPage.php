<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wedding Page</title>
  <link rel="stylesheet" href="/public/assets/css/weddingPage.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
</head>

<body>
  <div class="dashboard">
    <header>
      <div class="nav-bar-logo-container">
        <img
          src="/public/assets/images/Logo.png"
          alt="Blissful Beginnings Logo"
          class="nav-bar-logo" />
      </div>
      <h1 class="wedding-dashboard-title"></h1>


    </header>
    <div class="content-wrapper">
      <main>
        <div class="progress-bar-vendor-search-and-cards">
          <div class="weddingProgressText">Wedding Progress</div>

          <div class="progress-container">
            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
          </div>
          <div class="weddingProgressText">Budget Progress</div>
          <div class="progress-container">
            <div class="progress-bar" id="budgetBar" style="width: 0%"></div>
          </div>

          <div class="vendor-search-and-cards">


            <div class="vendor-cards"></div>
            <div id="taskFormModal" class="modal">
              <div class="modal-content">
                <span id="closeModal" class="close">&times;</span>
                <h2>Add Task</h2>
                <form id="taskForm">
                  <input id="assignmentID" type="hidden" name="assignmentID" value="">
                  <lable for="taskDescription" class="taskDescription">Description:</lable>
                  <textarea id="taskDescription" name="taskDescription" required></textarea>
                  <label for="dateToFinish" class="dateToFinish">Finish Before:</label>
                  <input id="dateToFinish" name="dateToFinish" type="date" required>
                  <button type="submit" class="submitButton">Submit</button>

                </form>
              </div>

            </div>
          </div>
        </div>
      </main>
      <aside>
      <div class="chat-container"></div>
                <div class="text-field">
                    <input class="chat-type-field">
                    <button class="chat-send-button">Send</button>
                </div>  
      </aside>
    </div>
  </div>
  <script src="/public/assets/js/weddingPage.js"></script>
</body>

</html>