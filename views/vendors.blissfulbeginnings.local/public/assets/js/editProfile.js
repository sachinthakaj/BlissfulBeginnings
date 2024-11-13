const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];


const mainContainer = document.querySelector('.main-container');
const newPackage = document.querySelector('.add-package');

document.addEventListener("DOMContentLoaded", () => {
    const loadingScreen = document.getElementById("loading-screen");
    const mainContent = document.getElementById("main-content");
    fetch('/edit-profile/vendor-details/' + vendorID, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    }).then(response => {

        return response.json();
    }).then(vendorData => {
        console.log(vendorData)
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

            let changedPackageFields = {};

            const updatePackage = () => {
                console.log("Updating package");
            }



            modalContent.innerHTML = `
                        <span class="close">&times;</span>
                        <h2>Update Package</h2>
                        <form id="updateForm" onsubmit=updatePackage>
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
                                <input type="text" id="feature2" name="feature2" value=${package.features[1]}>
                            </div>
                            <div class="input-group">
                                <label for="feature3">Feature 3</label>
                                <input type="text" id="feature3" name="feature3" value=${package.features[2]}>
                            </div>
                            <div class="input-group">
                                <label for="fixedCost">Fixed Cost</label>
                                <input type="text" id="fixedCost" name="fixedCost" value=${package.fixedCost} required>
                            </div>
                            `;
            vendorDisplayFunctions[vendorData.type](package, modalContent);
            modalContent.innerHTML += `
                    <div class="submit-button">
                        <button type="submit">Submit</button>
                    </div>`
            modalContent.querySelectorAll("input, select, textarea").forEach((input) => {
                input.addEventListener("change", (event) => {
                    const { name, value } = event.target;
                    // Add changed fields to the object
                    changedPackageFields[name] = value;
                    console.log(`${name} changed, new value: ${value}`);
                });
            });
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


        newPackage.addEventListener('click', () => {
            const modal = document.getElementById("modal");
            const modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = `<span class="close">&times;</span>
    <h2>Create new Package</h2>
    <form id="updateForm" onsubmit=createPackage>
        <div class="input-group">
            <label for="packageName">Package Name</label>
            <input type="text" id="packageName" name="packageName" required>
        </div>
        <div class="input-group">
            <label for="feature1">Feature 1</label>
            <input type="text" id="feature1" name="feature1" required>
        </div>
        <div class="input-group">
            <label for="feature2">Feature 2</label>
            <input type="text" id="feature2" name="feature2" >
        </div>
        <div class="input-group">
            <label for="feature3">Feature 3</label>
            <input type="text" id="feature3" name="feature3" >
        </div>
        <div class="input-group">
            <label for="fixedCost">Fixed Cost</label>
            <input type="text" id="fixedCost" name="fixedCost"  required>
        </div>
        `;
            console.log(vendorData);
            vendorCreatePackageFunctions[vendorData.type](modalContent);
            modalContent.innerHTML += `
        <div class="submit-button">
            <button type="submit">Submit</button>
        </div>`
            modal.style.display = "block";
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
        })

        loadingScreen.style.display = "none";
        mainContent.style.display = "block";
    }).catch(error => {
        console.error('Error fetching data early:', error)
        loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
    });

});

const createPhotographerPackage = (modalContent) => {
    modalContent.innerHTML += `
        <div class="input-group">
            <label for="cameraCoverage">Camera Coverage</label>
            <input type="text" id="cameraCoverage" name="cameraCoverage"  required>
        </div>
        </form>`;
};

const createDressDesignerPackage = (modalContent) => {
    modalContent.innerHTML += `
        <div class="input-group">
            <label for="theme">Theme</label>
            <input type="text" id="theme" name="theme"  required>
        </div>
        <div class="input-group">
            <label for="variableCost">Cost per Group Member</label>
            <input type="text" id="variableCost" name="variableCost" required>
        </div>
        <div class="input-group">
            <label for="dempgraphic">Demographic</label>
            <select id="demographic" name="demographic"  required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Both">Both</option>
            </select>
        </div>
        </form>`;
};

const createSalonPackage = (modalContent) => {
    modalContent.innerHTML += `
                            <div class="input-group">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" required>
                            </div>
                            <div class="input-group">
                                <label for="dempgraphic">Demographic</label>
                                <select id="demographic" name="demographic" required>
                                    <option value="Bride">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            </form>`;

};

const createFloristPackage = (modalContent) => {
    modalContent.innerHTML += `
                            <div class="input-group">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" required>
                            </div>
                            <div class="input-group">
                                <label for="flowerType">Type of Flowers</label>
                                <select id="flowerType" name="flowerType" required>
                                    <option value="Artificial">Artificial</option>
                                    <option value="Fresh">Fresh</option>
                                </select>
                            </div>
                            </form>`;

};

const vendorCreatePackageFunctions = {
    'Photographer': createPhotographerPackage,
    'Dress Designer': createDressDesignerPackage,
    'Salon': createSalonPackage,
    'Florist': createFloristPackage
}



const displayPhotographerPackage = (packageDetails, modalContent) => {
    modalContent.innerHTML += `<div class="input-group">
                                <label for="cameraCoverage">Camera Coverage</label>
                                <input type="text" id="cameraCoverage" name="cameraCoverage" value=${packageDetails.cameraCoverage} required>
                            </div>
                            </form>`;
}
const displayDressDesignerPackage = (packageDetails, divElement) => {
    modalContent.innerHTML += `<div class="input-group">
                                <label for="theme">Theme</label>
                                <input type="text" id="theme" name="theme" value=${packageDetails.theme} required>
                            </div>
                            <div class="input-group">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" value=${packageDetails.variableCost} required>
                            </div>
                            <div class="input-group">
                                <label for="dempgraphic">Demographic</label>
                                <select id="demographic" name="demographic" value="${packageDetails.demographic}" required>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            </form>`;
}
const displaySalonPackage = (packageDetails, divElement) => {
    modalContent.innerHTML += `
                            <div class="input-group">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" value=${packageDetails.variableCost} required>
                            </div>
                            <div class="input-group">
                                <label for="dempgraphic">Demographic</label>
                                <select id="demographic" name="demographic" value="${packageDetails.demographic}" required>
                                    <option value="Bride">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            </form>`;
}
const displayFloristPackage = (packageDetails, divElement) => {
    modalContent.innerHTML += `
                            <div class="input-group">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" value=${packageDetails.variableCost} required>
                            </div>
                            <div class="input-group">
                                <label for="flowerType">Type of Flowers</label>
                                <select id="flowerType" name="flowerType" value="${packageDetails.flowerType}" required>
                                    <option value="Artificial">Artificial</option>
                                    <option value="Fresh">Fresh</option>
                                </select>
                            </div>
                            </form>`;
}

const vendorDisplayFunctions = {
    'Photographer': displayPhotographerPackage,
    'Dress Designer': displayDressDesignerPackage,
    'Salon': displaySalonPackage,
    'Florist': displayFloristPackage
}




