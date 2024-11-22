
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

document.addEventListener("DOMContentLoaded", function () {

  const loadingScreen = document.getElementById("loading-screen");
  const mainContent = document.getElementById("main-content");
  fetch('/wedding/data/' + weddingID, {
    method: 'GET',
    headers: {
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
    const cardContainer = document.getElementById('card-container');
    if (data.sepSalons) {
      cardContainer.innerHTML += `<div class="card" id="BrideSalons">
                                  <h1>Bride's Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <label for="BrideSalons-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="BrideSalons-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>
                                  <div class="card" id="GroomSalons">
                                  <h1>Groom's Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <label for="GroomSalons-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="GroomSalons-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>`
    } else {
      cardContainer.innerHTML += `<div class="card" id="Salons">
                                  <h1>Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <label for="Salons-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="Salons-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>`
    }
    cardContainer.innerHTML += `<div class="card" id="Photographers">
                                  <h1>Photographer</h1>
                                  <img src="/public/assets/images/camera_1361782 1.png" alt="Photographer" />
                                  <label for="Photographers-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="Photographers-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>`
    if (data.sepDressDesigners) {
      cardContainer.innerHTML += `<div class="card" id="BrideDressDesigner">
                                  <h1>Bride's Salon</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <label for="BrideDressDesigner-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="BrideDressDesigner-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>
                                  <div class="card" id="GroomDressDesigner">
                                  <h1>Groom's Salon</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <label for="GroomDressDesigner-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="GroomDressDesigner-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>`
    } else {
      cardContainer.innerHTML += `<div class="card" id="DressDesigners">
                                  <h1>Salon</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <label for="DressDesigners-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="DressDesigners-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>`
    }
    cardContainer.innerHTML += `<div class="card" id="Florists">
                                  <h1>Florist</h1>
                                  <img src="/public/assets/images/nature_10601927 1.png" alt="Picture of an flower" />
                                  <label for="Florists-allocatedBudget">Allocated Budget</label>
                                  <input type="number" id="Florists-allocatedBudget" class="vendor-budget" />
                                  <button class="card-button">
                                  </button>
                                  </div>`
    document.querySelectorAll('.card-button').forEach(vendorType => {
      vendorType.addEventListener('click', (event) => {
        const vendorType = event.target.parentNode.id;
        const allocatedBudget = event.target.parentNode.querySelector('input').value;
        fetch('/wedding' + weddingID +'/vendor/' + vendorType, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            allocatedBudget
          }),
        }).then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        }).then(data => {
          const modal = document.createElement('div');
          modal.classList.add('modal');
          modal.innerHTML = `
            <div class="modal-content">
              <span class="close-button">&times;</span>
              <h2>${vendorType} Vendors</h2>
              <div class="package-grid">
                <!-- Vendor information will be populated here -->
              </div>
            </div>
          `;

          const packageGrid = modal.querySelector('.pacage-grid');

          data.forEach(package => {
            const packageCard = document.createElement('div');
            packageCard.classList.add('package-card');
            packageCard.innerHTML = `
              <h3>${package.packageName}</h3>
              <h2>${package.vendorName}</h2>
              <p>${package.feature1}</p>
              <p>${package.feature2}</p>
              <p>${package.feature3}</p>

            `;
            packageGrid.appendChild(packageCard);
          })
          
          document.body.appendChild(modal);

          const closeButton = modal.querySelector('.close-button');
          closeButton.addEventListener('click', () => {
            document.body.removeChild(modal);
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

    loadingScreen.style.display = 'none';
    mainContent.style.display = 'block';

  }).catch(error => {
    console.error('Error fetching data early:', error)
    loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
  });
})
