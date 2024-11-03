<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer - Sign In</title>
    <link href="https://fonts.googleapis.com/css?family=Gwendolyn&display=swap" rel="stylesheet" />
    <link href="/public/assets/css/CustomerSignIn.css" rel="stylesheet" />
</head>
<body>
    <header>
        <div class="nav-bar-logo-container">

            <img src="/public/assets/images/Logo.png" alt="Blissful Beginnings Logo" class="nav-bar-logo" />

        </div>
        <div class="wedding-title-container">
            <h1 class="wedding-title">Customer - Sign In</h1>
        </div>
    </header>

    <div class="box">
        <form>
          <label id="label" for="email">Email</label><br>
          <input id="input" type="email" id="email" name="email" placeholder="Enter email" required><br><br>
          <label id="label" for="password">Password</label><br>
          <input id="input" type="password" id="password" name="password" placeholder="Enter password" required><br><br>
          <input type="submit" id="submit" value="Sign In">
        </form>
    </div>
</body>
</html>