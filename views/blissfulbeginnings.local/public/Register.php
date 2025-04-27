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
            <img src="http://cdn.blissfulbeginnings.com/common-icons/blissful_beginnings_logo-nobg.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
    </header>
    <div class="box">
        <div class="image-left"></div>

        <div class="form-right">
            <form class="form">
                <h2>Register</h2>
                <div class="form-group">
                    <label for="email" class="label">Email<span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password" class="label">Password<span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password" class="label">Confirm Password<span class="required">*</span></label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">I agree for the <a href="#">terms and conditions<span class="required">*</span></a></label>
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <label for="newsletter">Check to subscribe to our newsletter<span class="required">*</span></label>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
        <script src="./public/assets/js/Register.js"></script>
    </div>
</body>
</html>
