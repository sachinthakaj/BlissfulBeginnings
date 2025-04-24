const path = window.location.pathname;
const pathParts = path.split('/');
const vendorID = pathParts[pathParts.length - 1];


const mainContainer = document.querySelector('.main-container');


function createPackageCard(packageID, packageData) {
    // Create main container
    const cardElement = document.createElement('div');
    cardElement.className = 'wed-package-card';
    cardElement.id = `${packageID}`;
    cardElement.dataset.packageId = packageID; // Add data attribute for easy selection
    
    // Create delete button
    const deleteButton = document.createElement('button');
    deleteButton.className = 'wed-package-delete-btn delete-icon';
    deleteButton.setAttribute('aria-label', 'Delete package');
    deleteButton.dataset.packageid = packageID;
    cardElement.appendChild(deleteButton);
    
    // Create package header
    const headerElement = document.createElement('div');
    headerElement.className = 'wed-package-header';
    
    const nameElement = document.createElement('h3');
    nameElement.className = 'wed-package-name';
    nameElement.textContent = packageData.packageName;
    headerElement.appendChild(nameElement);
    
    
    // Create business section
    const businessElement = document.createElement('div');
    businessElement.className = 'wed-package-business';
    
    const iconElement = document.createElement('img');
    iconElement.className = 'wed-package-icon';
    iconElement.src = "http://cdn.blissfulbeginnings.com/" + packageData.path;
    iconElement.alt = `${packageData.businessName} Icon`;
    businessElement.appendChild(iconElement);
    
    // Create features list
    const featuresElement = document.createElement('ul');
    featuresElement.className = 'wed-package-features';
    
    // Add feature1 (required)
    if (packageData.feature1) {
        const featureItem = document.createElement('li');
        featureItem.className = 'wed-package-feature-item';
        featureItem.textContent = packageData.feature1;
        featuresElement.appendChild(featureItem);
    }
    
    // Add feature2 (optional)
    if (packageData.feature2) {
        const featureItem = document.createElement('li');
        featureItem.className = 'wed-package-feature-item';
        featureItem.textContent = packageData.feature2;
        featuresElement.appendChild(featureItem);
    }
    
    // Add feature3 (optional)
    if (packageData.feature3) {
        const featureItem = document.createElement('li');
        featureItem.className = 'wed-package-feature-item';
        featureItem.textContent = packageData.feature3;
        featuresElement.appendChild(featureItem);
    }
    
    // Create cost section
    const costElement = document.createElement('div');
    costElement.className = 'wed-package-cost';
    
    const priceElement = document.createElement('p');
    priceElement.className = 'wed-package-price';
    
    // Format price in LKR
    const price = typeof packageData.fixedCost === 'number' 
        ? `LKR ${packageData.fixedCost.toLocaleString()}` 
        : `LKR ${packageData.fixedCost}`;
        
    priceElement.textContent = price;
    costElement.appendChild(priceElement);
    
    const labelElement = document.createElement('p');
    labelElement.className = 'wed-package-label';
    labelElement.textContent = 'Fixed Package Price';
    costElement.appendChild(labelElement);
    
    // Assemble the card
    cardElement.appendChild(headerElement);
    cardElement.appendChild(businessElement);
    cardElement.appendChild(featuresElement);
    cardElement.appendChild(costElement);
    
    return cardElement;
  }
  

document.addEventListener("DOMContentLoaded", () => {
    const loadingScreen = document.getElementById("loading-screen");
    const mainContent = document.getElementById("main-content");
    fetch('/vendor/vendor-details/' + vendorID, {
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
        document.getElementById("profile-image").setAttribute("src", "http://cdn.blissfulbeginnings.com" +vendorData.imgSrc);

       


        const packagesContainer = document.getElementById('packages-container');

        Object.entries(vendorData.packages).forEach(([packageID, package]) => {
            const packageDiv = createPackageCard(packageID, package);
            packagesContainer.appendChild(packageDiv);
        });


       

        loadingScreen.style.display = "none";
        mainContent.style.display = "block";
    }).catch(error => {
        console.error('Error fetching data early:', error)
        loadingScreen.innerHTML = "<p>Error loading data. Please try again later.</p>";
    });

});




document.addEventListener("DOMContentLoaded", fetchVendorGallery);

function fetchVendorGallery() {
  fetch("http://cdn.blissfulbeginnings.com/gallery/upload/" + vendorID, {
    method: "GET",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        console.error("Error fetching images:", data.error);
        return;
      }

      const galleryContainer = document.getElementById("gallery-container");

      
      data.forEach((image) => {
        const imgDiv = document.createElement("div");
        imgDiv.path = image.path;
        imgDiv.classList.add("gallery-item");
        imgDiv.style.position = "relative"; // Ensure relative positioning for absolute child elements

        const imgElement = document.createElement("img");
        imgElement.src = "http://cdn.blissfulbeginnings.com/" + image.path;
        imgElement.alt = image.description;
        imgElement.classList.add("gallery-img");
        imgDiv.dataset.packageid = image.packageID ? image.packageID : "";

        const desc = document.createElement("p");
        desc.textContent = image.description;
        imgDiv.appendChild(imgElement);
        imgDiv.appendChild(desc);
        galleryContainer.appendChild(imgDiv);
      });
    })
    .catch((error) => console.error("Error:", error));
}


