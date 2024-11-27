const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];


const mainContainer = document.querySelector('.main-container');

document.addEventListener("DOMContentLoaded", () => {
    const loadingScreen = document.getElementById("loading-screen");
    const mainContent = document.getElementById("main-content");
    fetch('/vendor/vendor-details/' + vendorID, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
            'Content-Type': 'application/json'
        },
    }).then(response => {

        return response.json();
    }).then(vendorData => {
        if (vendorData.vendorstate === 'new') {
            const bar = document.createElement('div');
            bar.classList.add('bottom-bar');
            bar.style.position = 'fixed';
            bar.style.bottom = '0';
            bar.style.width = '100%';
            bar.style.background = 'white';
            bar.innerHTML = `
                <button class="accept-button">Accept</button>
                <button class="reject-button">Reject</button>
            `;
            document.body.appendChild(bar);
            document.querySelector('.accept-button').addEventListener('click', () => {
                fetch('/vendor/' + vendorID + '/accept', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                }).then(() => {
                    alert('Vendor accepted successfully');
                }).catch(error => {
                    console.error('Error accepting vendor:', error)
                    alert('Error accepting vendor');
                });
            })
            document.querySelector('.reject-button').addEventListener('click', () => {
                fetch('/vendor/' + vendorID + '/reject', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                }).then(() => {
                    alert('Vendor rejected successfully');
                }).catch(error => {
                    console.error('Error rejecting vendor:', error)
                    alert('Error rejecting vendor');
                });
            })
        }
        console.log(vendorData)
        // update title and description
        document.getElementById('name').textContent = vendorData.name;
        document.getElementById('description').textContent = vendorData.description;
        document.getElementById("profile-image").setAttribute("src", vendorData.image);

       

        console.log(vendorData.packages);
        const packagesContainer = document.getElementById('packages-container');

        Object.entries(vendorData.packages).forEach(([packageID, package]) => {
            const packageDiv = document.createElement('div');
            packageDiv.classList.add('package');
            packageDiv.setAttribute("id", packageID);
            packageDiv.innerHTML = `
                <div class="details">
                    <div>${package.name}</div>
                    <div>What's Included:</div>
                    <ul>
                         <li>${package.feature1}</li>
                            ${package.feature2 ? `<li>${package.feature2}</li>` : ''}
                            ${package.feature3 ? `<li>${package.feature3}</li>` : ''}
                    </ul>
                    <div class="price">${package.fixedCost}</div>
                </div>
                `;
            packagesContainer.appendChild(packageDiv);
        });


       

        loadingScreen.style.display = "none";
        mainContent.style.display = "block";
    }).catch(error => {
        console.error('Error fetching data early:', error)
        loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
    });

});


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




