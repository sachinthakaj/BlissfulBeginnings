function create(data) {
    const scrollContainer = document.querySelector(".more-about-dress");
  
    const ModalContainer = document.querySelector(".modal-container");
    const cancelButton = document.querySelector('.cancel-button');
    const deleteButton = document.querySelector('.delete-button');
    let currentVendorToDelete = null;
  
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
  
    // Clear the container first
    scrollContainer.innerHTML = '';
    
    function closeModal() {
        ModalContainer.classList.remove('show');
        currentVendorToDelete = null;
    }
  
    // Set up delete button listener (only once)
    deleteButton.addEventListener('click', () => {
        if (!currentVendorToDelete) return;
        
        fetch(`/vendor-delete/${currentVendorToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            },
        })
        .then(response => {
            if (response.status === 200) {
                showNotification("Vendor deleted successfully", "green");
                closeModal();
                setTimeout(() => window.location.href = '/dress-designers', 1000);
            } 
            else if (response.status === 409) {
                showNotification("This vendor has assigned weddings", "red");
                closeModal();
            }
            else if (response.status === 404) {
                showNotification("Vendor not found", "red");
                closeModal();
            }
            else if (response.status === 401) {
                showNotification("Unauthorized - please login again", "red");
                closeModal();
            }
            else {
                throw new Error('Failed to delete vendor');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification("Failed to delete vendor", "red");
            closeModal();
        });
    });
  
    // Set up cancel button listener (only once)
    if (cancelButton) {
        cancelButton.addEventListener('click', closeModal);
    }
  
    // Function to create and append a card
    function createCard(data) {
        const card = document.createElement('div');
        card.classList.add('container');
        card.id = data.vendorID;
  
        const cardHTML = `
            <div class="image-container">
                <img src="http://cdn.blissfulbeginnings.com${data.imgSrc}" alt="Image here" class="image">
            </div>
            <div class="text-container">
                <div class="heading">${data.businessName}</div>
                <div class="stars">
                    ${Array(5).fill(0).map((_, i) => `
                        <span class="star ${i < data.rating ? 'selected' : ''}" data-value="${i + 1}">&#9734;</span>
                    `).join('')}
                </div>
                <div class="description">${data.description}</div>
            </div>
            <img src="/public/assets/images/delete.jpeg" alt="Delete" class="delete-icon">
        `;
        card.innerHTML = cardHTML;
  
        // Add delete functionality
        const deleteIcon = card.querySelector('.delete-icon');
        deleteIcon.addEventListener('click', (e) => {
            e.stopPropagation(); 
            currentVendorToDelete = card.id;
            ModalContainer.classList.add('show');
        });
  
        // Append card to the container
        scrollContainer.appendChild(card);
    }
  
    // Render all cards
    data.forEach(createCard);
    
    document.querySelectorAll('.container').forEach(card => {
        card.addEventListener('click', () => {
            window.location.href = `/vendor/${card.id}`;
        });
    });
  }
    
    async function notFund() {
      const notFund = document.createElement("div");
      notFund.classList.add("not-found");
      notFund.innerHTML = `<h2 class="not-found-text">No dress designer found</h2>`;
      const scrollContainer = document.querySelector(".more-about-dress");
    
      scrollContainer.innerHTML = "";
      scrollContainer.appendChild(notFund);
    
      return;
    }
    
    async function fetchDresses() {
      try {
        const response = await fetch("/get-dressdesignerslist/", {
          method: "GET",
          headers: {
           'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                'Content-Type': 'application/json'
          },
        });
    
        if (!response.ok) {
          if (response.status === 403) {
            console.error("No dressdesigners found.");
            return [];
          }
          throw new Error("Failed to fetch dressdesigners.");
        }
    
        return await response.json();
      } catch (error) {
        console.error("Error fetching dressdesigners:", error);
        return [];
      }
    }
    
    async function render() {
      const data = await fetchDresses();
      if (data.length === 0) {
        notFund();
        return;
      } else {
        create(data);
      }
    }
    
    async function searchDresses() {
      const searchInput = document.getElementById("search_id");
      const searchValue = searchInput.value.trim().toLowerCase();
    
      if (!searchValue) {
        alert("Please enter a search term.");
        return;
      }
    
      const data = await fetchDresses();
      const filteredData = data.filter((dressdesigner) =>
          dressdesigner.businessName.toLowerCase().includes(searchValue)
      );
      if (filteredData.length === 0) {
        notFund();
        return;
      } else {
        create(filteredData);
      }
    }
    
    document.addEventListener("DOMContentLoaded", () => {
      const searchInput = document.getElementById("search_id");
      const searchButton = document.getElementById("search_button_id");
    
      if (searchButton) {
        searchButton.addEventListener("click",  searchDresses);
      } else {
        console.error("Search button not found in the DOM.");
      }
    
      if (searchInput) {
        searchInput.addEventListener("keyup", (event) => {
          if (event.key === "Enter") {
            searchDresses();
          }
        });
      } else {
        console.error("Search input not found in the DOM.");
      }
    
      render();
    });
    