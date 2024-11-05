
document.addEventListener("DOMContentLoaded", function () {
    const weddings = [
        {
            couple: "Mahima & Tharindi",
            date: "23rd May",
            time: "Day",
            cost: "LKR 540,000.00",
            location: "Gampaha District, Western",
            type: "Western",
            bridePhone: "0777456434",
            groomPhone: "0768451122",
            isNew: false
        },
        {
            couple: "Chamodya & Induma",
            date: "23rd June",
            time: "Night",
            cost: "LKR 240,000.00",
            location: "Colombo District, Western",
            type: "Kandyan",
            bridePhone: "0777456789",
            groomPhone: "0768459352",
            isNew: true
        },

        {
            couple: "Pamudu & Indumini",
            date: "23rd May",
            time: "Day",
            cost: "LKR 540,000.00",
            location: "Gampaha District, Western",
            type: "Western",
            bridePhone: "0777456434",
            groomPhone: "0768451122",
            isNew: true
        },

        {
            couple: "Ravindu & Hirushi",
            date: "23rd May",
            time: "Day",
            cost: "LKR 540,000.00",
            location: "Gampaha District, Western",
            type: "Western",
            bridePhone: "0777456434",
            groomPhone: "0768451122",
            isNew: false
        },

        {
            couple: "Ravindu & Hirushi",
            date: "23rd May",
            time: "Day",
            cost: "LKR 540,000.00",
            location: "Gampaha District, Western",
            type: "Western",
            bridePhone: "0777456434",
            groomPhone: "0768451122",
            isNew: false
        },
       
        
    ];

    const weddingCardsContainer = document.querySelector('.wedding-cards');

    weddings.forEach(wedding => {
        const card = document.createElement('div');
        card.classList.add('wedding-card');
        if (wedding.isNew) {
            card.classList.add('new');
        }
        card.innerHTML = `
            <h3>${wedding.couple}'s Wedding</h3>
            <p><strong>${wedding.date} - ${wedding.time}</strong></p>
            <p>${wedding.cost}</p>
            <p>${wedding.location}</p>
            <p>${wedding.type}</p>
            <p>Bride: ${wedding.bridePhone}</p>
            <p>Groom: ${wedding.groomPhone}</p>
        `;
        card.addEventListener('click', () => {
            alert(`Opening details for ${wedding.couple}'s Wedding`);
        });
        weddingCardsContainer.appendChild(card);
    });

   
});