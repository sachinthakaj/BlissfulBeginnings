<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/public/assets/css/WeddingDetails.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="nav-bar-logo-container">
            <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title">Create an account</h1>
        </div>
    </header>
    <div class="box">
        <form id="multiStepForm">
            <div class="form-progress-bar">
                <div id="step1-progress" class="active"></div>
                <div id="step2-progress"></div>
                <div id="step3-progress"></div>
            </div>
            <section class="wedding-details step active">
                <h2>Wedding Details</h2>
                <div class="box-container">
                    <div class="left">
                        <div class="input-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div class="input-group">
                            <label for="daynight">Day/Night</label>
                            <select id="daynight" name="daynight" required>
                                <option value="Day">Day</option>
                                <option value="Night">Night</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" required>
                        </div>
                    </div>
                    
                    <div class="right">
                        <div class="input-group">
                            <label for="theme">Theme</label>
                            <input type="text" id="theme" name="theme" required>
                        </div>
                        <div class="input-group">
                            <label for="budget">Expected Budget</label>
                            <input type="number" id="budget" name="budget" required>
                        </div>
                    </div>
                </div>
                
                <div class="checkbox-group">
                    <label><input type="checkbox" name="salon" id="sepSalons">Get the service of separate Salons for bride and groom</label>
                    <label><input type="checkbox" name="dressDesigners" id="sepDressDesigners">Get the service of separate Dress Makers for bride and groom</label>
                </div>
                <button type="button" id="nextBtn">Next</button>
            </section>

            <div class="bride-details step">
                <h2>Bride Details</h2>
                <div class="box-container">
                    <div class="left">
                        <div class="input-group">
                            <label for="bride_name">Name</label>
                            <input type="text" id="bride_name" name="bride_name" required>
                        </div>
                        <div class="input-group">
                            <label for="bride_email">Email</label>
                            <input type="email" id="bride_email" name="bride_email" required>
                        </div>
                        <div class="input-group">
                            <label for="bride_contact">Contact</label>
                            <input type="tel" id="bride_contact" name="bride_contact" required>
                        </div>
                    </div>
                    
                    <div class="right">
                        <div class="input-group">
                            <label for="bride_address">Address</label>
                            <input type="text" id="bride_address" name="bride_address" required>
                        </div>
                        <div class="input-group">
                            <label for="bride_age">Age</label>
                            <input type="number" id="bride_age" name="bride_age" required>
                        </div>
                    </div>
                </div>
                <button type="button" id="prevBtn">Previous</button>
                <button type="button" id="nextBtn">Next</button>
            </div>

            <div class="groom-details step">
                <h2>Groom Details</h2>
                <div class="box-container">
                    <div class="left">
                        <div class="input-group">
                            <label for="groom_name">Name</label>
                            <input type="text" id="groom_name" name="groom_name" required>
                        </div>
                        <div class="input-group">
                            <label for="groom_email">Email</label>
                            <input type="email" id="groom_email" name="groom_email" required>
                        </div>
                        <div class="input-group">
                            <label for="groom_contact">Contact</label>
                            <input type="tel" id="groom_contact" name="groom_contact" required>
                        </div>
                    </div>

                    <div class="right">
                        <div class="input-group">
                            <label for="groom_address">Address</label>
                            <input type="text" id="groom_address" name="groom_address" required>
                        </div>
                        <div class="input-group">
                            <label for="groom_age">Age</label>
                            <input type="number" id="groom_age" name="groom_age" required>
                        </div>
                    </div>
                </div>
                
                <div class="submit-button">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
        <script src="/public/assets/js/WeddingDetails.js"></script>
    </div>
</body>

</html>
