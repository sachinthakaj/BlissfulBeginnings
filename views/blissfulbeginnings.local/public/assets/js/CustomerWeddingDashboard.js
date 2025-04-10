const path = window.location.pathname;
const pathParts = path.split('/');
const weddingID = pathParts[pathParts.length - 1];

const weddingTitle = document.querySelector('.wedding-title');
const timeRemaining = document.getElementById('days-left');
const weddingProgress = document.getElementById('wedding-progress-bar');
const budgetProgress = document.getElementById('budget-progress-bar');
const vendorGrid = document.querySelector('.vendor-grid');


document.addEventListener('DOMContentLoaded', function (){
    const payNowButton = document.querySelector('.pay-now');
    payNowButton.addEventListener('click',function(){
        window.location.href=`/wedding/payments/${weddingID}`;

    })
})

// Function to render messages to the chat container
function renderMessages() {
    const chatContainer = document.getElementById('chat-container');
    chatContainer.innerHTML = '';
  
    const wsUrl = 'ws://localhost:8080/';
  
    const socket = new WebSocket(wsUrl);
    const messageInput = document.getElementById('chat-type-field');
    const sendBtn = document.getElementById('chat-send-button');
  
  
    socket.onopen = () => {
      socket.send(JSON.stringify({
        weddingID: weddingID,
      }));
    };
  
    socket.onmessage = (event) => {
      const messages = JSON.parse(event.data);
      console.log(messages);
      messages.forEach(message => {
        sender = (message.role === 'Customer') ? 'me' : 'other';
        if (!message) {
          return;
        }
        if (message.relativePath) {
          appendImageMessage(message.relativePath, message.timestamp, sender);
          return;
        } else {
          appendTextMessage(message.message, message.timestamp, sender);
        }
      });
      chatContainer.scrollTop = chatContainer.scrollHeight; // Auto-scroll to the latest message
    };
  
    socket.onerror = (error) => {
      console.error('WebSocket error:', error);
      chatContainer.innerHTML = "<p>Unexpected error occured</p>"
    };
  
    socket.onclose = () => {
      console.log('WebSocket connection closed.');
    };
  
    function appendTextMessage(message, timestamp, sender) {
      const messageElement = document.createElement('div');
      messageElement.classList.add('message');
      messageElement.innerHTML = `<div class="sender ${sender}">` + sender + ': </div><p class=message-text>' + message + '</p>';
      messageElement.dataset.timestamp = timestamp;
      chatContainer.appendChild(messageElement);
    }
    function appendImageMessage(imageReference, timestamp, sender) {
      const imageElement = document.createElement('div');
      imageElement.classList.add('message', 'image');
      imageElement.dataset.timestamp = timestamp;
  
      const senderElement = document.createElement('div');
      senderElement.classList.add('sender', sender);
      senderElement.innerHTML = '<h4">' + sender + '</h4>';
      imageElement.appendChild(senderElement);
      const img = document.createElement('img');
      img.src = "http://cdn.blissfulbeginnings.local" + imageReference;
      img.alt = "Uploaded Image";
      img.classList.add('chat-image');
      img.style.maxWidth = '200px';
      img.style.borderRadius = '8px';
  
      imageElement.appendChild(img); // Append the image to the container
      chatContainer.appendChild(imageElement); // Append the message container to the chat
    }
  
  
    sendBtn.addEventListener('click', () => {
      timestamp = new Date().toISOString()
      timestamp = timestamp.replace('T', ' ').split('.')[0];
      const message = messageInput.value.trim();
      if (message) {
        chatMessage = {
          role: 'customer',
          message: message,
          timestamp: timestamp,
        };
        socket.send(JSON.stringify(chatMessage));
        console.log(chatMessage);
        appendTextMessage(message, timestamp, 'me');
        messageInput.value = '';
      }
    });
  
    messageInput.addEventListener('keypress', (event) => {
      if (event.key === 'Enter') {
        sendBtn.click();
      }
    });
  
    function appendImageMessage(imageReference, timestamp) {
      const imageElement = document.createElement('div'); // Container for the image
      imageElement.classList.add('message', 'me'); // Add the same class as normal messages
      imageElement.dataset.timestamp = timestamp;
  
      const img = document.createElement('img'); // Create the <img> element
      console.log(imageReference);
      img.src = "http://cdn.blissfulbeginnings.com/" + imageReference; // Set the source of the image
      img.alt = "Uploaded Image"; // Alt text for accessibility
      img.classList.add('chat-image'); // Optional class for styling the image
      img.style.maxWidth = '200px'; // Add a size limit if needed
      img.style.borderRadius = '8px'; // Optional: style the image to match your design
  
      imageElement.appendChild(img); // Append the image to the container
      chatContainer.appendChild(imageElement); // Append the message container to the chat
    }
  
  
    document.getElementById('imageUpload').addEventListener('change', async function (event) {
      const file = event.target.files[0]; // Get the selected file
  
      // Ensure a file was selected
      if (!file) {
        alert("No file selected.");
        return;
      }
  
  
      const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
      if (!validImageTypes.includes(file.type)) {
        alert("Please upload a valid image file (JPEG, PNG, GIF).");
        return;
      }
  
  
      const maxSize = 2 * 1024 * 1024;
      if (file.size > maxSize) {
        alert("File size must be less than 2 MB.");
        return;
      }
  
  
      timestamp = new Date().toISOString()
      timestamp = timestamp.replace('T', ' ').split('.')[0];
      sender = "planner"
      const formData = new FormData();
      formData.append("image", file);
      formData.append("timestamp", timestamp);
      formData.append("sender", JSON.stringify(sender));
  
      try {
        const response = await fetch("/chat/upload-image/" + weddingID, {
          method: "POST",
          body: formData,
        });
  
        if (!response.ok) {
          throw new Error(`Failed to upload image. Status: ${response.status}`);
        }
  
        const data = await response.json();
  
        if (!data.storagePath) {
          throw new Error("Invalid response from server. No storage path provided.");
        }
  
        const imageReference = data.storagePath;
  
        const metaWithImage = {
          timestamp: formData.timestamp,
          role: "Customer",
          relativePath: imageReference,
          Image: "image_reference",
        };
  
        socket.send(JSON.stringify(metaWithImage));
  
        appendImageMessage(imageReference, metaWithImage.timestamp);
        alert("Image sent successfully!");
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while uploading the image.");
      }
    });
  
  
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }
document.addEventListener("DOMContentLoaded", renderMessages);


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
    document.getElementById('edit-profile').remove();
    vendorGrid.innerHTML = `
                <img src="/public/assets/images/hourglass.gif" alt="hourglass GIF" class="hourglass-gif">
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
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
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
                                    <div class="box-container">
                                        <div class="left">
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
                                        </div>
                                        <div class="right">
                                            <div class="input-group">
                                                <label for="theme">Theme</label>
                                                <input type="text" id="theme" name="theme" value=${data.theme} required>
                                            </div>
                                            <div class="input-group">
                                                <label for="budget">Expected Budget</label>
                                                <input type="number" id="budget" name="budget" value=${data.budget} required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox-group">
                                        <label><input type="checkbox" name="salon" id="sepSalons" ${data.sepSalons ? 'checked' : ''}     > Get the service of separate Salons for bride and groom</label>
                                        <label><input type="checkbox" name="dressdesigner" id="sepDressDesigners" value=${data.sepDressDesigners} > Get the service of separate Dress Makers for bride and groom</label>
                                    </div>
                                    <button type="button" id="nextBtn">Next</button>
                                </section>
    
                                <div class="step" id="bride-details">
                                    <h2>Bride Details</h2>
                                    <div class="box-container">
                                        <div class="left">
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
                                        </div>
                                        <div class="right">
                                            <div class="input-group">
                                                <label for="bride_address">Address</label>
                                                <input type="text" id="bride_address" name="address"  value=${brideData.address} required>
                                            </div>
                                            <div class="input-group">
                                                <label for="bride_age">Age</label>
                                                <input type="number" id="bride_age" name="age"  value=${brideData.age} required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="prevBtn">Previous</button>
                                    <button type="button" id="nextBtn">Next</button>
                                </div>
    
                                <div class="step" id="groom-details">
                                    <h2>Groom Details</h2>
                                    <div class="box-container">
                                        <div class="left">
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
                                        </div>
                                        <div class="right">
                                            <div class="input-group">
                                                <label for="groom_address">Address</label>
                                                <input type="text" id="groom_address" name="address" value=${groomData.address} required>
                                            </div>
                                            <div class="input-group">
                                                <label for="groom_age">Age</label>
                                                <input type="number" id="groom_age" name="age" value=${groomData.age} required>
                                            </div>
                                        </div>
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
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                            "Content-Type": "application/json"
                        },
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
        document.getElementById('delete-profile').remove()
        fetch('/assigned-packages/' + weddingID, {
            method: "GET",
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
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
            assignmentGrid = document.createElement('div');
            assignmentGrid.classList.add("assignment-grid");
            packageData.forEach(package => {

                const packageCard = document.createElement('div');
                packageCard.classList.add('package-card');
                packageCard.innerHTML = `
                    <div class="card">
                    <div class="image-content">
                        <span class="overlay"></span>
                        <div class="card-image">
                            <img src="${package.imgSrc}" alt="" class="card-img">
                        </div>
                    </div>
                    <div class="card-content">
                        <h2 class="name">${package.businessName}</h2>
                        <div class="content">
                            <h4 class="description">${package.typeID}</h4>
                            <h4 class="description">${package.packageName}</h4>
                            <h4 class="description">${package.fixedCost}</h4>
                            <h4 class="description">Wedding Progress: </h4> 
                            <div class="progress-bar-container">
                                <div class="progress-bar wedding-progress-bar" style="width: ${package.progress}%"></div>
                            </div>
                            <h4 class="description">Wedding Budget: </h4> 
                            <div class="progress-bar-container">
                                <div class="progress-bar budget-progress-bar" style="width: ${package.budget}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
        `;;
                assignmentGrid.appendChild(packageCard);
                vendorGrid.appendChild(assignmentGrid);
            })
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
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
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
            if (data.sepSalons) {
                vendorGrid.innerHTML += `
                <div class="package-step current">
                    <div class="package-selector" id="bride-salon-package-selector">
                        <div class="package-selector-information">
                        <img src="/public/assets/images/desk-chair_341178 1.png" alt="picture of a Salon Chair">
                        <p>Choose Bride's Salon Package</p>
                        </div>
                        <div class="reccomendation-grid" id="bride-salon"></div>
                        <div class=step-buttons>
                        <button class="prev-button">Previous</button>
                            <button class="next-button">Next</button>
                        </div>
                    </div>
                </div>
                <div class="package-step">
                    <div class="package-selector" id="groom-salon-package-selector">
                        <div class="package-selector-information">
                        <img src="/public/assets/images/desk-chair_341178 1.png" alt="picture of a Salon Chair">
                        <p>Choose Groom's Salon Package</p>
                        </div>
                        <div class="reccomendation-grid" id="groom-salon"></div>
                        <div class=step-buttons>
                        <button class="prev-button">Previous</button>
                            <button class="next-button">Next</button>
                        </div>
                    </div>
                </div>
                `
            } else {
                vendorGrid.innerHTML += `
                <div class="package-step current">
                    <div class="package-selector" id="salon-package-selector">
                        <div class="package-selector-information">
                        <img src="/public/assets/images/desk-chair_341178 1.png" alt="picture of a Salon Chair">
                        <p>Choose a Salon Package</p>
                        </div>
                        <div class="reccomendation-grid" id="salon"></div>
                        <div class=step-buttons>
                        <button class="prev-button">Previous</button>
                            <button class="next-button">Next</button>
                        </div>
                    </div>
                </div>
                `
            }
            vendorGrid.innerHTML += `
            <div class="package-step">
                <div class="package-selector" id="photographer-package-selector">
                    <div class="package-selector-information">
                    <img src="/public/assets/images/camera_1361782 1.png" alt="picture of a Camera">
                    <p>Choose a photography Package</p>
                    </div>
                    <div class="reccomendation-grid" id="photographer"></div>
                    <div class=step-buttons>
                    <button class="prev-button">Previous</button>
                        <button class="next-button">Next</button>
                    </div>
                </div>
            </div>
            `;
            if (data.sepDressDesigners) {
                vendorGrid.innerHTML += `
                    <div class="package-step">
                        <div class="package-selector" id="bride-dress-designer-package-selector">
                            <div class="package-selector-information">
                            <img src="/public/assets/images/dress_14383759 1.png" alt="picture of a Dress">
                            <p>Choose a Bride's Dress Designer Package</p>
                            </div>
                            <div class="reccomendation-grid" id="bride-dress-designer"></div>
                            <div class=step-buttons>
                            <button class="prev-button">Previous</button>
                                <button class="next-button">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="package-step">
                        <div class="package-selector" id="groom-dress-desginer-package-selector">
                            <div class="package-selector-information">
                            <img src="/public/assets/images/dress_14383759 1.png" alt="picture of a Dress">
                            <p>Choose a Grroom's Dress Designer Package</p>
                            </div>
                            <div class="reccomendation-grid" id="groom-dress-designer"></div>
                            <div class=step-buttons>
                            <button class="prev-button">Previous</button>
                                <button class="next-button">Next</button>
                            </div>
                        </div>
                    </div>
                    `
            } else {
                vendorGrid.innerHTML += `
                    <div class="package-step">
                        <div class="package-selector" id="dress-designer-package-selector">
                            <div class="package-selector-information">
                            <img src="/public/assets/images/dress_14383759 1.png" alt="picture of a Dress">
                            <p>Choose Dress Designer Package</p>
                            </div>
                            <div class="reccomendation-grid" id="dress-designer"></div>
                            <div class=step-buttons>
                            <button class="prev-button">Previous</button>
                                <button class="next-button">Next</button>
                            </div>
                        </div>
                    </div>
                    `;
            }
            vendorGrid.innerHTML += `
                <div class="package-step">
                    <div class="package-selector" id="florist-package-selector">
                        <div class="package-selector-information">
                        <img src="/public/assets/images/nature_10601927 1.png" alt="picture of a Flower">
                        <p>Choose Florist Package</p>
                        </div>
                        <div class="reccomendation-grid" id="florist"></div>
                        <div class=step-buttons>
                        <button class="prev-button">Previous</button>
                        <button class="submit-button">Submit</button>
                        </div>
                    </div>
                </div>`
            vendorGrid.querySelector('.package-selector').querySelector('.prev-button').remove();
            vendorGrid.querySelectorAll('.prev-button').forEach(prevButton => {
                prevButton.addEventListener('click', (event) => {
                    currentStepCounter--;
                    const currentStep = vendorGrid.querySelector('.package-step.current');
                    const prevStep = currentStep.previousElementSibling;
                    currentStep.classList.remove('current');
                    prevStep.classList.add('current');
                })
            })
            vendorGrid.querySelectorAll('.next-button').forEach(btn => {
                btn.addEventListener('click', (event) => {
                    const currentStep = vendorGrid.querySelector('.package-step.current');
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
                if (Object.keys(selectedPackages).length === currentStepCounter + 1) {
                    const packages = Object.values(selectedPackages);
                    fetch('/assign-packages/' + weddingID, {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                            "Content-type": "application/json"
                        },
                        body: JSON.stringify(selectedPackages)
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
                } else {
                    console.log(currentStepCounter)
                    alert("Please select a package for all vendor types");
                }
            })

            vendorGrid.querySelectorAll('.package-selector').forEach(packagesDiv => {
                recGrid = packagesDiv.querySelector(".reccomendation-grid");
                console.log(recGrid.id)
                response[recGrid.id].forEach(package => {
                    const packageDiv = document.createElement('div');

                    const totalImages = 15;

                    function getRandomImage() {
                        const randomIndex = Math.floor(Math.random() * totalImages) + 1;

                        const imagePath = `/public/images/CustomerWeddingDashboard/img${randomIndex}.jpg`;

                        const imageElement = document.querySelector('.card-img');
                        imageElement.src = imagePath;
                    }


                    packageDiv.classList.add('package');
                    packageDiv.setAttribute("id", package.packageID);
                    packageDiv.innerHTML += `
                        <div class="image-content">
                            <span class="overlay"></span>
                        </div>
                        <div class="card-content">
                            <h2 class="name">${package.packageName}</h2>
                            <div class="content">
                                <h3 class="description">What is included:</h2>
                                <ul>
                                    <li class="description">${package.feature1}</li>
                                    ${package.feature2 ? `<li class="description">${package.feature2}</li>` : ''}
                                    ${package.feature3 ? `<li class="description">${package.feature3}</li>` : ''}
                                </ul>
                                <h4 class="description price">Charge: ${package.fixedCost}</h4>
                                <a class="visit">View Vendor Profile</a>
                            </div>
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

