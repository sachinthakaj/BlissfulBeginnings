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
        </div>
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
        <div class="content-wrapper" id="content-wrapper">
            <main>
                <div class="info">

                    <div class="wedding-group-info">
                        <table class="wedding-group-info-table">
                            <tr>
                                <td class="first_col info-point"><label for="wedding-group-male">Number of Male people in the wedding party:</label></td>
                                <td class="first_col"><input type="number" id="wedding-group-male" name="wedding-group-male" required></td>
                                <td class="second_col info-point" ><label for="wedding-group-female">Number of Female people in the wedding party:</label></td>
                                <td class="second_col"><input type="number" id="wedding-group-female" name="wedding-group-female" required></td>
                            </tr>
                            <tr>
                                <td class="first_col info-point"><label for="min-budget">Budget lower level:</label></td>
                                <td class="first_col"><span id="min-budget">0</span></td>
                                <td class="second_col info-point"><label for="max-budget">Budget upper level:</label></td>
                                <td class="second_col"><span id="max-budget">0</span></td>
                            </tr>
                            <tr>
                                <td class="first_col info-point"><label for="total-budget">Total allocated budget:</label></td>
                                <td class="first_col"><span id="total-budget">0</span></td>
                                <td class="second_col info-point"><label for="remaining-budget">Remaining budget:</label></td>
                                <td class="second_col"><span id="remaining-budget">0</span></td>
                            </tr>
                            <tr>
                                <td class="first_col info-point"><label for="wedding-date">Wedding Date:</label></td>
                                <td class="first_col"><span id="wedding-date"></span></td>
                                <td class="second_col info-point"><label for="ceremony-time">Ceremony Time:</label></td>
                                <td class="second_col"><span id="ceremony-time"></span></td>
                            </tr>
                        </table>
                    </div>
                    <button id="proceed-button">Proceed</button></p>


                </div>
                <div class="above-main">
                    <div class="main-body">
                        <div id="card-container">
                        </div>
                    </div>
                </div>

            </main>
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



        <script src=" /public/assets/js/selectPackages.js"></script>

    </body>

    </html>