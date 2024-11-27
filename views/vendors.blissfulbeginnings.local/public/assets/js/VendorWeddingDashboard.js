const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 3];
const assignmentID = pathParts[pathParts.length - 1];




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

    document.querySelector('.go-back').addEventListener('click', () => {
        window.location.href = `/vendor/${vendorID}`;
    })

    fetch(`/vendor/${vendorID}/assignment/${assignmentID}/get-tasks`, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
        }
    }).then(response => {
        if (response.status == 401) {
            window.location.href = '/signin';
        } else {
            return response.json()
        }
    }).then(details => {
        // function to create a card
        function createCard(cardData) {
            return `
            <div class="card" id=${cardData.taskID}>
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
                    <button class="card-button">Complete</button>
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
            document.querySelector('.card-button').addEventListener('click', () => {
                fetch(`/vendor/${vendorID}/assignment/${assignmentID}/complete-task/${cardID}`, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                    }
                })
            })
        }

        // load all cards
        loadCards(details.tasks);
        const weddingTitle = document.querySelector('.wedding-title');
        weddingTitle.innerHTML = details.weddingDetails.weddingTitle;

        const targetDate = new Date(details.weddingDetails.date);
        const today = new Date();
        const differenceInTime = targetDate - today;
        const remainingDays = Math.ceil(differenceInTime / (1000 * 60 * 60 * 24));
        document.getElementById("days-left").innerHTML = remainingDays > 0 ? `${remainingDays} days left` : "Happy wedded life!";
    

        const weddingProgress = document.getElementById('wedding-progress-bar');
        const budgetProgress = document.getElementById('budget-progress-bar');
        getProgress(weddingProgress, budgetProgress);

    })



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


    // const slideContent = document.querySelector('.slide-content');
    // cardsData.forEach(cardData => {
    //     slideContent.innerHTML += createCard(cardData);
    // });
}

document.addEventListener('DOMContentLoaded', render);