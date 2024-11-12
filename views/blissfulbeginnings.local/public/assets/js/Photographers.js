function render() {
    const scrollContainer = document.querySelector('.more-about-photographers');

    const cardsData = [
        { imgSrc: '/public/assets/images/Photographers/Photographers.jpeg', title: 'Company Name', rating: 4, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
        { imgSrc: '/public/assets/images/Photographers/Photographers.jpeg', title: 'Company Name', rating: 3, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
        { imgSrc: '/public/assets/images/Photographers/Photographers.jpeg', title: 'Company Name', rating: 1, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
        { imgSrc: '/public/assets/images/Photographers/Photographers.jpeg', title: 'Company Name', rating: 5, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
        { imgSrc: '/public/assets/images/Photographers/Photographers.jpeg', title: 'Company Name', rating: 2, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
    ];

    // Clear the container first
    scrollContainer.innerHTML = '';

    // Function to create and append a card
    function createCard(cardData) {
        const card = document.createElement('div');
        card.classList.add('container');

        const cardHTML = `
            <div class="image-container">
                <img src="${cardData.imgSrc}" alt="Image here" class="image">
            </div>
            <div class="text-container">
                <div class="heading">${cardData.title}</div>
                <div class="stars">
                    ${Array(5).fill(0).map((_, i) => `
                        <span class="star ${i < cardData.rating ? 'selected' : ''}" data-value="${i + 1}">&#9734;</span>
                    `).join('')}
                </div>
                <div class="description">${cardData.description}</div>
            </div>
        `;
        card.innerHTML = cardHTML;

        // Append card to the container
        scrollContainer.appendChild(card);
    }

    // Render all cards
    cardsData.forEach(createCard);
}

// Run the render function when the page loads
document.addEventListener('DOMContentLoaded', render);
