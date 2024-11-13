
    function render() {
        try {
            fetch('/salondetails/', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
            }).then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = '/SignIn';
                    } else {
                        throw new Error('Network response was not ok');
                    }
                }
                return response.json();
                
            }).then(data => {
                const scrollContainer = document.querySelector('.more-about-salons');

                const data = [
                    { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Company Name', rating: 4, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
                    { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Company Name', rating: 3, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
                    { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Company Name', rating: 1, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
                    { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Company Name', rating: 5, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
                    { imgSrc: '/public/assets/images/Salons/Best Makeup for your Wedding Day.jpg', title: 'Company Name', rating: 2, description: 'Description of the salon is mentioned here Description of the salon is mentioned here Description of the salon is mentioned here ' },
                ];
            
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
                            <div class="heading">${data.title}</div>
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
            })
        } catch (error) {
    
        }
        // Render all cards
        data.forEach(createCard);
        
    }
    


  
  

// Run the render function when the page loads
document.addEventListener('DOMContentLoaded', render);

