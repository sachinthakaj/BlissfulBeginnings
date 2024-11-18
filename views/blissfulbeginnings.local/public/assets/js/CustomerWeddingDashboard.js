const path = window.location.pathname;
const pathParts = path.split('/');
const weddingID = pathParts[pathParts.length - 1];

const weddingTitle = document.querySelector('.wedding-title');
const timeRemaining = document.getElementById('days-left');
const weddingProgress = document.getElementById('wedding-progress-bar');
const budgetProgress = document.getElementById('budget-progress-bar');
const vendorGrid = document.querySelector('.vendor-grid');

function showNotification(message, color) {
    // Create notification element
    const notification = document.createElement("div");
    notification.textContent = message;
    notification.style.position = "fixed";
    notification.style.bottom = "20px";
    notification.style.left = "20px";
    notification.style.backgroundColor = color;
    notification.style.color = "white";
    notification.style.padding = "10px 20px";
    notification.style.borderRadius = "5px";
    notification.style.zIndex = 1000;
    notification.style.fontSize = "16px";

    // Append to body
    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}



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
    vendorGrid.innerHTML = `
                <img src="/public/assets/images/hourglass.gif" alt="hourglass GIF">
                <p>The wedding planner will assign vendors to you shortly</p>
                <p>We'll send an email once it is done</p>
                <a class="open-modal-btn"><p>Click here to change the wedding details</p></a>`;

    // Get the button that opens the modal
    var btn = document.querySelector(".open-modal-btn");

    // When the user clicks the button, open the modal
    btn.onclick = function () {
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
                const brideData = personData.brideDetails;
                const groomData = personData.groomDetails;
                const modal = document.createElement("div");
                modal.className = "modal";
                modal.innerHTML = `
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <form id="multiStepForm">
                                <div class="form-progress-bar">
                                    <div id="step1-progress" class="active"></div>
                                    <div id="step2-progress"></div>
                                    <div id="step3-progress"></div>
                                </div>
                                <section class="step active" id="wedding-details">
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
    
                                <div class="step" id="bride-details">
                                    <h2>Bride Details</h2>
                                    <div class="input-group">
                                        <label for="bride_name">Name</label>
                                        <input type="text" id="bride_name" name="name" value=${brideData.name} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="bride_email">Email</label>
                                        <input type="email" id="bride_email" name="email" value=${brideData.email} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="bride_contact">Contact</label>
                                        <input type="tel" id="bride_contact" name="contact" value=${brideData.contact} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="bride_address">Address</label>
                                        <input type="text" id="bride_address" name="address"  value=${brideData.address} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="bride_age">Age</label>
                                        <input type="number" id="bride_age" name="age"  value=${brideData.age} required>
                                    </div>
                                    <br>
                                    <button type="button" id="prevBtn">Previous</button>
                                    <button type="button" id="nextBtn">Next</button>
                                </div>
    
                                <div class="step" id="groom-details">
                                    <h2>Groom Details</h2>
                                    <div class="input-group">
                                        <label for="groom_name">Name</label>
                                        <input type="text" id="groom_name" name="name" value=${groomData.name} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="groom_email">Email</label>
                                        <input type="email" id="groom_email" name="email" value=${groomData.email} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="groom_contact">Contact</label>
                                        <input type="tel" id="groom_contact" name="contact" value=${groomData.contact} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="groom_address">Address</label>
                                        <input type="text" id="groom_address" name="address" value=${groomData.address} required>
                                    </div>
                                    <div class="input-group">
                                        <label for="groom_age">Age</label>
                                        <input type="number" id="groom_age" name="age" value=${groomData.age} required>
                                    </div>
                                    <div class="submit-button">
                                        <button type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                    `;
                vendorGrid.appendChild(modal);
                // Multi-Step Form Logic
                const steps = document.querySelectorAll('.step');
                const nextBtn = document.querySelectorAll('#nextBtn');
                const prevBtn = document.querySelectorAll('#prevBtn');

                const form = document.getElementById('multiStepForm');
                const weddingDetails = document.getElementById('wedding-details');
                const brideDetails = document.getElementById('bride-details');
                const groomDetails = document.getElementById('groom-details');

                const progressBars = document.querySelectorAll('.progress-bar div');

                let changedWeddingFields = {};
                let changedBrideFields = {};
                let changedGroomFields = {};
                let currentStep = 0;

                // Attach the 'change' event listener to each input field
                weddingDetails.querySelectorAll("input, select, textarea").forEach((input) => {
                    input.addEventListener("change", (event) => {
                        const { name, value } = event.target;
                        // Add changed fields to the object
                        changedWeddingFields[name] = value;
                        console.log(`${name} changed, new value: ${value}`);
                    });
                });

                // Attach the 'change' event listener to each input field
                brideDetails.querySelectorAll("input, select, textarea").forEach((input) => {
                    input.addEventListener("change", (event) => {
                        const { name, value } = event.target;
                        // Add changed fields to the object
                        changedBrideFields[name] = value;
                        console.log(`${name} changed, new value: ${value}`);
                    });
                });// Attach the 'change' event listener to each input field

                groomDetails.querySelectorAll("input, select, textarea").forEach((input) => {
                    input.addEventListener("change", (event) => {
                        const { name, value } = event.target;
                        // Add changed fields to the object
                        changedGroomFields[name] = value;
                        console.log(`${name} changed, new value: ${value}`);
                    });
                });

                // Function to display the notification

                form.addEventListener("submit", (event) => {
                    event.preventDefault(); // Prevents default form submission
                    // Send `changedFields` to the backend
                    fetch("/update-wedding/" + weddingID, {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ changedWeddingFields, changedBrideFields, changedGroomFields }),
                    }).then(response => {
                        currentStep = 0;
                        modal.style.display = "none";
                        if (!response.ok) {
                            alert(response);
                            if (response.status === 401) {
                                window.location.href = '/signin';
                            } else {
                                showNotification("Update unsuccessful!", "red");
                                throw new Error('Network response was not ok');
                            }
                        }
                        showNotification("Update successful!", "green");
                        currentStep = 0;
                        modal.style.display = "none";
                    })
                });

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
                                console.log(currentStep);
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

                modal.style.display = "block";

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];



                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    currentStep = 0;
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        currentStep = 0;
                        modal.style.display = "none";
                    }
                }
            })
        } catch (error) {
            console.error("Endpoint error");
        }
    }
}

