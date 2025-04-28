
const path = window.location.pathname;
const pathParts = path.split('/');
const weddingID = pathParts[pathParts.length - 1];

function renderMessages() {
  const chatContainer = document.querySelector(".chat-show-area");
  chatContainer.innerHTML = "";

  const wsUrl = "ws://localhost:8080/";

  const socket = new WebSocket(wsUrl);
  const messageInput = document.getElementById("chat-type-field");
  const sendBtn = document.getElementById("send-button");

  socket.onopen = () => {
    socket.send(
      JSON.stringify({
        weddingID: weddingID,
      })
    );
  };

  socket.onmessage = (event) => {
    const messages = JSON.parse(event.data);
    console.log(messages);
    messages.forEach((message) => {
      sender = message.role === "planner" ? "me" : message.role;
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
  };

  socket.onerror = (error) => {
    console.error("WebSocket error:", error);
    chatContainer.innerHTML = "<p>Unexpected error occured</p>";
  };

  socket.onclose = () => {
    console.log("WebSocket connection closed.");
  };

  function appendTextMessage(message, timestamp, sender) {
    const messageElement = document.createElement("div");
    messageElement.classList.add("message");
    messageElement.innerHTML =
      `<div class="sender ${sender}">` +
      sender +
      ": </div><p class=message-text>" +
      message +
      "</p>";
    messageElement.dataset.timestamp = timestamp;
    chatContainer.appendChild(messageElement);
  }
  function appendImageMessage(imageReference, timestamp, sender) {
    const imageElement = document.createElement("div");
    imageElement.classList.add("message", "image");
    imageElement.dataset.timestamp = timestamp;
    imageElement.style.display = "flex";
    imageElement.style.flexDirection = "column";

    const senderElement = document.createElement("div");
    senderElement.classList.add("sender", sender);
    senderElement.innerHTML = '<h4">' + sender + "</h4>";
    imageElement.appendChild(senderElement);
    const img = document.createElement('img');
    img.src = "http://cdn.blissfulbeginnings.com" + imageReference;
    img.alt = "Uploaded Image";
    img.classList.add('chat-image');

    imageElement.appendChild(img);
    chatContainer.appendChild(imageElement);
  }

  sendBtn.addEventListener("click", () => {
    timestamp = new Date().toISOString();
    timestamp = timestamp.replace("T", " ").split(".")[0];
    const message = messageInput.value.trim();
    if (message) {
      chatMessage = {
        sender: "planner",
        message: message,
        timestamp: timestamp,
      };
      socket.send(JSON.stringify(chatMessage));
      console.log(chatMessage);
      appendTextMessage(message, timestamp, "me");
      messageInput.value = "";
    }
  });

  messageInput.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
      sendBtn.click();
    }
  });

  document
    .getElementById("imageUpload")
    .addEventListener("change", async function (event) {
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

      const metaWithImage = {
        timestamp: formData.timestamp,
        role: "planner",
        relativePath: imageReference,
        Image: "image_reference",
      };

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
          throw new Error(
            "Invalid response from server. No storage path provided."
          );
        }

        const imageReference = data.storagePath;

        const metaWithImage = {
          timestamp: formData.timestamp,
          sender: "planner",
          imageReference: imageReference,
          Image: "image_reference",
        };

        socket.send(JSON.stringify(metaWithImage));

        appendImageMessage(
          imageReference,
          metaWithImage.timestamp,
          metaWithImage.sender
        );
        alert("Image sent successfully!");
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while uploading the image.");
      }
    });

  chatContainer.scrollTop = chatContainer.scrollHeight;
}

document.addEventListener("DOMContentLoaded", renderMessages);


