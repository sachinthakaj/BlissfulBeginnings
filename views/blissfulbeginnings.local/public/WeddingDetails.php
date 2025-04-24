<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Details | Blissful Beginnings</title>
    <link rel="stylesheet" href="/public/assets/css/WeddingDetails.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">
        <header>
           
            <h1>Your Dream Wedding</h1>
            <p class="subtitle">Tell us about your special day</p>
        </header>

        <main class="form-container">
            <div class="decoration top-decoration">
                <div class="line"></div>
                <i class="fas fa-heart"></i>
                <div class="line"></div>
            </div>

            <form id="multiStepForm">
                <div class="form-steps">
                    <div class="step-item active">
                        <div class="step-number">1</div>
                        <div class="step-label">Wedding Details</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-label">Bride Details</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-label">Groom Details</div>
                    </div>
                </div>

                <div class="form-progress-bar">
                    <div id="step1-progress" class="active"></div>
                    <div id="step2-progress"></div>
                    <div id="step3-progress"></div>
                </div>

                <section class="wedding-details step active">
                    <h2>Wedding Details</h2>
                    <p class="section-description">Share the vision for your perfect day</p>

                    <div class="box-container">
                        <div class="left">
                            <div class="input-group">
                                <label for="date">Date<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                    <input type="date" id="date" name="date" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="daynight">Day/Night<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-sun"></i>
                                    <select id="daynight" name="daynight" required>
                                        <option value="" disabled selected>Choose time of day</option>
                                        <option value="day">Day</option>
                                        <option value="night">Night</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="wedding-party-male">Number of groomsmen<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user-friends"></i>
                                    <input type="number" id="wedding-party-male" name="wedding-party-male" min="0" placeholder="0" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="wedding-party-female">Number of bridesmaids<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-female"></i>
                                    <input type="number" id="wedding-party-female" name="wedding-party-female" min="0" placeholder="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="right">
                            <div class="input-group">
                                <label for="theme">Theme<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-palette"></i>
                                    <input type="text" id="theme" name="theme" placeholder="e.g. Rustic, Formal, Beach" required>
                                </div>
                            </div>

                           

                            <div class="input-group">
                                <label for="location">Location<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <input type="text" id="location" name="location" placeholder="Wedding venue" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="budget-range">Expected Budget<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                    <select id="budget-range" name="budget" onchange="handleRangeChange()" required>
                                        <option value="" disabled selected>Select a budget range</option>
                                        <option value="0-1000">$0 - $1,000</option>
                                        <option value="1000-5000">$1,000 - $5,000</option>
                                        <option value="5000-10000">$5,000 - $10,000</option>
                                        <option value="10000-25000">$10,000 - $25,000</option>
                                        <option value="25000-50000">$25,000 - $50,000</option>
                                        <option value="50000-100000">$50,000 - $100,000</option>
                                        <option value="100000+">Over $100,000</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                </div>

                                <!-- Custom range inputs (initially hidden) -->
                                <div id="custom-range-container" style="display: none; margin-top: 10px;">
                                    <div class="custom-range-inputs">
                                        <div class="custom-input">
                                            <label for="min-budget">Minimum ($)</label>
                                            <div class="input-with-icon mini">
                                                <i class="fas fa-dollar-sign"></i>
                                                <input type="number" id="min-budget" min="0" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="custom-input">
                                            <label for="max-budget">Maximum ($)</label>
                                            <div class="input-with-icon mini">
                                                <i class="fas fa-dollar-sign"></i>
                                                <input type="number" id="max-budget" min="0" placeholder="1000">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="range-error" class="error-message" style="display: none;">
                                        Minimum value must be less than maximum value.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="additional-options">
                        <h3>Additional Services</h3>
                        <div class="checkbox-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="salon" id="sepSalons">
                                <span class="checkbox-custom"><i class="fas fa-check"></i></span>
                                <span class="checkbox-text">Separate salon services for bride and groom</span>
                            </label>

                            <label class="custom-checkbox">
                                <input type="checkbox" name="dressDesigners" id="sepDressDesigners">
                                <span class="checkbox-custom"><i class="fas fa-check"></i></span>
                                <span class="checkbox-text">Separate dress designers for bride and groom</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="next-btn" id="nextBtn1">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </section>

                <section class="bride-details step">
                    <h2>Bride Details</h2>
                    <p class="section-description">Tell us about the bride</p>

                    <div class="box-container">
                        <div class="left">
                            <div class="input-group">
                                <label for="bride_name">Name<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="bride_name" name="bride_name" placeholder="Full name" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="bride_email">Email<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" id="bride_email" name="bride_email" placeholder="Email address" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="bride_contact">Contact<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="bride_contact" name="bride_contact" placeholder="Phone number" required>
                                </div>
                            </div>
                        </div>

                        <div class="right">
                            <div class="input-group">
                                <label for="bride_address">Address<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-home"></i>
                                    <input type="text" id="bride_address" name="bride_address" placeholder="Home address" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="bride_age">Age<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-birthday-cake"></i>
                                    <input type="number" id="bride_age" name="bride_age" min="18" placeholder="Age" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="prev-btn" id="prevBtn1">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="next-btn" id="nextBtn2">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </section>

                <section class="groom-details step">
                    <h2>Groom Details</h2>
                    <p class="section-description">Tell us about the groom</p>

                    <div class="box-container">
                        <div class="left">
                            <div class="input-group">
                                <label for="groom_name">Name<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="groom_name" name="groom_name" placeholder="Full name" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="groom_email">Email<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" id="groom_email" name="groom_email" placeholder="Email address" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="groom_contact">Contact<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="groom_contact" name="groom_contact" placeholder="Phone number" required>
                                </div>
                            </div>
                        </div>

                        <div class="right">
                            <div class="input-group">
                                <label for="groom_address">Address<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-home"></i>
                                    <input type="text" id="groom_address" name="groom_address" placeholder="Home address" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="groom_age">Age<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-birthday-cake"></i>
                                    <input type="number" id="groom_age" name="groom_age" min="18" placeholder="Age" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="prev-btn" id="prevBtn2">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-check"></i> Complete Registration
                        </button>
                    </div>
                </section>
            </form>
            <script src="/public/assets/js/WeddingDetails.js"></script>

            <div class="decoration bottom-decoration">
                <div class="line"></div>
                <i class="fas fa-heart"></i>
                <div class="line"></div>
            </div>
        </main>

        <footer>
            <p>© 2025 Blissful Beginnings. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Form navigation
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const stepItems = document.querySelectorAll('.step-item');
            const progressBars = document.querySelectorAll('.form-progress-bar div');

            // Next buttons
            document.getElementById('nextBtn1').addEventListener('click', function() {
                steps[0].classList.remove('active');
                steps[1].classList.add('active');
                stepItems[0].classList.add('completed');
                stepItems[1].classList.add('active');
                progressBars[1].classList.add('active');
                window.scrollTo(0, 0);
            });

            document.getElementById('nextBtn2').addEventListener('click', function() {
                steps[1].classList.remove('active');
                steps[2].classList.add('active');
                stepItems[1].classList.add('completed');
                stepItems[2].classList.add('active');
                progressBars[2].classList.add('active');
                window.scrollTo(0, 0);
            });

            // Previous buttons
            document.getElementById('prevBtn1').addEventListener('click', function() {
                steps[1].classList.remove('active');
                steps[0].classList.add('active');
                stepItems[1].classList.remove('active');
                stepItems[0].classList.remove('completed');
                progressBars[1].classList.remove('active');
                window.scrollTo(0, 0);
            });

            document.getElementById('prevBtn2').addEventListener('click', function() {
                steps[2].classList.remove('active');
                steps[1].classList.add('active');
                stepItems[2].classList.remove('active');
                stepItems[1].classList.remove('completed');
                progressBars[2].classList.remove('active');
                window.scrollTo(0, 0);
            });

            // Custom budget range handler
            window.handleRangeChange = function() {
                const budgetSelect = document.getElementById('budget-range');
                const customContainer = document.getElementById('custom-range-container');

                if (budgetSelect.value === 'custom') {
                    customContainer.style.display = 'block';
                } else {
                    customContainer.style.display = 'none';
                }
            };

            // Form submission
            document.getElementById('multiStepForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // Process form submission - you can add your logic here
                alert('Wedding details submitted successfully! We\'ll be in touch soon.');
            });
        });
    </script>
</body>

</html>