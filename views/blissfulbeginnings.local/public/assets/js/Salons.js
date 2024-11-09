function render() {
    const scrollContainer = document.querySelector('.more-about-salons');

    const cardsData = [
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
        { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Select Preshoot Locations', description: 'Description of the salon is mentioned here' },
    ];

    // Clear the container first (optional)
    scrollContainer.innerHTML = '';

    // Function to create and append a card
    function createCard(cardData) {
        const cardHTML = `
            <div class="card">
                <div class="image-content">
                    <span class="overlay"></span>
                    <div class="card-image">
                        <img src="${cardData.imgSrc}" alt="" class="card-img">
                    </div>
                </div>
                <div class="card-content">
                    <h2 class="name">${cardData.title}</h2>
                    <button class="card-button">Book Now!</button>
                </div>
                <div class="card-description">
                    <p class="description">${cardData.description}</p>
                </div>
            </div>`;
        scrollContainer.innerHTML += cardHTML;
    }

    // Render all cards
    cardsData.forEach(createCard);
}

// Run the render function when the page loads
document.addEventListener('DOMContentLoaded', render);
