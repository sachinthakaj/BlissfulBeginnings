<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/css/Register.css">
    <link href="https://fonts.googleapis.com/css?family=Gwendolyn&display=swap" rel="stylesheet">

</head>
<body>
    <header>
            <div class="nav-bar-logo-container">
                <img src="./assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
            </div>
            <div class="wedding-title-container">
                <h1 class="wedding-title">Create an account</h1>
            </div>
        </header>
    <div class="box">
        

        <form class="form" >
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="agree" name="agree" required>
                <label for="agree">I agree for the <a href="#">terms and conditions</a></label>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="newsletter" name="newsletter">
                <label for="newsletter">Check to subscribe to our newsletter</label>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
        <script src="./assets/js/Register.js"></script>
    </div>
</body>
</html>