function createPackageCard(packageData) {
  // Create main container
  const cardElement = document.createElement('div');
  cardElement.className = 'wed-package-card';
  cardElement.id = `${packageData.packageID}`;
  cardElement.dataset.packageId = packageData.packageID; // Add data attribute for easy selection
  
  // Create package header
  const headerElement = document.createElement('div');
  headerElement.className = 'wed-package-header';
  
  const nameElement = document.createElement('h3');
  nameElement.className = 'wed-package-name';
  nameElement.textContent = packageData.packageName;
  headerElement.appendChild(nameElement);
  
  
  // Create business section
  const businessElement = document.createElement('div');
  businessElement.className = 'wed-package-business';
  
  const iconElement = document.createElement('img');
  iconElement.className = 'wed-package-icon';
  iconElement.src = "http://cdn.blissfulbeginnings.com/" + packageData.path;
  iconElement.alt = `${packageData.businessName} Icon`;
  businessElement.appendChild(iconElement);
  
  // Create features list
  const featuresElement = document.createElement('ul');
  featuresElement.className = 'wed-package-features';
  
  // Add feature1 (required)
  if (packageData.feature1) {
      const featureItem = document.createElement('li');
      featureItem.className = 'wed-package-feature-item';
      featureItem.textContent = packageData.feature1;
      featuresElement.appendChild(featureItem);
  }
  
  // Add feature2 (optional)
  if (packageData.feature2) {
      const featureItem = document.createElement('li');
      featureItem.className = 'wed-package-feature-item';
      featureItem.textContent = packageData.feature2;
      featuresElement.appendChild(featureItem);
  }
  
  // Add feature3 (optional)
  if (packageData.feature3) {
      const featureItem = document.createElement('li');
      featureItem.className = 'wed-package-feature-item';
      featureItem.textContent = packageData.feature3;
      featuresElement.appendChild(featureItem);
  }
  
  // Create cost section
  const costElement = document.createElement('div');
  costElement.className = 'wed-package-cost';
  
  const priceElement = document.createElement('p');
  priceElement.className = 'wed-package-price';
  
  // Format price in LKR
  const price = typeof packageData.fixedCost === 'number' 
      ? `LKR ${packageData.fixedCost.toLocaleString()}` 
      : `LKR ${packageData.fixedCost}`;
      
  priceElement.dataset.price = packageData.fixedCost;
  priceElement.textContent = price;
  costElement.appendChild(priceElement);
  
  const labelElement = document.createElement('p');
  labelElement.className = 'wed-package-label';
  labelElement.textContent = 'Fixed Package Price';
  costElement.appendChild(labelElement);
  
  // Assemble the card
  cardElement.appendChild(headerElement);
  cardElement.appendChild(businessElement);
  cardElement.appendChild(featuresElement);
  cardElement.appendChild(costElement);
  
  return cardElement;
}


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

let selectedPackages = {};

