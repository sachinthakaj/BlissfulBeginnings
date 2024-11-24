function render() {
    const scrollContainer = document.querySelector(".slide-content");
    const deleteProfile = document.querySelector('.delete-profile');
    const modalContainer = document.querySelector('.modal-container');
    const cancelButton = document.querySelector('.cancel-button');
    const deleteButton = document.querySelector('.delete-button');
    const editProfile = document.querySelector('.edit-profile');
    const editModalContainer = document.querySelector('#edit-modal-container');
    const closeButton = editModalContainer.querySelector('.close-button');
    const prevButton = editModalContainer.querySelector('.prev-button');
    const nextButton = editModalContainer.querySelector('.next-button');
    const submitButton = editModalContainer.querySelector('.submit-button');
    const modalPages = editModalContainer.querySelectorAll('.modal-page');
    const paginationDots = editModalContainer.querySelectorAll('.dot');

    const cardsData = [
        {
          imgSrc: "/public/assets/images/VendorWeddingDashboard/img1.jpg",
          bride: "Chamodya",
          groom: "Induma",
          date: "2024-06-23",
          dayNight: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
        {
          imgSrc: "/public/assets/images/VendorWeddingDashboard/img2.jpg",
          bride: "Chamodya",
          groom: "Induma",
          date: "2024-06-23",
          dayNight: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
        {
          imgSrc: "/public/assets/images/VendorWeddingDashboard/img3.jpg",
          bride: "Chamodya",
          groom: "Induma",
          date: "2024-06-23",
          dayNight: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
        {
          imgSrc: "/public/assets/images/VendorWeddingDashboard/img4.jpg",
          bride: "Chamodya",
          groom: "Induma",
          date: "2024-06-23",
          dayNight: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
        {
          imgSrc: "/public/assets/images/VendorWeddingDashboard/img5.jpg",
          bride: "Chamodya",
          groom: "Induma",
          date: "2024-06-23",
          dayNight: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
        {
          imgSrc: "/public/assets/images/VendorWeddingDashboard/img6.jpg",
          bride: "Chamodya",
          groom: "Induma",
          date: "2024-06-23",
          dayNight: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
    ];

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

    // fetch cards
    async function fetchCards() {
      try {
        const response = await fetch('/vendor/{vendorID}/get-weddings');
        
        if (!response.ok) {
          throw new Error(`HTTP error: ${response.status}`);
        }
    
        const textData = await response.text(); 
        const data = textData ? JSON.parse(textData) : []; 
    
        return data;
      } catch (error) {
        console.error('Error fetching cards:', error);
        showNotification("Could not fetch weddings", "red");
        return []; 
      }
    }
    

    // initialize cards
    async function initializeCards() {
      const cardsData = await fetchCards();
    
      if (Array.isArray(cardsData) && cardsData.length > 0) {
        loadCards(cardsData);
      } else {
        showNotification("No wedding data available", "red");
      }
    }
    
    function createCard(cardData) {
        return `
            <div class="card">
                <div class="image-content">
                    <span class="overlay"></span>
                    <div class="card-image">
                        <img src="${cardData.imgSrc}" alt="" class="card-img">
                    </div>
                </div>
                <div class="card-content">
                    <h2 class="name">${cardData.bride} & ${cardData.groom}'s Wedding</h2>
                    <div class="content">
                        <h4 class="description">Date: ${cardData.date}</h4>
                        <h4 class="description">Time: ${cardData.dayNight}</h4>
                        <h4 class="description">Location: ${cardData.location}</h4>
                        <h4 class="description">Wedding Progress: </h4> 
                        <div class="progress-bar-container">
                            <div class="progress-bar wedding-progress-bar" style="width: ${cardData.progress}%"></div>
                        </div>
                        <h4 class="description">Wedding Budget: </h4> 
                        <div class="progress-bar-container">
                             <div class="progress-bar budget-progress-bar" style="width: ${cardData.budget}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

      function loadCards(cards) {
        let cardWrappersHTML = "";
    
        // 3 cards in card-wrapper and appending the rest
        for (let i = 0; i < cards.length; i += 3) {
          const cardsInGroup = cards
            .slice(i, i + 3)
            .map((card) => createCard(card))
            .join("");
          cardWrappersHTML += `<div class="card-wrapper">${cardsInGroup}</div>`;
        }
    
        // inserting into slide-content
        scrollContainer.innerHTML = cardWrappersHTML;
      }
      
      // loadCards(cardsData);

      initializeCards();

    // modal for delete profile
    function openModal() {
        modalContainer.classList.add('show');
    }

    function closeModal() {
        modalContainer.classList.remove('show');
    }

    // Event Listeners
    if (deleteProfile && modalContainer) {
        deleteProfile.addEventListener('click', openModal);

        // Close modal when clicking cancel button
        cancelButton.addEventListener('click', closeModal);

        // Handle delete action
        deleteButton.addEventListener('click', () => {
            console.log("Profile deleted");
            closeModal();
            // Add your delete logic here
        });

        // Close modal when clicking outside
        modalContainer.addEventListener('click', (event) => {
            if (event.target === modalContainer) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modalContainer.classList.contains('show')) {
                closeModal();
            }
        });
    }

    // modal for edit profile
    let currentPage = 1;
    const totalPages = modalPages.length;

    function updateModalPage() {
        // Update pages
        modalPages.forEach(page => {
            page.classList.remove('active');
            if (parseInt(page.dataset.page) === currentPage) {
                page.classList.add('active');
            }
        });

        // Update dots
        paginationDots.forEach(dot => {
            dot.classList.remove('active');
            if (parseInt(dot.dataset.page) === currentPage) {
                dot.classList.add('active');
            }
        });

        // Update buttons
        prevButton.disabled = currentPage === 1;
        if (currentPage === totalPages) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }
    }

    function openEditModal() {
        editModalContainer.classList.add('show');
        currentPage = 1;
        updateModalPage();
    }

    function closeEditModal() {
        editModalContainer.classList.remove('show');
    }

    // Event Listeners
    if (editProfile && editModalContainer) {
        editProfile.addEventListener('click', openEditModal);

        // Close modal with close button
        closeButton.addEventListener('click', closeEditModal);

        // Close modal when clicking outside
        editModalContainer.addEventListener('click', (event) => {
            if (event.target === editModalContainer) {
                closeEditModal();
            }
        });

        // Navigation buttons
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

        // Pagination dots
        paginationDots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentPage = parseInt(dot.dataset.page);
                updateModalPage();
            });
        });

        // Form submission
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
            
            closeEditModal();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && editModalContainer.classList.contains('show')) {
                closeEditModal();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', render);
