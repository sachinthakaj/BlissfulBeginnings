const path = window.location.pathname;
const pathParts = path.split('/');
const weddingID = pathParts[pathParts.length - 1];

const weddingTitle = document.querySelector('.wedding-title');
const timeRemaining = document.getElementById('days-left');
const weddingProgress = document.getElementById('wedding-progress-bar');
const budgetProgress = document.getElementById('budget-progress-bar');
const vendorGrid = document.querySelector('.vendor-grid');


const vendors = [
    { name: 'Salon 1', type: "Groom's Salon", progress: 60, budget: 40 },
    { name: 'Salon 2', type: "Bride's Salon", progress: 60, budget: 40 },
    { name: 'Dressmaker 1', type: "Bride's Dressmaker", progress: 60, budget: 40 },
    { name: 'Dressmaker 2', type: "Groom's Dressmaker", progress: 60, budget: 40 },
    { name: 'Photographer', type: 'Photographer', progress: 100, budget: 40 },
    { name: 'Florist', type: 'Florist', progress: 60, budget: 40 },
];

function createVendorCard(vendor) {
    return `
        <div class="vendor-card">
            <h3>${vendor.name}</h3>
            <p>${vendor.type}</p>
            <div class="vendor-image"></div>
            <div class="progress-bar-container">
                <div class="bar vendor-bar" style="width: 100%"></div>
                <div class="bar wedding-progress-bar" style="width: ${vendor.progress}%"></div>
            </div>
            <div class="progress-bar-container">
            <div class="bar vendor-bar" style="width: 100%"></div>
                <div class="bar budget-progress-bar" style="width: ${vendor.budget}%"></div>
            </div>
        </div>
    `;
}



