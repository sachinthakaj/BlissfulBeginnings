const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];


const displayPhotographerPackage = (packageDetails, divElement) => {
    const packagesContainer = document.getElementById('packages-container');
    packagesContainer.innerHTML = ''; // Clear any existing content
}
const displayDressDesignerPackage = (packageDetails, divElement) => {
    const packagesContainer = document.getElementById('packages-container');
    packagesContainer.innerHTML = ''; // Clear any existing content
}
const displaySalonPackage = (packageDetails, divElement) => {
    const packagesContainer = document.getElementById('packages-container');
    packagesContainer.innerHTML = ''; // Clear any existing content
}
const displayFloristPackage = (packageDetails, divElement) => {
    const packagesContainer = document.getElementById('packages-container');
    packagesContainer.innerHTML = ''; // Clear any existing content
}

const vendorDisplayFunctions = {
    'Photographer': displayPhotographerPackage,
    'Dress Designer': displayDressDesignerPackage,
    'Salon': displaySalonPackage,	
    'Florist': displayFloristPackage
}


document.addEventListener("DOMContentLoaded", () => {
    try {
        fetch('/edit-profile/vendor-details/' + vendorID, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                alert(response);
                if (response.status === 401) {
                    window.location.href = '/signin';
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        }).then(vendorData => {
            // update title and description
            document.getElementById('name').textContent = vendorData.name;
            document.getElementById('description').textContent = vendorData.description;


            const packagesContainer = document.getElementById('packages-container');
            packagesContainer.innerHTML = ''; // Clear any existing content

            vendorData.packages.forEach(package => {
                const packageDiv = document.createElement('div');
                packageDiv.classList.add('package');

                packageDiv.innerHTML = `
                    <div class="details">
                        <div>${package.name}</div>
                        <div>What's Included:</div>
                        <ul>
                            ${package.features.map(feature => `<li>${feature}</li>`).join('')}
                        </ul>
                        <div class="price">${package.fixedCost}</div>
                    </div>
                `;

                packagesContainer.appendChild(packageDiv);
            });
        })
    } catch (error) {
        console.error("Error fetching data:", error);
    }
});
