const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];

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
          time: "Night",
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
          time: "Night",
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
          time: "Night",
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
          time: "Night",
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
          time: "Night",
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
          time: "Night",
          location: "Colombo District, Western",
          cost: "LKR 240,000",
          progress: 60,
          budget: 40,
        },
    ];

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
                        <h4 class="description">Time: ${cardData.time}</h4>
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
      
      loadCards(cardsData);

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
            fetch('/delete-profile/vendor-details/' + vendorID, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                return response.json();
            }).then(vendorData => {
                
            })
                
            })
            console.log("Profile deleted");
            closeModal();
            
        };

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

        fetch('/get-profile-details/vendor-details/' + vendorID, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
    
            return response.json();
        }).then(vendorData => {
            let changedFields = {};
            document.querySelectorAll('.form-input').forEach(input => {
                input.value = vendorData[input.id];
                input.addEventListener('change', () => {
                    changedFields[input.id] = input.value;  
                })
            })
            document.querySelector('.submit-button').addEventListener('click', () => {
                console.log(changedFields);
            if (Object.keys(changedFields).length > 0) {
                fetch('/update-profile/vendor-details/' + vendorID, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(changedFields)
                }).then(response => {
                    return response.json();
                }).then(data => {
                    Object.keys(changedFields).forEach((column) => {
                        vendorData[column] = changedFields[column];
                      });
                      closeEditModal();
                }).catch(error => {
                    console.error(error);
                });
            }
            })



    })}
    

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

        

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && editModalContainer.classList.contains('show')) {
                closeEditModal();
            }
        });
    }

}

document.addEventListener('DOMContentLoaded', render);