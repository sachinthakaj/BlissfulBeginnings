function create(data) {
    const scrollContainer = document.querySelector(".more-about-photographers");
  
    scrollContainer.innerHTML='';
    function createCard(data){
      const card=document.createElement('div');
      card.classList.add('container');

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
      `;
      card.innerHTML = cardHTML;
      card.id=data.vendorID;
         
// Append card to the container
scrollContainer.appendChild(card);
}
  // Render all cards
  data.forEach(createCard);
  document.querySelectorAll('.container').forEach(card => {
      card.addEventListener('click', () => {
          window.location.href = `/vendor/${card.id}`;
      })
  })
}
  
  async function notFund() {
    const notFund = document.createElement("div");
    notFund.classList.add("not-found");
    notFund.innerHTML = `<h2 class="not-found-text">No photographers found</h2>`;
    const scrollContainer = document.querySelector(".more-about-photographers");
  
    scrollContainer.innerHTML = "";
    scrollContainer.appendChild(notFund);
  
    return;
  }
  
  async function fetchSalons() {
    try {
      const response = await fetch("/get-photographers/", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      });
  
      if (!response.ok) {
        if (response.status === 403) {
          console.error("No photographers found.");
          return [];
        }
        throw new Error("Failed to fetch photographers.");
      }
  
      return await response.json();
    } catch (error) {
      console.error("Error fetching photographers:", error);
      return [];
    }
  }
  
  async function render() {
    const data = await fetchSalons();
    if (data.length === 0) {
      notFund();
      return;
    } else {
      create(data);
    }
  }
  
  async function searchSalons() {
    const searchInput = document.getElementById("search_id");
    const searchValue = searchInput.value.trim().toLowerCase();
  
    if (!searchValue) {
      alert("Please enter a search term.");
      return;
    }
  
    const data = await fetchSalons();
    const filteredData = data.filter((salon) =>
      salon.businessName.toLowerCase().includes(searchValue)
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
      searchButton.addEventListener("click", searchSalons);
    } else {
      console.error("Search button not found in the DOM.");
    }
  
    if (searchInput) {
      searchInput.addEventListener("keyup", (event) => {
        if (event.key === "Enter") {
          searchSalons();
        }
      });
    } else {
      console.error("Search input not found in the DOM.");
    }
  
    render();
  });
  