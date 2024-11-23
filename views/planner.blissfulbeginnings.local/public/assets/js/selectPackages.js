
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
      cardContainer.innerHTML += `<div class="card" id="bride-salons">
                                  <h1>Bride's Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <div class="budget-info">
                                    <label for="bride-salons-budget">Allocated Budget</label>
                                    <input type="number" id="bride-salons-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>
                                  <div class="card" id="groom-salons">
                                  <h1>Groom's Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <div class="budget-info">
                                    <label for="groom-salons-budget">Allocated Budget</label>
                                    <input type="number" id="groom-salons-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    } else {
      cardContainer.innerHTML += `<div class="card" id="salons">
                                  <h1>Salon</h1>
                                  <img src="/public/assets/images/desk-chair_341178 1.png" alt="Salon" />
                                  <div class="budget-info">
                                    <label for="salons-budget">Allocated Budget</label>
                                    <input type="number" id="salons-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    }
    cardContainer.innerHTML += `<div class="card" id="photographers">
                                  <h1>Photographer</h1>
                                  <img src="/public/assets/images/camera_1361782 1.png" alt="Photographer" />
                                  <div class="budget-info">
                                    <label for="photographers-budget">Allocated Budget</label>
                                    <input type="number" id="photographers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    if (data.sepDressDesigners) {
      cardContainer.innerHTML += `<div class="card" id="bride-dress-designers">
                                  <h1>Bride's Salon</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <div class="budget-info">
                                    <label for="bride-dress-designers-budget">Allocated Budget</label>
                                    <input type="number" id="bride-dress-designers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>
                                  <div class="card" id="groom-dress-designers">
                                  <h1>Groom's Salon</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <div class="budget-info">
                                    <label for="groom-dress-designers-budget">Allocated Budget</label>
                                    <input type="number" id="groom-dress-designers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    } else {
      cardContainer.innerHTML += `<div class="card" id="dress-designers">
                                  <h1>Salon</h1>
                                  <img src="/public/assets/images/dress_14383759 1.png" alt="Picture of a dress" />
                                  <div class="budget-info">
                                    <label for="dress-designers-budget">Allocated Budget</label>
                                    <input type="number" id="dress-designers-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    }
    cardContainer.innerHTML += `<div class="card" id="florists">
                                  <h1>Florist</h1>
                                  <img src="/public/assets/images/nature_10601927 1.png" alt="Picture of an flower" />
                                  <div class="budget-info">
                                    <label for="florists-budget">Allocated Budget</label>
                                    <input type="number" id="florists-budget" class="vendor-budget" />
                                  </div>
                                  <button class="card-button">Allocate Packages</button>
                                  </div>`
    const vendorBudgetInputs = document.querySelectorAll('.vendor-budget');
    const budgetSumIndicator = document.createElement('p');
    budgetSumIndicator.classList.add('budget-sum-indicator');
    cardContainer.parentNode.appendChild(budgetSumIndicator);

    vendorBudgetInputs.forEach(input => input.addEventListener('input', () => {
      const totalAllocatedBudget = Array.from(vendorBudgetInputs).reduce((sum, input) => sum + Number(input.value), 0);
      if (totalAllocatedBudget > data.budget) {
        budgetSumIndicator.style.color = 'red';
        budgetSumIndicator.textContent = `Total allocated budget is ${totalAllocatedBudget} which is greater than the total budget of ${data.budget}`;
      } else {
        budgetSumIndicator.textContent = '';
      }
    }));

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
          const modal = document.getElementById('modal');
          const modalContent = document.getElementById('modal-content');
          modalContent.classList.add('modal-content');
          modalContent.innerHTML = `
              <span class="close-button">&times;</span>
              <h2>${vendorType} Packages</h2>
              <div class="package-grid">
                <!-- Vendor information will be populated here -->
              </div>
              <button class="submit-button">Submit</button>
            
          `;

          const packageGrid = modalContent.querySelector('.package-grid');

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

          modal.style.display = 'block';

          const closeButton = modalContent.querySelector('.close-button');
          closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
            modal.innerHTML = '';
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
