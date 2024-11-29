document.addEventListener("DOMContentLoaded", () =>{
    document.getElementById('password-form').addEventListener('submit', (e)=>{
        e.preventDefault();
        const email = form.getElementById('email');
        const cpassword= form.getElementById('cpassword');
        const password = form.getElementById('npassword')
        const cnpassword  = form.getElementById('cnpassword');
        if (password !== cnpassword) {
            alert('Passwords do not match!');
            return;  // Stop the form submission
        }
        const formData = {
            email: email,
            current_password: cpassword,
            new_password: password
        };

        // Send the data using Fetch API
        fetch('/BlissfulBeginnings/change-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            console.log(response);
            if (!response.ok) {
                if (response.status == 401) {
                    alert("Wrong credentials");
                    return;
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        })
        .then(data => {
            // Handle success (e.g., show a success message or redirect)
            if (data.token) {
                localStorage.setItem('authToken', data.token); // Store token securely
                window.location.href = '/wedding-details/' + data.userID;
              } else {
                console.error('Login failed');
              }
        })
        .catch(error => {
            // Handle error (e.g., show an error message)
            console.error('Error registering:', error);
        });
    })
})