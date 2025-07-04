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
      <div class="left">
        <div class="miscellanous">
          <div class="back-button">
            <a href="/plannerDashboard" class="go-back"><img src="/public/assets/images/right-arrow-svgrepo-com.svg" alt="Go back arrow" class="go-back-arrow" /><span>Back to Dashboard</span></a>
          </div>
        </div>
        <!-- <div class="more-about-salons">
            </div> -->

        <main>
          <div class="progress-bar-vendor-search-and-cards">
            <div class="progress-area">
              <div class="wedding-progress-area">

                <div class="Text">Wedding Progress</div>
                <div class="Precentage" id="weddingProgressPrecentage"></div>
                <div class="progress-container">
                  <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                </div>
              </div>

              <div class="budget-progress-area">
                <div class="Text">Budget Progress</div>
                <div class="Precentage" id="budgetProgressPrecentage"></div>
                <div class="progress-container">
                  <div class="progress-bar" id="budgetBar" style="width: 0%"></div>
                </div>
              </div>

              <div class="vendor-search-and-cards">


                <div class="vendor-cards"></div>
                <div id="taskFormModal" class="modal">
                  <div class="modal-content">
                    <span id="closeModal" class="close">&times;</span>
                    <h2>Add Task</h2>
                    <form id="taskForm">

                      <input id="assignmentID" type="hidden" name="assignmentID" value="">
                      <div class="form-group">
                        <lable for="taskDescription" class="taskDescription">Description:</lable>
                        <textarea id="taskDescription" name="taskDescription" required></textarea>
                      </div>
                      <div class="form-group">
                        <label for="dateToFinish" class="dateToFinish">Finish Before:</label>
                        <input id="dateToFinish" name="dateToFinish" type="date" required>
                      </div>
                      <button type="submit" class="submitButton">Submit</button>

                    </form>
                  </div>

                </div>
              </div>
            </div>
        </main>
      </div>

      <aside class="chat-container">
        <div class="chat-all-area">
          <div class="chat-show-area">


          </div>

          <div class="chat-action-area">
            <div class="image-upload-container">
              <label for="imageUpload" class="upload-icon">
                <img src="http://cdn.blissfulbeginnings.com/common-icons/chat-attachment.png" alt="Upload Image" title="Upload an image" class='upload-image-icon'>
                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
              </label>
            </div>
            <div class="chat-type-area">
              <input type="text" id="chat-type-field" placeholder="Type your message here..." class="chat-type-field">
            </div>
            <div class="send-button-area" id="send-button"><img src='http://cdn.blissfulbeginnings.com/common-icons/chat-send.png' alt="Send" class="send-button-icon"></div>



          </div>

        </div>
      </aside>
    </div>
  </div>
  <script src="/public/assets/js/weddingPage.js"></script>
</body>

</html>