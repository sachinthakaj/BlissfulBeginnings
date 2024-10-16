const bride = {
    name: "Jane Doe",
    email: "jane.doe@example.com",
    contact: "123-456-7890"
};

const groom = {
    name: "John Smith",
    email: "john.smith@example.com",
    contact: "098-765-4321"
};

const wedding = {
    date : "2025-01-01",
    location: "Hilton Colombo",
    theme: "Traditional"
}

const package = {
    name: "Eternal Elegancce",
    level: "Gold",
    price: "1,500,000.00"
}

/*
### **Gold Package: "Eternal Elegance"**
- **Price:** LKR 1,500,000
- **Description:** A luxurious and comprehensive wedding experience that includes premium services and exquisite details to create a truly unforgettable day.

### **Silver Package: "Radiant Romance"**
- **Price:** LKR 1,000,000
- **Description:** A beautifully curated package that offers elegance and charm, perfect for couples looking for a romantic and stylish celebration.

### **Bronze Package: "Charming Beginnings"**
- **Price:** LKR 700,000
- **Description:** A delightful and budget-friendly package that covers all the essentials for a memorable and charming wedding day.
*/

function updateBrideGroomDetails() {
    document.getElementById('bride-name').textContent = bride.name;
    document.getElementById('groom-name').textContent = groom.name;

    document.getElementById('bride-details-name').textContent = bride.name;
    document.getElementById('bride-email').textContent = bride.email;
    document.getElementById('bride-contact').textContent = bride.contact;

    document.getElementById('groom-details-name').textContent = groom.name;
    document.getElementById('groom-email').textContent = groom.email;
    document.getElementById('groom-contact').textContent = groom.contact;

    document.getElementById('wedding-date').textContent = wedding.date;
    document.getElementById('wedding-location').textContent = wedding.location;
    document.getElementById('wedding-theme').textContent = wedding.theme;

    document.getElementById('package-name').textContent = package.name;
    document.getElementById('package-level').textContent = package.level;
    document.getElementById('package-price').textContent = package.price;
}

updateBrideGroomDetails();
