const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];


const mainContainer = document.querySelector('.main-container');
const newPackage = document.querySelector('.add-package');
const cancelButton = document.querySelector('.cancel-button');
const deleteButton = document.querySelector('.delete-button');

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
        document.getElementById('name').textContent = vendorData.businessName;
        document.getElementById('description').textContent = vendorData.description;
        document.getElementById("profile-image").setAttribute("src", vendorData.image);

        function showNotification(message, color) {
            // Create notification element
            const notification = document.createElement("div");
            notification.textContent = message;
            notification.style.position = "fixed";
            notification.style.bottom = "20px";
            notification.style.left = "20px";
            notification.style.backgroundColor = color;
            notification.style.color = "white";
            notification.style.padding = "10px 20px";
            notification.style.borderRadius = "5px";
            notification.style.zIndex = 1000;
            notification.style.fontSize = "16px";
    
            // Append to body
            document.body.appendChild(notification);
    
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        const packagesContainer = document.getElementById('packages-container');

        Object.entries(vendorData.packages).forEach(([packageID, package]) => {
            const packageDiv = document.createElement('div');
            packageDiv.classList.add('package');
            packageDiv.setAttribute("id", packageID);
            packageDiv.innerHTML = `
                <div class="details">
                <span class="delete-icon">🗑️</span>
                            <div>${package.packageName}</div>
                        <div>What's Included:</div>
                        <ul>
                            <li>${package.feature1}</li>
                            ${package.feature2 ? `<li>${package.feature2}</li>` : ''}
                            ${package.feature3 ? `<li>${package.feature3}</li>` : ''}
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
            modalContent.innerHTML = `
                <span class="close">&times;</span>
                <h2>Create new Package</h2>
                <form id="createForm" >
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
                    <div class="submit-button">
                        <button type="submit" class="submit-button">Submit</button>
                    </div>
                </form>`;
            vendorCreatePackageFunctions[vendorData.typeID](modalContent);


            modalContent.querySelector("#createForm").addEventListener("submit", async (event) => {
                event.preventDefault();
                const formData = new FormData(event.currentTarget);
                const package = Object.fromEntries(formData.entries());
                package["typeID"] = vendorData.typeID;
                fetch('/vendor/' + vendorID + '/create-package', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(package),
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    } else {
                        return response.json();
                    }
                }).then(response => {
                    vendorData["packages"][response.packageID] = package;
                    const packagesContainer = document.getElementById('packages-container');
                    const packageDiv = document.createElement('div');
                    packageDiv.classList.add('package');
                    console.log(response);
                    packageDiv.setAttribute("id", response.packageID);
                    packageDiv.innerHTML = `
                            <div class="details">
                                <span class="delete-icon">🗑️</span>
                                <div>${package.packageName}</div>
                                <div>What's Included:</div>
                                <ul>
                                    <li>${package.feature1}</li>
                                    ${package.feature2 ? `<li>${package.feature2}</li>` : ''}
                                    ${package.feature3 ? `<li>${package.feature3}</li>` : ''}
                                </ul>
                                <div class="price">${package.fixedCost}</div>
                            </div >
                        `;
                    modal.style.display = "none";
                    packageDiv.addEventListener('click', (event) => openUpdateModal(event.currentTarget.id));
                    packagesContainer.appendChild(packageDiv);

                });
            })

            modal.style.display = "block";
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        })

        const deleteProfile = document.querySelectorAll('.delete-icon');
        const modalContainer = document.querySelector('.delete-modal-container');
        
        // delete package confirmation modal
        function openModal(event) {
            event.stopPropagation(); // prevents bubbling the parent element
            modalContainer.classList.add('show');
            console.log("Delete button clicked");
        }
    
        function closeModal() {
            modalContainer.classList.remove('show');
            console.log("Close button clicked");
        }  
        

        if (deleteProfile && modalContainer) {
            deleteProfile.forEach(button => {
                button.addEventListener('click', openModal);
            })

            // Close modal when clicking cancel button
            cancelButton.addEventListener('click', closeModal);

            deleteButton.addEventListener('click', (packageID) => {
                fetch('/packages/delete/' + packageID, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {

                    if (response.status === 204) {
                        showNotification(" There is no package for this packageID", "red");
                    }
                    if (!response.ok) {
                        if (response.status === 409) {
                            closeModal();
                            showNotification(" This package is currently in use", "red");
                            return
                        }

                    }
                })

                showNotification("Profile deleted", "red");
                window.location.href = '/register';
                closeModal();
            })

            // Close modal when clicking outside
            modalContainer.addEventListener('click', (event) => {
                if (event.target === modalContainer) {
                    closeModal();
                }
            });
        
            // Close modal with Escape key
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modalContainer.classList.contains('show')) {
                    closeModal();
                }
            });
        }


        function openUpdateModal(packageID) { 
            console.log(packageID);
            const package = vendorData.packages[packageID];
            console.log(package);
            const modal = document.getElementById("modal");
            const modalContent = document.getElementById("modal-content");

            let changedGeneralFields = {};
            let changedSpecificFields = {};

            modalContent.innerHTML = `
                        <span class="close">&times;</span>
                        <h2>Update Package</h2>
                        <form id="updateForm">
                            <div class="input-group general">
                                <label for="packageName">Package Name</label>
                                <input type="text" id="packageName" name="packageName" value=${package.packageName} required>
                            </div>
                            <div class="input-group general">
                                <label for="feature1">Feature 1</label>
                                <input type="text" id="feature1" name="feature1" value=${package.feature1} required>
                            </div>
                            <div class="input-group general">
                                <label for="feature2">Feature 2</label>
                                <input type="text" id="feature2" name="feature2" value=${package.feature2}>
                            </div>
                            <div class="input-group general">
                                <label for="feature3">Feature 3</label>
                                <input type="text" id="feature3" name="feature3" value=${package.feature3}>
                            </div>
                            <div class="input-group general">
                                <label for="fixedCost">Fixed Cost</label>
                                <input type="text" id="fixedCost" name="fixedCost" value=${package.fixedCost} required>
                            </div>
                            <div class="submit-button">
                                <button type="submit">Submit</button>
                            </div>
                        </form>
                            `;
            vendorDisplayFunctions[vendorData.typeID](package, modalContent);
            modalContent.querySelectorAll(".general").forEach((input) => {
                input.addEventListener("change", (event) => {
                    const { name, value } = event.target;
                    changedGeneralFields[name] = value;
                    console.log(`changedPackageFields`);
                });
            });

            modalContent.querySelectorAll(".specific").forEach((input) => {
                input.addEventListener("change", (event) => {
                    const { name, value } = event.target;
                    changedSpecificFields[name] = value;
                    console.log(changedPackageFields);
                });
            });

            modalContent.querySelector("#updateForm").addEventListener("submit", async (event) => {
                event.preventDefault();
                const updateFields = {
                    'typeID': vendorData.typeID,
                    changedGeneralFields,
                    changedSpecificFields
                }
                fetch('/vendor/' + vendorID + '/update-package/' + packageID, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(updateFields),
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    } else {
                        return response.json();
                    }
                }).catch(error => {
                    console.error('Error updating package:', error);
                });
            })
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
        loadingScreen.style.display = "none";
        mainContent.style.display = "block";
    }).catch(error => {
        console.error('Error fetching data early:', error)
        loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
    });

});

const createPhotographerPackage = (modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `
        <div class="input-group spcific">
            <label for="cameraCoverage">Camera Coverage</label>
            <input type="text" id="cameraCoverage" name="cameraCoverage"  required>
        </div>`
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);
};

const createDressDesignerPackage = (modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `
                <div class="input-group specific">
            <label for="theme">Theme</label>
            <input type="text" id="theme" name="theme"  required>
        </div>
        <div class="input-group specific">
            <label for="variableCost">Cost per Group Member</label>
            <input type="text" id="variableCost" name="variableCost" required>
        </div>
        <div class="input-group specific">
            <label for="dempgraphic">Demographic</label>
            <select id="demographic" name="demographic"  required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Both">Both</option>
            </select>
        </div>
        </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);

};

const createSalonPackage = (modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `
                <div class="input-group specific">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" required>
                            </div>
                            <div class="input-group specific">
                                <label for="dempgraphic">Demographic</label>
                                <select id="demographic" name="demographic" required>
                                    <option value="Bride">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);

};

const createFloristPackage = (modalContent) => {
    const div = document.createElement("div");
    div.innerHTML += `
                <div class="input-group specific">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" required>
                            </div>
                            <div class="input-group specific">
                                <label for="flowerType">Type of Flowers</label>
                                <select id="flowerType" name="flowerType" required>
                                    <option value="Artificial">Artificial</option>
                                    <option value="Fresh">Fresh</option>
                                </select>
                            </div>
                            </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);


};

