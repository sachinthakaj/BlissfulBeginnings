const path = window.location.pathname;
const pathParts = path.split("/");
const vendorID = pathParts[pathParts.length - 1];

const mainContainer = document.querySelector(".main-container");

document.addEventListener("DOMContentLoaded", () => {
  const loadingScreen = document.getElementById("loading-screen");
  const mainContent = document.getElementById("main-content");
  fetch("/vendor/vendor-details/" + vendorID, {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.status == 401) {
        window.location.href = "/signin";
      } else if (response.status == 200) {
        return response.json();
      } else {
        throw new Error("Network response was not ok");
      }
    })
    .then((vendorData) => {
      document.getElementById("business-name").textContent = vendorData.businessName;
      if (vendorData.vendorstate === "new") {
        const bar = document.createElement("div");
        bar.classList.add("bottom-bar");
        bar.style.position = "fixed";
        bar.style.bottom = "0";
        bar.style.width = "100%";
        bar.style.background = "white";
        bar.innerHTML = `
                <p>Do you want to accept or reject this vendor?</p>
                <button class="accept-button">Accept</button>
                <button class="reject-button">Reject</button>
            `;

        document.body.appendChild(bar);
        document
          .querySelector(".accept-button")
          .addEventListener("click", () => {
            fetch("/vendor/" + vendorID + "/accept", {
              method: "GET",
              headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem("authToken")}`,
              },
            })
              .then((response) => {
                if (response.status == 401) {
                  window.location.href = "/signin";
                  throw error;
                } else if (response.status == 200) {
                  alert("Vendor accepted successfully");
                  bar.remove();
                }
              })
              .catch((error) => {
                console.error("Error accepting vendor:", error);
                alert("Error accepting vendor");
              });
          });
        document
          .querySelector(".reject-button")
          .addEventListener("click", () => {
            fetch("/vendor/" + vendorID + "/reject", {
              method: "GET",
              headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem("authToken")}`,
              },
            })
              .then((response) => {
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
              })
              .then(() => {
                alert("Vendor rejected successfully");
                window.location.href = "/plannerDashboard/";
              })
              .catch((error) => {
                console.error("Error rejecting vendor:", error);
                alert("Error rejecting vendor");
              });
          });
      }
      console.log(vendorData);
      // update title and description
      document.getElementById("description").textContent =
        vendorData.description;
      document.getElementById("profile-image").setAttribute("src", "http://cdn.blissfulbeginnings.com" + vendorData.imgSrc);

      console.log(vendorData.packages);
      const packagesContainer = document.getElementById("packages-container");

      Object.entries(vendorData.packages).forEach(([packageID, package]) => {
        const packageDiv = document.createElement("div");
        packageDiv.classList.add("package");
        packageDiv.setAttribute("id", packageID);
        packageDiv.innerHTML = `
                <div class="details">
                    <div>${package.packageName}</div>
                    <div>What's Included:</div>
                      <ul>
                          <li>${package.feature1}</li>
                              ${package.feature2
            ? `<li>${package.feature2}</li>`
            : ""
          }
                              ${package.feature3
            ? `<li>${package.feature3}</li>`
            : ""
          }
                      </ul>
                    <div class="price">${package.fixedCost} LKR</div>
                </div>
                `;
        packagesContainer.appendChild(packageDiv);
      });

      loadingScreen.style.display = "none";
      mainContent.style.display = "block";
    })
    .catch((error) => {
      console.error("Error fetching data early:", error);
      loadingScreen.innerHTML =
        "<p>Error loading data. Please try again later.</p>";
    });
});

const displayPhotographerPackage = (packageDetails, modalContent) => {
  modalContent.innerHTML += `<div class="input-group">
                                <label for="cameraCoverage">Camera Coverage</label>
                                <input type="text" id="cameraCoverage" name="cameraCoverage" value=${packageDetails.cameraCoverage} required>
                            </div>
                            </form>`;
};
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
};
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
};
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
};

const vendorDisplayFunctions = {
  Photographer: displayPhotographerPackage,
  "Dress Designer": displayDressDesignerPackage,
  Salon: displaySalonPackage,
  Florist: displayFloristPackage,
};


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
