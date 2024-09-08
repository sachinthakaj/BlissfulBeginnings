<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./assets/css/signup.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <!-- Space for Logo -->
                <img src="./assets/images/logo.png" alt="Blissful Beginnings Logo">
            </div>
            <h1>Sign Up</h1>
        </header>
        
        <form action="#" method="POST">
            <section class="wedding-details">
                <h2>Wedding Details</h2>
                <div class="input-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="input-group">
                    <label for="daynight">Day/Night</label>
                    <input type="text" id="daynight" name="daynight" required>
                </div>
                <div class="input-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="input-group">
                    <label for="theme">Theme</label>
                    <input type="text" id="theme" name="theme" required>
                </div>
                <div class="input-group">
                    <label for="budget">Expected Budget</label>
                    <input type="number" id="budget" name="budget" required>
                </div>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="salon" checked> Get the service of separate Salons for bride and groom</label>
                    <label><input type="checkbox" name="dressmakers"> Get the service of separate Dress Makers for bride and groom</label>
                </div>
            </section>

            <section class="bride-groom-details">
                <div class="bride-details">
                    <h2>Bride Details</h2>
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
                    <div class="input-group">
                        <label for="bride_address">Address</label>
                        <input type="text" id="bride_address" name="bride_address" required>
                    </div>
                    <div class="input-group">
                        <label for="bride_age">Age</label>
                        <input type="number" id="bride_age" name="bride_age" required>
                    </div>
                </div>

                <div class="groom-details">
                    <h2>Groom Details</h2>
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
                    <div class="input-group">
                        <label for="groom_address">Address</label>
                        <input type="text" id="groom_address" name="groom_address" required>
                    </div>
                    <div class="input-group">
                        <label for="groom_age">Age</label>
                        <input type="number" id="groom_age" name="groom_age" required>
                    </div>
                </div>
            </section>

            <div class="submit-button">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
