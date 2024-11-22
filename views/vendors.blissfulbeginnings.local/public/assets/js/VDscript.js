function render() {
    const scrollContainer = document.querySelector('.slide-content');

    const cardsData = [
        { imgSrc: '/public/assets/images/VendorWeddingDashboard/img1.jpg', bride: "Chamodya", groom: "Induma", date: "2024-06-23", time: "Night", location: "Colombo District, Western", cost: "LKR 240,000", progress: 60,budget: 40 },
        { imgSrc: '/public/assets/images/VendorWeddingDashboard/img2.jpg', bride: "Chamodya", groom: "Induma", date: "2024-06-23", time: "Night", location: "Colombo District, Western", cost: "LKR 240,000", progress: 60,budget: 40 },
        { imgSrc: '/public/assets/images/VendorWeddingDashboard/img3.jpg', bride: "Chamodya", groom: "Induma", date: "2024-06-23", time: "Night", location: "Colombo District, Western", cost: "LKR 240,000", progress: 60,budget: 40 },
        { imgSrc: '/public/assets/images/VendorWeddingDashboard/img4.jpg', bride: "Chamodya", groom: "Induma", date: "2024-06-23", time: "Night", location: "Colombo District, Western", cost: "LKR 240,000", progress: 60,budget: 40 },
        { imgSrc: '/public/assets/images/VendorWeddingDashboard/img5.jpg', bride: "Chamodya", groom: "Induma", date: "2024-06-23", time: "Night", location: "Colombo District, Western", cost: "LKR 240,000", progress: 60,budget: 40 },
        { imgSrc: '/public/assets/images/VendorWeddingDashboard/img6.jpg', bride: "Chamodya", groom: "Induma", date: "2024-06-23", time: "Night", location: "Colombo District, Western", cost: "LKR 240,000", progress: 60,budget: 40 },
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
                    <h4 class="description">Date: ${cardData.date}</h4>
                    <h4 class="description">Time: ${cardData.time}</h4>
                    <h4 class="description">Location: ${cardData.location}</h4>
                    <h4 class="description">Wedding Progress: ${cardData.progress}</h4> 
                        <div class="progress-bar">
                            <div class="progress" style="width: ${cardData.progress}%"></div>
                        </div>
                    <h4 class="description">Wedding Budget: ${cardData.location}</h4> 
                        <div class="progress-bar">
                            <div class="progress" style="width: ${cardData.budget}%"></div>
                        </div>
                </div>
            </div>`;
    }

    function loadCards(cards) {
        let cardWrappersHTML = '';

        // 3 cards in card-wrapper and appending the rest
        for (let i = 0; i < cards.length; i += 3) {
            const cardsInGroup = cards.slice(i, i + 3).map(card => createCard(card)).join('');
            cardWrappersHTML += `<div class="card-wrapper">${cardsInGroup}</div>`;
        }

        // inserting into slide-content
        scrollContainer.innerHTML = cardWrappersHTML;
    }

    loadCards(cardsData);
}

document.addEventListener('DOMContentLoaded', render);