function newWedding(data) {
    try {
        fetch('/wedding/couple-details/' + weddingID, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                alert(response);
                if (response.status === 401) {
                    window.location.href = '/signin';
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        }).then(personData => {
            console.log(personData);
            var brideData = personData.brideDetails;
            var groomData = personData.groomDetails;
            vendorGrid.innerHTML = `
                <img src="/public/assets/images/hourglass.gif" alt="hourglass GIF">
                <p>The wedding planner will assign vendors to you shortly</p>
                <p>We'll send an email once it is done</p>
                <a class="open-modal-btn"><p>We'll send an email once it is done</p></a>
                <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <form id="multiStepForm">
                            <div class="form-progress-bar">
                                <div id="step1-progress" class="active"></div>
                                <div id="step2-progress"></div>
                                <div id="step3-progress"></div>
                            </div>
                            <section class="wedding-details step active">
                                <h2>Wedding Details</h2>
                                <div class="input-group">
                                    <label for="date">Date</label>
                                    <input type="date" id="date" name="date" value=${data.date} required>
                                </div>
                                <div class="input-group">
                                    <label for="daynight">Day/Night</label>
                                    <input type="text" id="daynight" name="daynight" value=${data.dayNight} required>
                                </div>
                                <div class="input-group">
                                    <label for="location">Location</label>
                                    <input type="text" id="location" name="location" value=${data.location} required>
                                </div>
                                <div class="input-group">
                                    <label for="theme">Theme</label>
                                    <input type="text" id="theme" name="theme" value=${data.theme} required>
                                </div>
                                <div class="input-group">
                                    <label for="budget">Expected Budget</label>
                                    <input type="number" id="budget" name="budget" value=${data.budget} required>
                                </div>
                                <div class="checkbox-group">
                                    <label><input type="checkbox" name="salon" id="sepSalons" ${data.sepSalons ? 'checked' : ''}     > Get the service of separate Salons for bride and groom</label>
                                    <label><input type="checkbox" name="dressmakers" id="sepDressmakers" value=${data.sepDressmakers} > Get the service of separate Dress Makers for bride and groom</label>
                                </div>
                                <br>
                                <button type="button" id="nextBtn">Next</button>
                            </section>

                            <div class="bride-details step">
                                <h2>Bride Details</h2>
                                <div class="input-group">
                                    <label for="bride_name">Name</label>
                                    <input type="text" id="bride_name" name="bride_name" value=${brideData.name} required>
                                </div>
                                <div class="input-group">
                                    <label for="bride_email">Email</label>
                                    <input type="email" id="bride_email" name="bride_email" value=${brideData.email} required>
                                </div>
                                <div class="input-group">
                                    <label for="bride_contact">Contact</label>
                                    <input type="tel" id="bride_contact" name="bride_contact" value=${brideData.contact} required>
                                </div>
                                <div class="input-group">
                                    <label for="bride_address">Address</label>
                                    <input type="text" id="bride_address" name="bride_address"  value=${brideData.address} required>
                                </div>
                                <div class="input-group">
                                    <label for="bride_age">Age</label>
                                    <input type="number" id="bride_age" name="bride_age"  value=${brideData.age} required>
                                </div>
                                <br>
                                <button type="button" id="prevBtn">Previous</button>
                                <button type="button" id="nextBtn">Next</button>
                            </div>

                            <div class="groom-details step">
                                <h2>Groom Details</h2>
                                <div class="input-group">
                                    <label for="groom_name">Name</label>
                                    <input type="text" id="groom_name" name="groom_name" value=${groomData.name} required>
                                </div>
                                <div class="input-group">
                                    <label for="groom_email">Email</label>
                                    <input type="email" id="groom_email" name="groom_email" value=${groomData.email} required>
                                </div>
                                <div class="input-group">
                                    <label for="groom_contact">Contact</label>
                                    <input type="tel" id="groom_contact" name="groom_contact" value=${groomData.contact} required>
                                </div>
                                <div class="input-group">
                                    <label for="groom_address">Address</label>
                                    <input type="text" id="groom_address" name="groom_address" value=${groomData.address} required>
                                </div>
                                <div class="input-group">
                                    <label for="groom_age">Age</label>
                                    <input type="number" id="groom_age" name="groom_age" value=${groomData.age} required>
                                </div>
                                <div class="submit-button">
                                    <button type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                        </div>
                `
        })
    } catch (error) {
        console.error("Endpoint error");
    }


    // Multi-Step Form Logic
    const steps = document.querySelectorAll('.step');
    const nextBtn = document.querySelectorAll('#nextBtn');
    const prevBtn = document.querySelectorAll('#prevBtn');
    const form = document.getElementById('multiStepForm');

    const progressBars = document.querySelectorAll('.progress-bar div');

    let currentStep = 0;

    // Function to display the current step
    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
        updateProgressBar(stepIndex);
    }

    // Function to update the progress bar
    function updateProgressBar(stepIndex) {
        progressBars.forEach((bar, index) => {
            bar.classList.toggle('active', index <= stepIndex);
        });
    }

    // Navigate to the next step
    nextBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                currentStep++;
                if (currentStep < steps.length) {
                    showStep(currentStep);
                }
            }
        });
    });

    // Navigate to the previous step
    prevBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            currentStep--;
            if (currentStep >= 0) {
                showStep(currentStep);
            }
        });
    });

    // Function to validate the current step
    function validateStep(stepIndex) {
        const inputs = steps[stepIndex].querySelectorAll('input');
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
            }
        });
        return valid;
    }
    // Get modal element
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.querySelector(".open-modal-btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function getNames() {
    Names = {
        brideName: "Samantha",
        groomName: "Keerthi",
    }
    return (Names.brideName + "'s & " + Names.groomName + "'s Wedding");
}


const getTimeRemaining = () => {
    time = {
        days: 21,
    }
    return (
        `<h2>${time.days} days left...</h2>`
    );
}

const getProgress = (wedding, budget) => {
    progress = {
        budget: 40,
        wedding: 60,
    }
    wedding.style.width = `${progress.wedding}%`;
    budget.style.width = `${progress.budget}%`;

}

function render() {
    try {
        fetch('/wedding/data/' + weddingID, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/SignIn';
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        }).then(data => {
            if (data.weddingState === "new") {
                newWedding(data);
            } else {

            }
        })
    } catch (error) {

    }
}

document.addEventListener('DOMContentLoaded', render);