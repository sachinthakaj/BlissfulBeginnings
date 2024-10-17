const path = window.location.pathname;
const pathParts = path.split('/');
const weddingID = pathParts[pathParts.length - 1];


const vendors = [
    { name: 'Salon 1', type: "Groom's Salon", progress: 60, budget: 40 },
    { name: 'Salon 2', type: "Bride's Salon", progress: 60, budget: 40 },
    { name: 'Dressmaker 1', type: "Bride's Dressmaker", progress: 60, budget: 40 },
    { name: 'Dressmaker 2', type: "Groom's Dressmaker", progress: 60, budget: 40 },
    { name: 'Photographer', type: 'Photographer', progress: 100, budget: 40 },
    { name: 'Florist', type: 'Florist', progress: 60, budget: 40 },
];

function createVendorCard(vendor) {
    return `
        <div class="vendor-card">
            <h3>${vendor.name}</h3>
            <p>${vendor.type}</p>
            <div class="vendor-image"></div>
            <div class="progress-bar-container">
                <div class="bar vendor-bar" style="width: 100%"></div>
                <div class="bar wedding-progress-bar" style="width: ${vendor.progress}%"></div>
            </div>
            <div class="progress-bar-container">
            <div class="bar vendor-bar" style="width: 100%"></div>
                <div class="bar budget-progress-bar" style="width: ${vendor.budget}%"></div>
            </div>
        </div>
    `;
}

function getNames() {
    Names = {
        brideName: "Samantha",
        groomName: "Keerthi",
    }
    return (Names.brideName + "'s & " + Names.groomName + "'s Wedding");
}


const getTimeRemaining = () => {
    time = {
        days: 21,
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
    const weddingTitle = document.querySelector('.wedding-title');
    const timeRemaining = document.getElementById('days-left');
    const weddingProgress = document.getElementById('wedding-progress-bar');
    const budgetProgress = document.getElementById('budget-progress-bar');
    const vendorGrid = document.querySelector('.vendor-grid');

    try {
        fetch('/wedding/data/' + weddingID, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                console.log(response.status);
                if (response.status === 401 ) {
                    window.location.href = '/SignIn';
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        }).then(data => {
            console.log(data);
        })
    } catch (error) {

    }



    vendors.forEach(vendor => {
        vendorGrid.innerHTML += createVendorCard(vendor);
    });
}

document.addEventListener('DOMContentLoaded', render);