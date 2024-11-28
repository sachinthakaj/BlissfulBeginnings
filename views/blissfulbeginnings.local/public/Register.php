<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./public/assets/css/Register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
            <div class="nav-bar-logo-container">
                <img src="./public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
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
        <script src="./public/assets/js/Register.js"></script>
    </div>
</body>
</html>