const vendorCreatePackageFunctions = {
    'Photographer': createPhotographerPackage,
    'Dress Designer': createDressDesignerPackage,
    'Salon': createSalonPackage,
    'Florist': createFloristPackage
}



const displayPhotographerPackage = (packageDetails, modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `<div class="input-group specific">
                                <label for="cameraCoverage">Camera Coverage</label>
                                <input type="text" id="cameraCoverage" name="cameraCoverage" value=${packageDetails.cameraCoverage} required>
                            </div>
                            </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);

}
const displayDressDesignerPackage = (packageDetails, modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `<div class="input-group specific">
                                <label for="theme">Theme</label>
                                <input type="text" id="theme" name="theme" value=${packageDetails.theme} required>
                            </div>
                            <div class="input-group specific">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" value=${packageDetails.variableCost} required>
                            </div>
                            <div class="input-group specific">
                                <label for="dempgraphic">Demographic</label>
                                <select id="demographic" name="demographic" value="${packageDetails.demographic}" required>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);

}
const displaySalonPackage = (packageDetails, modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `
                <div class="input-group specific">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" value=${packageDetails.variableCost} required>
                            </div>
                            <div class="input-group specific">
                                <label for="dempgraphic">Demographic</label>
                                <select id="demographic" name="demographic" value="${packageDetails.demographic}" required>
                                    <option value="Bride">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);

}
const displayFloristPackage = (packageDetails, modalContent) => {
    const div = document.createElement("div");
    div.innerHTML = `
                <div class="input-group specific">
                                <label for="variableCost">Cost per Group Member</label>
                                <input type="text" id="variableCost" name="variableCost" value=${packageDetails.variableCost} required>
                            </div>
                            <div class="input-group specific">
                                <label for="flowerType">Type of Flowers</label>
                                <select id="flowerType" name="flowerType" value="${packageDetails.flowerType}" required>
                                    <option value="Artificial">Artificial</option>
                                    <option value="Fresh">Fresh</option>
                                </select>
                            </div>
                            </form > `;
    modalContent.querySelector(".submit-button").insertAdjacentElement("beforebegin", div);

}

const vendorDisplayFunctions = {
    'Photographer': displayPhotographerPackage,
    'Dress Designer': displayDressDesignerPackage,
    'Salon': displaySalonPackage,
    'Florist': displayFloristPackage
}




