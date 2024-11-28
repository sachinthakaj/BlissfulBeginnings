
const path = window.location.pathname;
const pathParts = path.split('/');
const weddingID = pathParts[pathParts.length - 1];

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
  const mainContent = document.getElementById("main-content");
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
      cardContainer.innerHTML += `<div class="card" id="bride-salon ">
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
    const totalBudgetElement = document.querySelector('.budget-info span');
    const updateTotalBudget = () => {
      const totalBudget = Array.from(vendorBudgets).reduce((total, input) => total + Number(input.value), 0);
      totalBudgetElement.textContent = totalBudget;
      if (totalBudget > data.budget) {
        totalBudgetElement.style.color = "red";
      } else {
        totalBudgetElement.style.color = "";
      }
    }
    vendorBudgets.forEach(input => {
      input.addEventListener('input', updateTotalBudget);
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
        fetch('/wedding/' + weddingID + '/get-packages/' + assignmentType, {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            allocatedBudget
          }),
        }).then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          if (response.status == 204) {
            showNotification("No packages available for this budget", "red");
            return;
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
                    <input type="text" placeholder="Search" class="search-input" />
                </div>
              <div class="package-grid">
                <!-- Vendor information will be populated here -->
              </div>
              <button class="submit-button">Reccomend Packages</button>
            
          `;

          const packageGrid = modalContent.querySelector('.package-grid');

          data.forEach(package => {
            const packageCard = document.createElement('div');
            packageCard.classList.add('package-card');
            packageCard.id = package.packageID;
            packageCard.innerHTML = `
              <h3>${package.packageName}</h3>
              <h2>${package.businessName}</h2>
              <p>${package.feature1}</p>
              <p>${package.feature2}</p>
              <p>${package.feature3}</p>

            `;
            if (selectedPackages[assignmentType].includes(packageCard.id)) {
              packageCard.classList.add('selected');
            }
            packageCard.addEventListener('click', () => {
              if (selectedPackages[assignmentType].includes(packageCard.id)) {
                packageCard.classList.remove('selected');
                selectedPackages[assignmentType] = selectedPackages[assignmentType].filter(id => id !== packageCard.id);
                console.log(selectedPackages);
              } else {
                packageCard.classList.add('selected');
                selectedPackages[assignmentType].push(packageCard.id);
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
              document.body.removeChild(modal);
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