const ongoing = (data) => {
    try {
        fetch('/assigned-packages/' + weddingID, {
            method: "GET",
            headers: {
                "Content-type": "application/json"
            }
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
        }).then(packageData => {

        })
    } catch (e) {
        console.error(e);
    }
}

const unassigned = (data) => {
    try {
        fetch('/reccomendations/' + weddingID, {
            method: "GET",
            headers: {
                "Content-type": "application/json"
            }
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
        }).then(response => {
            let selectedPackages = {};
            currentStepCounter = 0;
            vendorGrid.innerHTML = `
            <div class="step current">
                <div class="package-selector" id="salon-package-selector">
                    <div class="package-selector-information">
                    <img src="/public/assets/images/desk-chair_341178 1.png" alt="picture of a Salon Chair">
                    <p>Choose a Salon Package</p>
                    </div>
                    <div class="reccomendation-grid" id="Salons"></div>
                    <button class="next-button">Next</button>
                </div>
            </div>
            <div class="step">
                <div class="package-selector" id="photographer-package-selector">
                    <div class="package-selector-information">
                    <img src="/public/assets/images/camera_1361782 1.png" alt="picture of a Camera">
                    <p>Choose a  Package</p>
                    </div>
                    <div class="reccomendation-grid" id="Photographers"></div>
                    <button class="next-button">Next</button>
                </div>
            </div>
            
            <div class="step">
                <div class="package-selector" id="dressmaker-package-selector">
                    <div class="package-selector-information">
                    <img src="/public/assets/images/dress_14383759 1.png" alt="picture of a Dress">
                    <p>Choose a Salon Package</p>
                    </div>
                    <div class="reccomendation-grid" id="Dressmakers"></div>
                    <button class="next-button">Next</button>

                </div>
            </div>
            
            <div class="step">
                <div class="package-selector" id="florist-package-selector">
                    <div class="package-selector-information">
                    <img src="/public/assets/images/nature_10601927 1.png" alt="picture of a Flower">
                    <p>Choose a Salon Package</p>
                    </div>
                    <div class="reccomendation-grid" id="Florists"></div>
                    <button class="submit-button">Submit</button>
                </div>
            </div>`
                ;
            vendorGrid.querySelectorAll('.next-button').forEach(btn => {
                btn.addEventListener('click', (event) => {
                    const currentStep = vendorGrid.querySelector('.step.current');
                    const nextStep = currentStep.nextElementSibling;
                    console.log(currentStepCounter);
                    if (Object.keys(selectedPackages).length === currentStepCounter + 1) {
                        currentStepCounter++;
                        currentStep.classList.remove('current');
                        nextStep.classList.add('current');
                    } else {
                        showNotification("Please select a package", "red");
                    }
                })
            })
            vendorGrid.querySelector('.submit-button').addEventListener('click', (event) => {
                if (Object.keys(selectedPackages).length === currentStepCounter) {
                    const packages = Object.values(selectedPackages);
                    fetch('/assign-packages/' + weddingID, {
                        method: "POST",
                        headers: {
                            "Content-type": "application/json"
                        },
                        body: JSON.stringify(packages)
                    }).then(response => {
                        if (!response.ok) {
                            alert(response);
                            if (response.status === 401) {
                                window.location.href = '/signin';
                            } else {
                                throw new Error('Network response was not ok');
                            }
                        } else {
                            location.reload();
                        }
                    })
                }
            })

            vendorGrid.querySelectorAll('.package-selector').forEach(packagesDiv => {
                recGrid = packagesDiv.querySelector(".reccomendation-grid");
                response[recGrid.id].forEach(package => {
                    const packageDiv = document.createElement('div');
                    packageDiv.classList.add('package');
                    packageDiv.setAttribute("id", package.packageID);
                    packageDiv.innerHTML += `
                    <div class="package-details">
                        <div>${package.packageName}</div>
                        <div>What's Included:</div>
                        <ul>
                            <li>${package.feature1}</li>
                            ${package.feature2 ? `<li>${package.feature2}</li>` : ''}
                            ${package.feature3 ? `<li>${package.feature3}</li>` : ''}
                        </ul>
                        <div class="price">${package.fixedCost}</div>
                        <btn class="visit">Visit Vendor</btn>
                    </div>
                    `
                    packageDiv.querySelector('.visit').addEventListener('click', (event) => {
                        window.location.href = '/vendor/' + package.vendorID;
                    })
                    packageDiv.addEventListener('click', (event) => {
                        console.log(packageDiv.parentElement.id);
                        if (packageDiv.classList.contains('active')) {
                            delete selectedPackages[packageDiv.parentElement.id];
                        } else {
                            if (selectedPackages[packageDiv.parentElement.id]) {
                                console.log(packageDiv.parentElement)
                                packageDiv.parentElement.querySelector('#' + selectedPackages[packageDiv.parentElement.id]).classList.toggle('active');
                            }
                            selectedPackages[packageDiv.parentElement.id] = package.packageID;
                        }
                        packageDiv.classList.toggle('active');
                        console.log(selectedPackages);
                    });
                    recGrid.appendChild(packageDiv);
                }
                )
            })

        }).catch()

    } catch (e) {
        console.error(e);
        showNotification("Something went wrong", "red");
    }
}


function render() {
    const loadingScreen = document.getElementById("loading-screen");
    const mainContent = document.getElementById("main-content");
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
            } else if (data.weddingState === "ongoing") {
                ongoing(data);
            } else if (data.weddingState === "unassigned") {
                unassigned(data)
            }
            loadingScreen.style.display = "none";
            mainContent.style.display = "block";
        })
    } catch (error) {
        console.error('Error fetching data early:', error)
        loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
    }
}

document.addEventListener('DOMContentLoaded', render);