const finished = (data) => {
    try {
        fetch('/assigned-packages/' + weddingID, {
            method: "GET",
            headers: {
                "Content-type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
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

            packageData.forEach(cardData => {

                const packageCard = document.createElement('div');
                packageCard.classList.add('package-card');
                packageCard.innerHTML = `
                    <div class="card">
                    <div class="image-content">
                        <span class="overlay"></span>
                        <div class="card-image">
                            <img src="${cardData.imgSrc}" alt="" class="card-img">
                        </div>
                    </div>
                    <div class="card-content">
                        <h2 class="name">${cardData.businessName}</h2>
                        <div class="content">
                            <h4 class="description">Wedding Progress: </h4> 
                            <div class="progress-bar-container">
                                <div class="progress-bar wedding-progress-bar" style="width: ${cardData.progress}%"></div>
                            </div>
                            <h4 class="description">Wedding Budget: </h4> 
                            <div class="progress-bar-container">
                                <div class="progress-bar budget-progress-bar" style="width: ${cardData.budget}%"></div>
                            </div>
                            <div class="stars">
                            ${Array(5).fill(0).map((_, i) => `
                                <span class="star" data-value="${i + 1}">&#9734;</span>
                            `).join('')}
                        </div>
                        </div>
                    </div>
                </div>
        `;
                const stars = packageCard.querySelectorAll('.star');
                stars.forEach(star => {
                    star.addEventListener('mouseover', () => {
                        const siblings = Array.from(star.parentElement.children);
                        const index = siblings.indexOf(star);
                        siblings.forEach(sibling => {
                            if (sibling.dataset.value <= index + 1) {
                                sibling.classList.add('selected');
                            } else {
                                sibling.classList.remove('selected');
                            }
                        });
                    });
                    star.addEventListener('click', () => {
                        const value = Number(star.dataset.value);
                        fetch('/api/ratings', {
                            method: 'POST',
                            headers: {
                                'Content-type': 'application/json',
                                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                            },
                            body: JSON.stringify({
                                vendorID: cardData.vendorID,
                                rating: value,
                            }),
                        })
                            .then(response => {
                                if (!response.ok) {
                                    alert('Error submitting rating');
                                }
                            });
                    });
                });
                vendorGrid.appendChild(packageCard);
            })
        })
    } catch (e) {
        console.error(e);
    }
}



function render() {
    const loadingScreen = document.getElementById("loading-screen");
    const mainContent = document.getElementById("main-content");

    const deleteProfile = document.querySelector('.delete-profile');
    const editProfile = document.querySelector('.edit-profile');
    const modalContainer = document.querySelector('.modal-container');
    const editModalContainer = document.querySelector('#edit-modal-container');
    const closeButton = editModalContainer.querySelector('.close-button');
    const prevButton = editModalContainer.querySelector('.prev-button');
    const nextButton = editModalContainer.querySelector('.next-button');
    const submitButton = editModalContainer.querySelector('.submit-button');
    const modalPages = editModalContainer.querySelectorAll('.modal-page');
    const paginationDots = editModalContainer.querySelectorAll('.dot');
    const cancelButton = document.querySelector('.cancel-button');
    const deleteButton = document.querySelector('.delete-button');
    const logoutbutton = document.getElementById('log-out');

    logoutbutton.addEventListener('click', () => {
        localStorage.removeItem('authToken');
        window.location.href = "/signin";
    })
    try {
        fetch('/wedding/data/' + weddingID, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/signin';
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        }).then(data => {
            weddingTitle.innerHTML = data.weddingTitle;
            const targetDate = new Date(data.date);
            const today = new Date();
            const differenceInTime = targetDate - today;
            const remainingDays = Math.ceil(differenceInTime / (1000 * 60 * 60 * 24));
            document.getElementById("days-left").innerHTML = remainingDays > 0 ? `${remainingDays} days left` : "Happy wedded life!";
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

    let currentPage = 1;
    const totalPages = modalPages.length;

    // event listener for delete wedding
    function deleteWedding() {
        fetch('/wedding/delete-wedding/' + weddingID, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (response.status == 409) {
                showNotification("The wedding is still ongoing can't delete", "red");
                closeEditModal();
                return;
            } else if (response.status == 203) {
                window.location.href = '/signin';
            }
            alert("Vendor Deleted sucesssfully");

            console.log(data);
            window.location.href = '/register';
            return response.json();
        }).then(data => {

        }).catch(error => {
            console.error(error);
        });
    }

    // Delete modal functionality
    if (deleteProfile && modalContainer) {
        deleteProfile.addEventListener('click', () => {
            console.log("Delete button clicked");
            modalContainer.classList.add('show');
        });

        cancelButton.addEventListener('click', closeEditModal);

        deleteButton.addEventListener('click', () => {
            deleteWedding();
            console.log('Profile deleted');
            modalContainer.classList.remove('show');
        });

        modalContainer.addEventListener('click', (event) => {
            if (event.target === modalContainer) {
                modalContainer.classList.remove('show');
            }
        });
    }

    // Edit modal functionality
    function updateModalPage() {
        modalPages.forEach(page => {
            page.classList.remove('active');
            if (parseInt(page.dataset.page) === currentPage) {
                page.classList.add('active');
            }
        });

        paginationDots.forEach(dot => {
            dot.classList.remove('active');
            if (parseInt(dot.dataset.page) === currentPage) {
                dot.classList.add('active');
            }
        });

        prevButton.disabled = currentPage === 1;
        if (currentPage === totalPages) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }
    }

    if (editProfile && editModalContainer) {
        editProfile.addEventListener('click', openEditModal);

        closeButton.addEventListener('click', closeEditModal);

        editModalContainer.addEventListener('click', (event) => {
            if (event.target === editModalContainer) {
                closeEditModal();
            }
        });

        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updateModalPage();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateModalPage();
            }
        });

        paginationDots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentPage = parseInt(dot.dataset.page);
                updateModalPage();
            });
        });

        submitButton.addEventListener('click', (e) => {
            e.preventDefault();
            // Collect form data
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                businessName: document.getElementById('businessName').value,
                businessType: document.getElementById('businessType').value,
                location: document.getElementById('location').value,
                description: document.getElementById('description').value,
                experience: document.getElementById('experience').value,
                website: document.getElementById('website').value
            };

            console.log('Form submitted:', formData);
            // Add your form submission logic here

            editModalContainer.classList.remove('show');
        });
    }

    // Close modals with Escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (modalContainer.classList.contains('show')) {
                modalContainer.classList.remove('show');
            }
            if (editModalContainer.classList.contains('show')) {
                editModalContainer.classList.remove('show');
            }
        }
    });

    function closeEditModal() {
        editModalContainer.classList.remove('show');
    }


    // edit modal retreive from the backend
    function openEditModal() {
        editModalContainer.classList.add('show');
        currentPage = 1;
        updateModalPage();

        fetch('/wedding/data/' + weddingID, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
            },
        }).then(response => {

            return response.json();
        }).then(weddingData => {
            let changedFields = {};
            document.querySelectorAll('.form-input').forEach(input => {
                input.value = weddingData[input.id];
                input.addEventListener('change', () => {
                    changedFields[input.id] = input.value;
                })
            })
            document.querySelector('.submit-button').addEventListener('click', () => {
                console.log(changedFields);
                if (Object.keys(changedFields).length > 0) {
                    fetch('/update-wedding/' + weddingID, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(changedFields)
                    }).then(response => {
                        return response.json();
                    }).then(data => {
                        Object.keys(changedFields).forEach((column) => {
                            weddingData[column] = changedFields[column];
                        });
                        closeEditModal();
                    }).catch(error => {
                        console.error(error);
                    });
                }
            })




        })
    }
}

document.addEventListener('DOMContentLoaded', render);

