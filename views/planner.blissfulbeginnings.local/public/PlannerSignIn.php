<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blissful Beginnings - Sign In</title>
    <link href="/public/assets/css/PlannerSignIn.css" rel="stylesheet" />
    <script src="/public/assets/js/SignIn.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">Blissful <span class="gold-text">Beginnings</span></div>
            <div class="welcome-text">
                <h1>Welcome Back</h1>
                <p>Sign in to access your planning dashboard. Manage multiple clients, track timelines, and coordinate vendors all in one place. Blissful Beginnings helps you create perfect weddings with less stress.</p>
            </div>
        </div>
        <div class="right-panel">
            <div class="signin-header">
                <h2>Sign In-Planner</h2>
                <p>Please enter your details to access your account</p>
            </div>
            <form class="form">
                <label class="label" for="email">Email</label><br>
                <input class="input" type="email" id="email" name="email" placeholder="Enter email" required><br><br>
                <label class="label" for="password">Password</label><br>
                <input class="input" type="password" id="password" name="password" placeholder="Enter password" required><br><br>
                <input type="submit" id="submit" value="Sign In">
            </form>
            <div class="forgot-password">
                <a href="/reset-password">Forgot Password?</a>
            </div>
            
        </div>
    </div>
</body>

</html>