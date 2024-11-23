function render() {
    try {
        fetch('/get-dressdesigners/', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                if (response.status === 403) {
                    console.log("No DressDesigners Found");
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
            
        }).then(data => {
            const scrollContainer = document.querySelector('.more-about-dress');
        
            // Clear the container first
           scrollContainer.innerHTML = '';
        
            // Function to create and append a card
            function createCard(data) {
                const card = document.createElement('div');
                card.classList.add('container');
        
                const cardHTML = `
                    <div class="image-container">
                        <img src="${data.imgSrc}" alt="Image here" class="image">
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
        
                // Append card to the container
                scrollContainer.appendChild(card);
                            }
           // Render all cards
           data.forEach(createCard);
        })
    } catch (error) {

    }
    
    
}






// Run the render function when the page loads
document.addEventListener('DOMContentLoaded', render);

