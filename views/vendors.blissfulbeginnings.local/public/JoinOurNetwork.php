<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blissful Beginnings - Join Our Network</title>

    <link href="/public/assets/css/JoinOurNetwork.css" rel="stylesheet">
    <script src="/public/assets//js/JoinOurNetwork.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <h1>Blissful Beginnings</h1>
                <p class="tagline">Where forever begins</p>
            </div>
        </header>

        <main class="main-content">
            <div class="page-title">
                <h2>Join Our Network</h2>
                <p>Partner with us to showcase your services to couples planning their perfect day</p>
            </div>

            <form id="signup-form">
                <div class="form-container">
                    <div class="form-column vendor-info">
                        <div class="section-title">
                            <i class="fas fa-store"></i>
                            <h3>Vendor Details</h3>
                        </div>

                        <div class="form-group photo-upload">
                            <label for="photo">Business Profile Photo</label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <p>Drag & Drop your file here</p>
                                <span>or</span>
                                <button type="button" class="browse-btn">Browse Files</button>
                                <input type="file" id="photo" name="photo" accept="image/*" hidden>
                                <p class="file-info">Supported formats: JPG, PNG (Max 5MB)</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="business-name">Business Name<span class="required">*</span></label>
                            <input type="text" id="business-name" name="name" placeholder="Enter your business name" required>
                        </div>

                        <div class="form-group">
                            <label for="businessType">Type<span class="required">*</span></label>
                            <select id="businessType" name="businessType" required>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description<span class="required">*</span></label>
                            <textarea id="description" name="description" placeholder="Tell couples about your services and what makes your business unique" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number<span class="required">*</span></label>
                            <input type="tel" id="contact" name="contact" placeholder="Enter your business phone number" pattern="[0-9]{10}" required>
                        </div>

                        <div class="form-group">
                            <label for="websiteLink">Website & Social Media<span class="required">*</span></label>
                            <textarea id="websiteLink" name="websiteLink" placeholder="Enter your website URL and social media links" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="address">Business Address<span class="required">*</span></label>
                            <textarea id="address" name="address" placeholder="Enter your complete business address" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="form-column account-info">
                        <div class="section-title">
                            <i class="fas fa-user-circle"></i>
                            <h3>Account Information</h3>
                        </div>

                        <div class="form-group">
                            <label for="email">Email<span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                        </div>

                        <div class="form-group">
                            <label for="conf-email">Confirm Email<span class="required">*</span></label>
                            <input type="email" id="conf-email" name="confirmEmail" placeholder="Confirm your email address" required>
                        </div>

                        <div class="form-group password-field">
                            <label for="password">Password<span class="required">*</span></label>
                            <div class="password-input">
                                <input type="password" id="password" name="password" placeholder="Create a secure password" required>
                                <i class="toggle-password fas fa-eye-slash" data-target="password"></i>
                            </div>
                        </div>

                        <div class="form-group password-field">
                            <label for="conf-password">Confirm Password<span class="required">*</span></label>
                            <div class="password-input">
                                <input type="password" id="conf-password" name="confirmPassword" placeholder="Confirm your password" required>
                                <i class="toggle-password fas fa-eye-slash" data-target="conf-password"></i>
                            </div>
                        </div>

                        <div class="form-group terms">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></label>
                        </div>

                        <div class="submit-section">
                            <button type="submit" class="submit-button">Join Our Network</button>
                            <p class="login-link">Already a partner? <a href="/signin">Log in here</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 Blissful Beginnings. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Toggle password visibility
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

        // File upload functionality
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('photo');
        const browseBtn = document.querySelector('.browse-btn');

        browseBtn.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');

            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updateFileInfo(e.dataTransfer.files[0].name);
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                updateFileInfo(fileInput.files[0].name);
            }
        });

        function updateFileInfo(fileName) {
            const fileInfo = dropZone.querySelector('.file-info');
            fileInfo.textContent = `Selected file: ${fileName}`;
            dropZone.classList.add('has-file');
        }
    </script>
</body>

</html>