document.addEventListener("DOMContentLoaded", function () {

  const loadingScreen = document.getElementById("loading-screen");
  const mainContent = document.getElementById(".content-wrapper");
  fetch('/wedding/data/' + weddingID, {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
      'Content-Type': 'application/json'
    },
  }).then(response => {
    if (!response.ok) {
      if (response.status === 401) {
        alert("Not registered");
        window.location.href = '/signin';
      } else {
        throw new Error('Network response was not ok');
      }
    }
    return response.json();
  }).then(data => {
    document.querySelector('.wedding-title').textContent = data.weddingTitle + "'s Wedding";
    const cardContainer = document.getElementById('card-container');
    if (data.sepSalons) {
      cardContainer.innerHTML += `<div class="card" id="bride-salon">
                                  <h1>Bride's Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <div class="budget-info">
                                    <label for="bride-salons-budget">Allocated Budget</label>
                                    <input type="number" id="bride-salons-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>
                                  <div class="card" id="groom-salon">
                                  <h1>Groom's Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <div class="budget-info">
                                    <label for="groom-salons-budget">Allocated Budget</label>
                                    <input type="number" id="groom-salons-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    } else {
      cardContainer.innerHTML += `<div class="card" id="salon">
                                  <h1>Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <div class="budget-info">
                                    <label for="salons-budget">Allocated Budget</label>
                                    <input type="number" id="salons-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    }
    cardContainer.innerHTML += `<div class="card" id="photographer">
                                  <h1>Photographer</h1>
                                  <img src="/public/assets/images/camera_1361782 1.png" alt="Photographer" />
                                  <div class="budget-info">
                                    <label for="photographers-budget">Allocated Budget</label>
                                    <input type="number" id="photographers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    if (data.sepDressDesigners) {
      cardContainer.innerHTML += `<div class="card" id="bride-dress-designer">
                                  <h1>Bride's Dress Designer</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <div class="budget-info">
                                    <label for="bride-dress-designers-budget">Allocated Budget</label>
                                    <input type="number" id="bride-dress-designers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>
                                  <div class="card" id="groom-dress-designer">
                                  <h1>Groom's Dress Designer</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <div class="budget-info">
                                    <label for="groom-dress-designers-budget">Allocated Budget</label>
                                    <input type="number" id="groom-dress-designers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    } else {
      cardContainer.innerHTML += `<div class="card" id="dress-designer">
                                  <h1>Dress Designer</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <div class="budget-info">
                                    <label for="dress-designers-budget">Allocated Budget</label>
                                    <input type="number" id="dress-designers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    }
    cardContainer.innerHTML += `<div class="card" id="florist">
                                  <h1>Florist</h1>
                                  <img src="/public/assets/images/nature_10601927 1.png" alt="Picture of an flower" />
                                  <div class="budget-info">
                                    <label for="florists-budget">Allocated Budget</label>
                                    <input type="number" id="florists-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`

    const vendorBudgets = document.querySelectorAll('.vendor-budget');
    const totalBudgetElement = document.querySelector('#total-budget');
    const updateTotalBudget = () => {
      const totalBudget = Array.from(vendorBudgets).reduce((total, input) => total + Number(input.value), 0);
      totalBudgetElement.textContent = totalBudget;
      if (data.budgetMax != 0 && totalBudget > data.budgetMax) {
        totalBudgetElement.style.color = "red";
      } else {
        totalBudgetElement.style.color = "";
      }
    }

    const budgetMin = document.querySelector('#min-budget');
    const budgetMax = document.querySelector('#max-budget');

    budgetMin.textContent = data.budgetMin;
    if (data.budgetMax == 0) {
      budgetMax.textContent = '-';
    } else {
      budgetMax.textContent = data.budgetMax;
    }

    weddingPartyMale = document.querySelector('#wedding-group-male');
    weddingPartyFemale = document.querySelector('#wedding-group-female');


    if (data.weddingPartyMale) {
      weddingPartyMale.value = data.weddingPartyMale;
      weddingPartyMale.disabled = true;
    } else {
      weddingPartyMale.value = 3;
    }

    if (data.weddingPartyFemale) {
      weddingPartyFemale.value = data.weddingPartyFemale;
      weddingPartyFemale.disabled = true;
    } else {
      weddingPartyFemale.value = 3;
    }

    const weddingDate = document.querySelector('#wedding-date');
    weddingDate.textContent = data.date;

    const ceremonyTime = document.querySelector('#ceremony-time');
    ceremonyTime.textContent = data.dayNight;

    const remainingBudgetElement = document.querySelector('#remaining-budget');
    const updateRemainingBudget = () => {
      const remainingBudget = data.budgetMax - totalBudgetElement.textContent;
      remainingBudgetElement.textContent = remainingBudget;
      if (remainingBudget < 0) {
        remainingBudgetElement.style.color = "red";
      } else {
        remainingBudgetElement.style.color = "";
      }
    }

    vendorBudgets.forEach(input => {
      input.addEventListener('input', updateTotalBudget);
      input.addEventListener('input', updateRemainingBudget);
    });
    updateTotalBudget();
    document.querySelectorAll('.card').forEach(card => {
      selectedPackages[card.id] = [];
    })

    document.querySelectorAll('.card-button').forEach(vendorType => {
      vendorType.addEventListener('click', (event) => {
        const assignmentType = event.target.parentNode.id;
        const allocatedBudget = event.target.parentNode.querySelector('input').value;
        if (!allocatedBudget) {
          showNotification("Please enter allocated budget", "red");
          return;
        }
        const numMaleGroup = document.querySelector('#wedding-group-male').value;
        const numFemaleGroup = document.querySelector('#wedding-group-female').value;
        const weddingDate = document.querySelector('#wedding-date').textContent;

        console.log(allocatedBudget, numMaleGroup, numFemaleGroup, weddingDate);

        fetch('/wedding/' + weddingID + '/get-packages/' + assignmentType, {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            allocatedBudget,
            numMaleGroup,
            numFemaleGroup,
            weddingDate
          }),
        }).then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          if (response.status == 204) {
            showNotification("No packages available for this budget", "red");
            return;
          } else if (response.status == 401) {
            window.href='/signin';  
          }
          return response.json();
        }).then(data => {
          if (!data) {
            return;
          }
          const modal = document.getElementById('modal');
          const modalContent = document.getElementById('modal-content');
          modalContent.classList.add('modal-content');
          modalContent.innerHTML = `
              <span class="close-button">&times;</span>
              <h2>${vendorType.parentNode.id} Packages</h2>
              <div class="search-container">
                    <input type="text" placeholder="Search" class="search-input" id="search-reccs" />
                </div>
                <div class="package-grid-container">
              <div class="package-grid">
              </div>
                <!-- Vendor information will be populated here -->
              </div>
              <button class="submit-button">Reccomend Packages</button>
            
          `;
          modalContent.querySelector('#search-reccs').addEventListener('input', (event) => {
            const query = event.target.value.trim().toLowerCase();
            const filtered = data.filter(package => package.packageName.toLowerCase().includes(query) || package.businessName.toLowerCase().includes(query) ||
              package.feature1.toLowerCase().includes(query) || package.feature2.toLowerCase().includes(query) || package.feature3.toLowerCase().includes(query));
            packageGrid.innerHTML = '';
            filtered.forEach(package => {
              const packageCard = createPackageCard(package);
              if (selectedPackages[assignmentType].some(sPackage => sPackage.id === packageCard.id)) {
                packageCard.classList.add('selected');
              }
              packageCard.addEventListener('click', () => {
                if (selectedPackages[assignmentType].some(sPackage => sPackage.id === packageCard.id)) {
                  packageCard.classList.remove('selected');
                  selectedPackages[assignmentType] = selectedPackages[assignmentType].filter(sPackage => sPackage.id !== packageCard.id);
                  console.log(selectedPackages);
                } else {
                  packageCard.classList.add('selected');
                  selectedPackages[assignmentType].push({
                    id: packageCard.id,
                    price: packageCard.querySelector('#total-price').textContent
                  });
                  console.log(selectedPackages);
                }
              })
              packageGrid.appendChild(packageCard);
            })
          })

          const packageGrid = modalContent.querySelector('.package-grid');

          data.forEach(package => {
            const packageCard = createPackageCard(package)
            if (selectedPackages[assignmentType].includes(packageCard.id)) {
              packageCard.classList.add('selected');
            }
            packageCard.addEventListener('click', () => {
              if (selectedPackages[assignmentType].some(package => package.id === packageCard.id)) {
                packageCard.classList.remove('selected');
                selectedPackages[assignmentType] = selectedPackages[assignmentType].filter(package => package.id !== packageCard.id);
                console.log(selectedPackages);
              } else {
                packageCard.classList.add('selected');
                selectedPackages[assignmentType].push({
                  id: packageCard.id,
                  price: packageCard.querySelector('.wed-package-price').dataset.price  
                });
                console.log(selectedPackages);
              }
            })
            packageGrid.appendChild(packageCard);
          })

          modalContent.querySelector('.submit-button').addEventListener('click', () => {
            modal.style.display = 'none';
          })

          modal.style.display = 'block';

          const closeButton = modalContent.querySelector('.close-button');
          closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
          });

          modal.addEventListener('click', (e) => {
            if (e.target === modal) {
              modal.querySelector('.modal-content').innerHTML = '';
              modal.style.display = 'none';
            }
          });

        }).catch(error => {
          console.error('Error fetching vendor data:', error);
          showNotification("Error loading vendor data. Please try again later.", 'red');
        });
      });
    });
    document.getElementById('proceed-button').addEventListener('click', () => {
      const allVendorsSelected = Object.keys(selectedPackages).every(vendorType => selectedPackages[vendorType].length > 0);

      if (!allVendorsSelected) {
        showNotification("Please select packages for every vendor-type", "red");
        return;
      }

      fetch('/wedding/' + weddingID + '/submit-selected-packages', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(selectedPackages),
      }).then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }else if (response.status == 401) {
          window.location.href = '/signin';
        }
        window.location.href = '/wedding/' + weddingID;
      }).catch(error => {
        console.error('Error submitting packages:', error);
        showNotification("Error submitting packages. Please try again later.", 'red');
      });
    });
    loadingScreen.style.display = 'none';
    mainContent.style.display = 'block';

  }).catch(error => {
    console.error('Error fetching data early:', error)
    loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
  });
})
