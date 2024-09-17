/// Sample backend data
const backendData = {
    title: "Pettah Tailors - Dashboard",
    events: [
        { 
            bride: "Chamodya", 
            groom: "Induma", 
            date: "2024-06-23", 
            time: "Night", 
            location: "Colombo District, Western", 
            cost: "LKR 240,000", 
            bridePhone: "0777456798", 
            groomPhone: "0786459532",
            progress: 60,
            budget: 40
        },
        { 
            bride: "Sithara", 
            groom: "Nimal", 
            date: "2024-09-10", 
            time: "Afternoon", 
            location: "Matara District, Southern", 
            cost: "LKR 275,000", 
            bridePhone: "0771234567", 
            groomPhone: "0789876543",
            progress: 80,
            budget: 70
        },
        { 
            bride: "Nimesha", 
            groom: "Namal", 
            date: "2024-09-12", 
            time: "Afternoon", 
            location: "Matara District, Southern", 
            cost: "LKR 300,000", 
            bridePhone: "0771224567", 
            groomPhone: "0789870543",
            progress: 80,
            budget: 70
        }
    ]
};

// Populate header title from backend
document.getElementById('dashboardTitle').innerText = backendData.title;

// Load events from backendData into the DOM
const eventsContainer = document.getElementById('eventsContainer');
backendData.events.forEach(event => {
    const eventCard = document.createElement('div');
    eventCard.classList.add('event-card');
    eventCard.innerHTML = `
        <h2>${event.bride} & ${event.groom}'s Wedding</h2>
        <p className="red"><strong>Date:</strong> ${event.date} - ${event.time}</p>
         <p className="red"><strong>$:</strong> ${event.cost}</p>
        <p><strong>Location:</strong> ${event.location}</p>
       
        <p><strong>Bride:</strong> ${event.bridePhone}</p>
        <p><strong>Groom:</strong> ${event.groomPhone}</p>
        <p><strong>Wedding Progress:</strong></p>
        <div class="progress-bar"><div class="progress" style="width: ${event.progress}%"></div></div>
        <p><strong>Budget Utilization:</strong></p>
        <div class="budget-bar"><div class="budget" style="width: ${event.budget}%"></div></div>
    `;
    eventsContainer.appendChild(eventCard);
});

// Search functionality
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const eventCards = document.querySelectorAll('.event-card');
    eventCards.forEach(card => {
        const brideGroomNames = card.querySelector('h2').innerText.toLowerCase();
        if (brideGroomNames.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Modal Logic for Edit Profile
const editProfileBtn = document.getElementById('editProfileBtn');
const profileModal = document.querySelector('.profile-edit-modal');
const cancelButton = document.getElementById('cancelButton');

editProfileBtn.addEventListener('click', () => {
    profileModal.style.display = 'block';
});

cancelButton.addEventListener('click', () => {
    profileModal.style.display = 'none';
});

// Handle file upload drag & drop
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('photo');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragging');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragging');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragging');
    const files = e.dataTransfer.files;
    fileInput.files = files;
    // Optional: update UI to show selected file
});

// Optional: Handle form submission for profile edit
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Handle the form submission logic (send data to the server, etc.)
    console.log("Profile updated!");
    profileModal.style.display = 'none'; // Close modal on save
});
