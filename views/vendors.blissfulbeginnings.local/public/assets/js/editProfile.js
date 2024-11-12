const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];

const mainContainer = document.querySelector('.main-container');


const displayPhotographerPackage = (packageDetails, modalContent) => {
    modalContent.innerHTML += `<div class="input-group">
                                <label for="cameraCoverage">Camera Coverage</label>
                                <input type="text" id="cameraCoverage" name="cameraCoverage" value=${packageDetails.cameraCoverage} required>
                            </div>
                            </form>`;
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
            document.getElementById("profile-image").setAttribute("src", vendorData.image);

            function openUpdateModal(packageID) {
                console.log(packageID);
                const package = vendorData.packages[packageID];
                console.log(package);
                const modal = document.getElementById("modal");
                const modalContent = document.getElementById("modal-content");
                modalContent.innerHTML = `
                        <span class="close">&times;</span>
                        <h2>Update Package</h2>
                        <form id="updateForm">
                            <div class="input-group">
                                <label for="packageName">Package Name</label>
                                <input type="text" id="packageName" name="packageName" value=${package.name} required>
                            </div>
                            <div class="input-group">
                                <label for="feature1">Feature 1</label>
                                <input type="text" id="feature1" name="feature1" value=${package.features[0]} required>
                            </div>
                            <div class="input-group">
                                <label for="feature2">Feature 2</label>
                                <input type="text" id="feature2" name="feature2" value=${package.features[1]} required>
                            </div>
                            <div class="input-group">
                                <label for="feature3">Feature 3</label>
                                <input type="text" id="feature3" name="feature3" value=${package.features[2]} required>
                            </div>
                            <div class="input-group">
                                <label for="fixedCost">Fixed Cost</label>
                                <input type="text" id="fixedCost" name="fixedCost" value=${package.fixedCost} required>
                            </div>
                            `;
                vendorDisplayFunctions[vendorData.type](package, modalContent);
                mainContainer.appendChild(modal);
                modal.style.display = "block";
                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];



                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    currentStep = 0;
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        currentStep = 0;
                        modal.style.display = "none";
                    }
                }
            }


            const packagesContainer = document.getElementById('packages-container');
            packagesContainer.innerHTML = ''; // Clear any existing content

            Object.entries(vendorData.packages).forEach(([packageID, package]) => {
                const packageDiv = document.createElement('div');
                packageDiv.classList.add('package');
                packageDiv.setAttribute("id", packageID);
                packageDiv.innerHTML = `
                <div class="details">
                <span class="delete-icon">🗑️</span>
                        <div>${package.name}</div>
                        <div>What's Included:</div>
                        <ul>
                            ${package.features.map(feature => `<li>${feature}</li>`).join('')}
                        </ul>
                        <div class="price">${package.fixedCost}</div>
                    </div>
                `;
                packageDiv.addEventListener('click', (event) => openUpdateModal(event.currentTarget.id));
                packagesContainer.appendChild(packageDiv);
            });

            // Creating the new package card
            const packageDiv = document.createElement('div');
            packageDiv.classList.add('package');
            packageDiv.innerHTML = `
                    <div class="details add-package">
                        <img src="/public/assets/images/Plus.png" id="plus" alt="Package Image">
                    </div>
                `;

            packagesContainer.appendChild(packageDiv);
        })
    } catch (error) {
        console.error("Error fetching data:", error);
    }
});
