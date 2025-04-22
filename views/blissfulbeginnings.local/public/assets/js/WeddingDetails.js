const path = window.location.pathname;
const pathParts = path.split('/');
const userID = pathParts[pathParts.length - 1];

function handleRangeChange() {
    const selectElement = document.getElementById('budget-range');
    const customRangeContainer = document.getElementById('custom-range-container');
    const minBudget = document.getElementById('min-budget');
    const maxBudget = document.getElementById('max-budget');

    // Parse the selected range and fill min/max fields regardless of the selection
    if (selectElement.value && selectElement.value !== 'custom') {
        if (selectElement.value === '100000+') {
            minBudget.value = 100000;
            maxBudget.value = 0;  // No upper bound
        } else {
            const range = selectElement.value.split('-');
            minBudget.value =Number(range[0]);
            maxBudget.value = Number(range[1]);
        }
        customRangeContainer.style.display = 'none';
        selectElement.setAttribute('name', 'budget');
        minBudget.required = false;
        maxBudget.required = false;
    }

    if (selectElement.value === 'custom') {
        customRangeContainer.style.display = 'block';
        selectElement.removeAttribute('name');
        minBudget.required = true;
        maxBudget.required = true;

        if (!minBudget.value && !maxBudget.value) {
            minBudget.value = '';
            maxBudget.value = '';
        }

    } else {
        customRangeContainer.style.display = 'none';
        selectElement.setAttribute('name', 'budget');
        minBudget.required = false;
        maxBudget.required = false;
    }
}

function validateMinMax() {
    const minBudget = document.getElementById('min-budget');
    const maxBudget = document.getElementById('max-budget');
    const errorMessage = document.getElementById('range-error');

    // Only validate if both fields have values
    if (minBudget.value && maxBudget.value) {
        const minVal = parseInt(minBudget.value, 10);
        const maxVal = parseInt(maxBudget.value, 10);

        if (minVal >= maxVal) {
            // Show error message
            errorMessage.style.display = 'block';
            return false;
        } else {
            // Hide error message
            errorMessage.style.display = 'none';
            return true;
        }
    } else {
        // If one or both fields are empty, hide error
        errorMessage.style.display = 'none';
        return true;
    }
}

// Initialize the custom range inputs and add event listeners
document.addEventListener('DOMContentLoaded', function () {
    const minBudget = document.getElementById('min-budget');
    const maxBudget = document.getElementById('max-budget');

    minBudget.addEventListener('change', validateMinMax);
    maxBudget.addEventListener('change', validateMinMax);
});


document.addEventListener('DOMContentLoaded', () => {
    fetch('/validate-userID/' + userID, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
        }
    })
        .then(response => {
            if (response.ok) {
                return
            } else {
                window.location.href = '/register';
            }
        });
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
            if (input.id === 'date') {
                // Date validation
                const today = new Date();
                const selectedDate = new Date(input.value);
                if (selectedDate < today.setHours(0, 0, 0, 0)) {
                    alert('Date cannot be in the past.');
                    valid = false;
                }
            }

            if (input.id === 'bride_age' || input.id === 'groom_age') {
                // Age validation
                const age = parseInt(input.value, 10);
                if (age < 18 || age > 120) {
                    alert('Age must be between 18 and 120.');
                    valid = false;
                }
            }

            if (input.id === 'bride_contact' || input.id === 'groom_contact') {
                // Contact number validation
                const contact = input.value.trim();
                if (!/^\d{10}$/.test(contact)) {
                    alert('Contact number must be exactly 10 digits.');
                    valid = false;
                }
            }

            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
            }
        });

        return valid;
    }

    // Show the first step on page load
    showStep(currentStep);

    // Form submission logic
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const weddingDetails = {
            date: document.getElementById('date').value,
            time: document.getElementById('daynight').value,
            location: document.getElementById('location').value,
            theme: document.getElementById('theme').value,
            sepSalons: document.getElementById('sepSalons').checked,
            sepDressDesigners: document.getElementById('sepDressDesigners').checked,
            weddingPartyMale: document.getElementById('wedding-party-male').value,
            weddingPartyFemale: document.getElementById('wedding-party-female').value,
            budgetMax: document.getElementById('max-budget').value,
            budgetMin: document.getElementById('min-budget').value,
        };
        const brideDetails = {
            name: document.getElementById('bride_name').value,
            email: document.getElementById('bride_email').value,
            contact: document.getElementById('bride_contact').value,
            address: document.getElementById('bride_address').value,
            age: document.getElementById('bride_age').value,
        };

        const groomDetails = {
            name: document.getElementById('groom_name').value,
            email: document.getElementById('groom_email').value,
            contact: document.getElementById('groom_contact').value,
            address: document.getElementById('groom_address').value,
            age: document.getElementById('groom_age').value,
        };

        const formData = {
            weddingDetails,
            brideDetails,
            groomDetails,
        };

        console.log(formData);

        console.log(form);
        fetch('/wedding-details/' + userID, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData),
        })
            .then(response => {
                console.log(response);

                if (response.status == 409) {
                    alert("Email is already registered");
                    return;
                } else if (response.status == 401) {
                    window.location.href = '/signin';
                } else if (response.status == 201) {
                    console.log(response);
                    return response.json();
                }
                else {
                    throw new Error('Network response was not ok');
                }


            })
            .then(data => {
                // Handle success (e.g., show a success message or redirect)
                console.log('Success:', data);
                localStorage.setItem('authToken', data.token); // Store token securely
                window.location.href = "/wedding/" + data.weddingID;
            })
            .catch(error => {
                // Handle error (e.g., show an error message)
                console.error('Error registering:', error);
                alert('Registration failed, please try again.');
            });
    });
});
