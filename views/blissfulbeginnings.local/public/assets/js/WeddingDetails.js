const path = window.location.pathname;
const pathParts = path.split('/');
const userID = pathParts[pathParts.length - 1];

document.addEventListener('DOMContentLoaded', () => {
    fetch('/validate-userID/' + userID , {
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
            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
            }
        });
        return valid;
    }

    // Show the first step on page load
    showStep(currentStep);
    console.log(form);

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const weddingDetails = {
            date: document.getElementById('date').value,
            time: document.getElementById('daynight').value,
            location: document.getElementById('location').value,
            theme: document.getElementById('theme').value,
            budget: document.getElementById('budget').value,
            sepSalons: document.getElementById('sepSalons').checked,
            sepDressDesigners: document.getElementById('sepDressDesigners').checked,
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
        }
        console.log(formData);

        console.log(form);
        fetch('/wedding-details/' + userID, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            console.log(response);
            
                if (response.status == 409) {
                    alert("Email is already registered");
                    return;
                } else if(response.status == 401) {
                    window.location.href = '/signin';
                } else if(response.status == 201) {
                    console.log(response);
                    return response.json();
                }
                else  {
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