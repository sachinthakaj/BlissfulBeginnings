<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Blissful Beginnings</title>
    <link rel="stylesheet" href="./public/assets/css/Register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo-container">
                <div class="logo">Blissful <span>Beginnings</span></div>
                <p class="tagline">Where forever begins</p>
            </div>
            <div class="welcome-message">
                <h1>Start Your Wedding Journey</h1>
                <p>Create an account to begin planning your perfect day with professional assistance every step of the way.</p>
                <div class="decoration">
                    <i class="fas fa-heart"></i>
                    <span class="line"></span>
                    <i class="fas fa-rings-wedding"></i>
                    <span class="line"></span>
                    <i class="fas fa-dove"></i>
                </div>
            </div>
            <div class="testimonial">
                <p>"Blissful Beginnings made our wedding planning process so seamless and stress-free. We couldn't be happier!"</p>
                <div class="testimonial-author">- Sarah & Michael</div>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-header">
                <h2>Create Your Account</h2>
                <p>Fill in your details to get started</p>
            </div>
            
            <form class="form">
                <div class="form-group">
                    <label for="email">Email<span class="required">*</span></label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password<span class="required">*</span></label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Create a secure password" required>
                        <i class="fas fa-eye-slash toggle-password" data-target="password"></i>
                    </div>
                    <div class="password-strength">
                        <div class="strength-meter">
                            <div class="strength-segment"></div>
                            <div class="strength-segment"></div>
                            <div class="strength-segment"></div>
                            <div class="strength-segment"></div>
                        </div>
                        <span class="strength-text">Password strength</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password<span class="required">*</span></label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                        <i class="fas fa-eye-slash toggle-password" data-target="confirm-password"></i>
                    </div>
                </div>

                <div class="form-group checkbox-group">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">
                            <span class="checkbox-custom"><i class="fas fa-check"></i></span>
                            <span class="checkbox-text">I agree to the <a href="#">terms and conditions</a><span class="required">*</span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group checkbox-group">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="newsletter" name="newsletter">
                        <label for="newsletter">
                            <span class="checkbox-custom"><i class="fas fa-check"></i></span>
                            <span class="checkbox-text">Subscribe to our newsletter for wedding planning tips</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Create Account</button>
               
            </form>
            <script src="./public/assets/js/Register.js"></script>
            
            <div class="login-link">
                <p>Already have an account? <a href="/signin">Sign in</a></p>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            });
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthSegments = document.querySelectorAll('.strength-segment');
        const strengthText = document.querySelector('.strength-text');

        passwordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            
            if (value.length >= 8) strength++;
            if (/[A-Z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^A-Za-z0-9]/.test(value)) strength++;
            
            for (let i = 0; i < strengthSegments.length; i++) {
                if (i < strength) {
                    strengthSegments[i].classList.add('active');
                } else {
                    strengthSegments[i].classList.remove('active');
                }
            }
            
            if (value.length === 0) {
                strengthText.textContent = 'Password strength';
            } else {
                const texts = ['Weak', 'Fair', 'Good', 'Strong'];
                strengthText.textContent = texts[strength - 1] || 'Weak';
            }
        });
    </script>
</body>
</html>



