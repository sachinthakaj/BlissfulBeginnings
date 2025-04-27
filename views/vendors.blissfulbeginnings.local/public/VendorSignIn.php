<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Sign In</title>
    <link href="https://fonts.googleapis.com/css?family=Gwendolyn&display=swap" rel="stylesheet" />
    <link href="/public/assets/css/VendorSignIn.css" rel="stylesheet" />
    <script src="/public/assets//js/SignIn.js" defer></script>

</head>
<body>
    <header>
        <div class="nav-bar-logo-container">
            <img src="http://cdn.blissfulbeginnings.com/common-icons/blissful_beginnings_logo-nobg.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />
        </div>
    </header>


    <div class="box">
        <div class="image-left">
            <!-- <img src="http://cdn.blissfulbeginnings.com/common-icons/blissful_beginnings_logo-nobg.png" alt="Blissful Beginnings Logo" class> -->
        </div>
        <div class="form-right">
            <form class="form">
                <h2>Vendor - Sign In</h2>
                <label class="label" for="email">Email</label><br>
                <input class="input" type="email" id="email" name="email" placeholder="Enter email" required><br>
                <label class="label" for="password">Password</label><br>
                <input class="input" type="password" id="password" name="password" placeholder="Enter password" required><span><a href="" class="forgot-password">Forgot Password >>></a></span><br><br>
                <input type="submit" id="submit" value="Sign In">
            </form>
        </div>
    </div>
</body>
</html>