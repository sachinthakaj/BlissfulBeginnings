function getNames() {
    Names = {
        brideName: "Samantha",
        groomName: "Keerthi",
    }
    return (Names.brideName + "'s & " + Names.groomName + "'s Wedding"); 
}


const getTimeRemaining = () => {
    time=  {
        days: 2,
    }
    return (
        `<h2>${time.days} days left...</h2>`
    ); 
}

const getProgress = (wedding, budget) => {
    progress = {
        budget: 40,
        wedding: 60,
    }
    wedding.style.width = `${progress.wedding}%`;
    budget.style.width = `${progress.budget}%`;
    
}

function render() {
    const scrollContainer = document.querySelector('.slide-content');
    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');

    // Array of card data
    const cardsData = [
        { imgSrc: '../images/VendorWeddingDashboard/img1.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img2.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img3.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img4.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img5.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img6.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img7.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
        { imgSrc: '../images/VendorWeddingDashboard/img8.jpg', title: 'Select Preshoot Locations', deadline: '2 June 2021', description: 'Select your preferred locations.' },
    ];

    // function to create a card
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
                    <h2 class="name">${cardData.title}</h2>
                    <h5 class="sub-name">Deadline: ${cardData.deadline}</h5>
                    <p class="description">${cardData.description}</p>
                    <button class="card-button">View More</button>
                </div>
            </div>`;
    }

    // cards into groups of 3
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

    // load all cards
    loadCards(cardsData);

    // navigation buttons to navigate toright and toleft
    nextBtn.addEventListener('click', () => {
        scrollContainer.scrollLeft += 900;
        scrollContainer.style.scrollBehavior = 'smooth';
    });

    backBtn.addEventListener('click', () => {
        scrollContainer.scrollLeft -= 900;
        scrollContainer.style.scrollBehavior = 'smooth';
    });

    // scroll behavior
    scrollContainer.addEventListener('wheel', (evt) => {
        evt.preventDefault();
        scrollContainer.scrollLeft += evt.deltaX;
        scrollContainer.style.scrollBehavior = 'auto';
    });

    const weddingTitle = document.querySelector('.wedding-title');
    weddingTitle.innerHTML = getNames();

    const timeRemaining = document.getElementById('days-left');
    timeRemaining.innerHTML = getTimeRemaining();

    const weddingProgress = document.getElementById('wedding-progress-bar');
    const budgetProgress = document.getElementById('budget-progress-bar');
    getProgress(weddingProgress, budgetProgress);

    // const slideContent = document.querySelector('.slide-content');
    // cardsData.forEach(cardData => {
    //     slideContent.innerHTML += createCard(cardData);
    // });
}

document.addEventListener('DOMContentLoaded', render);