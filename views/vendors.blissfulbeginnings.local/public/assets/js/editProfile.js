document.addEventListener("DOMContentLoaded", () => {
    fetchData();
});

async function fetchData() {
    try {
        const response = await fetch('/api/vendor-profile'); // Replace with your API endpoint
        const data = await response.json();

        // Update the title
        document.getElementById('title').textContent = data.title || 'Trident Media';

        // Generate packages
        const packagesContainer = document.getElementById('packages-container');
        packagesContainer.innerHTML = ''; // Clear any existing content

        data.packages.forEach(package => {
            const packageDiv = document.createElement('div');
            packageDiv.classList.add('package');

            packageDiv.innerHTML = `
                <div class="details">
                    <div>${package.name}</div>
                    <div>What's Included:</div>
                    <ul>
                        ${package.features.map(feature => `<li>${feature}</li>`).join('')}
                    </ul>
                    <div class="price">${package.price}</div>
                </div>
            `;

            packagesContainer.appendChild(packageDiv);
        });
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}
