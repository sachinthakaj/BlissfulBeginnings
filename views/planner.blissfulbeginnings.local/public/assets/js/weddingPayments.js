const path = window.location.pathname;
const pathParts = path.split("/");
const assignmentID = pathParts[pathParts.length - 1];
const weddingID = pathParts[pathParts.length - 2];

document.addEventListener("DOMContentLoaded", function () {
  const Container = document.querySelector(".container");

  fetch(`/fetch-pakageData-to-pay/${assignmentID}`, {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((res) => {
      if (res.status == 401) {
        window.location.href = "/signin";
      } else if (res.status == 200) {
        return res.json();
      } else {
        throw new Error("Network response was not ok");
      }
    })
    .then((package) => {
      console.log(package);

      const card = document.createElement("div");
      card.classList.add("package-card");
      card.innerHTML = `
        <h3>${package.packageName} </h3>
        <p>${package.feature1}</p>
        <p>${package.feature2}</p>
        <p>${package.feature3}</p>
        <p>${package.fixedCost}</p>
       
   
   `;

      const checkoutButton = document.createElement("button");
      checkoutButton.classList.add("checkoutButton");
      checkoutButton.innerHTML = "<p>Checkout</p>";

      payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        // Note: validate the payment and show success or failure page to the customer
      };

      // Payment window closed
      payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        console.log("Payment dismissed");
      };

      // Error occurred
      payhere.onError = function onError(error) {
        // Note: show an error page
        console.log("Error:" + error);
      };

      // Put the payment variables here
      var payment = {
        sandbox: true,
        merchant_id: "1228991", // Replace your Merchant ID
        return_url: undefined, // Important
        cancel_url: undefined, // Important
        notify_url: "http://sample.com/notify",
        order_id: "ItemNo12345",
        items: package.packageName,
        amount: package.fixedCost,
        currency: "LKR",
        hash: "45D3CBA93E9F2189BD630ADFE19AA6DC", // *Replace with generated hash retrieved from backend
        first_name: "Saman",
        last_name: "Perera",
        email: "samanp@gmail.com",
        phone: "0771234567",
        address: "No.1, Galle Road",
        city: "Colombo",
        country: "Sri Lanka",
        delivery_address: "No. 46, Galle road, Kalutara South",
        delivery_city: "Kalutara",
        delivery_country: "Sri Lanka",
        custom_1: "",
        custom_2: "",
      };

      checkoutButton.onclick = function () {
        payhere.startPayment(payment);
      };
      card.appendChild(checkoutButton);
      Container.appendChild(card);
    })
    .catch((error) => {
      console.error("Error fetching package data:", error);
    });
});
