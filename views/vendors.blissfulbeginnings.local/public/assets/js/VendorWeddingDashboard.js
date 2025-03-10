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
                    <h5 class="sub-name">Deadline: ${cardData.dateToFinish}</h5>
                    <p class="description">${cardData.description}</p>
                    <button class="card-button">Complete</button>
                </div>
            </div>`;
        }

        // cards into groups of 3
        function loadCards(cards) {
            let cardWrappersHTML = '';
            if (cards.length == 0) {
                scrollContainer.innerHTML = `
                <div class="no-tasks">
                     <h2>No given tasks<h2>
                </div>`;
                return
            }
            // 3 cards in card-wrapper and appending the rest
            for (let i = 0; i < cards.length; i += 3) {
                const cardsInGroup = cards.slice(i, i + 3).map(card => createCard(card)).join('');
                cardWrappersHTML += `<div class="card-wrapper">${cardsInGroup}</div>`;
            }

            // inserting into slide-content
            scrollContainer.innerHTML = cardWrappersHTML;
            scrollContainer.querySelector('.card-button').addEventListener('click', () => {
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
        console.log(weddingTitle);

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

function renderMessages() {
    const chatContainer = document.querySelector('.chat-container');
    chatContainer.innerHTML = '';

    const wsUrl = 'ws://localhost:8080/';

    const socket = new WebSocket(wsUrl);
    const messageInput = document.querySelector('.chat-type-field');
    const sendBtn = document.querySelector('.chat-send-button');


    socket.onopen = () => {
        socket.send(JSON.stringify({
            weddingID: weddingID,
        }));
    };

    socket.onmessage = (event) => {
        console.log(event);
        const messages = JSON.parse(event.data);
        messages.forEach(message => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', message.role);
            messageElement.textContent = message.message;
            messageElement.dataset.timestamp = message.timestamp;
            chatContainer.appendChild(messageElement);
        });

    };

    socket.onerror = (error) => {
        console.error('WebSocket error:', error);
    };

    socket.onclose = () => {
        console.log('WebSocket connection closed.');
    };

    sendBtn.addEventListener('click', () => {
        const message = messageInput.value.trim();
        if (message) {

            chatMessage = {
                sender: 'customer',
                text: message,
                timestamp: Date.now()
            };
            socket.send(JSON.stringify(chatMessage));
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', 'me');
            messageElement.textContent = chatMessage.text;
            messageElement.dataset.timestamp = chatMessage.timestamp;
            chatContainer.appendChild(messageElement);
            messageInput.value = '';
        }
    });

    messageInput.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            sendBtn.click();
        }
    });

    chatContainer.scrollTop = chatContainer.scrollHeight;
}
document.addEventListener("DOMContentLoaded", renderMessages);

document.addEventListener('DOMContentLoaded', render);