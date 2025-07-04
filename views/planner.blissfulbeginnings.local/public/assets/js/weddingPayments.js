const path = window.location.pathname;
const pathParts = path.split("/");
const assignmentID = pathParts[pathParts.length - 1];
const weddingID = pathParts[pathParts.length - 2];

document.addEventListener("DOMContentLoaded", function () {
  const Container = document.querySelector(".container");
  const checkoutContainer = document.querySelector(".checkout_container");

  fetch(`/fetch-pakageData-to-pay/${assignmentID}`, {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("authToken")}`,
      "Content-Type": "application/json",
    },
  })
    .then((res) => {
      if (res.status === 401) {
        window.location.href = "/signin";
      } else if (res.status === 200) {
        return res.json();
      } else {
        throw new Error("Network response was not ok");
      }
    })
    .then((package) => {
      console.log("Package Data:", package);

      const card = document.createElement("div");
      card.classList.add("package-card");

      const cardTitle = document.createElement("div");
      cardTitle.classList.add("card_title");
      card.appendChild(cardTitle);
      cardTitle.innerHTML = `<h3>${package.packageName}</h3>`;

      const cardContent = document.createElement("div");
      cardContent.classList.add("card_content");
      card.appendChild(cardContent);

      const contentImage = document.createElement("div");
      contentImage.classList.add("content_image");
      cardContent.appendChild(contentImage);
      contentImage.innerHTML = `
  <img 
    src="https://thesposagroupbride.com.au/wp-content/uploads/2023/12/1093_0145-800x1000.jpg" 
    alt="Wedding Package Image"
    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
  >`;

      const contentDescription = document.createElement("div");
      contentDescription.classList.add("content_description");
      cardContent.appendChild(contentDescription);

      const contentDescriptionText = document.createElement("div");
      contentDescriptionText.classList.add("content_description_text");
      contentDescription.appendChild(contentDescriptionText);
      contentDescriptionText.innerHTML = `
  <ul style="list-style-type: none; padding: 0; margin: 0;">
    ${Object.keys(package)
      .filter(key => key.startsWith('feature') && package[key])
      .map(feature => `
        <li style="
          padding: 8px 0;
          display: flex;
          align-items: flex-start;
          gap: 10px;
        ">
          <span style="
            color: #6366f1;
            font-size: 14px;
            margin-top: 4px;
          ">❖</span>
          <span style="flex: 1;">${package[feature]}</span>
        </li>
      `).join('')}
  </ul>
`;

      const checkoutCard = document.createElement("div");
      checkoutCard.classList.add("checkout_card");

      const checkoutCardDetails = document.createElement("div");
      checkoutCardDetails.classList.add("checkout_card_details");
      checkoutCardDetails.innerHTML = `<p><B>Total:LKR ${package.price}</B></p>`;
      checkoutCard.appendChild(checkoutCardDetails);

      const checkoutCardAction = document.createElement("div");
      checkoutCardAction.classList.add("checkout_card_action");
      checkoutCard.appendChild(checkoutCardAction);

      const checkoutButton = document.createElement("button");
      checkoutButton.classList.add("checkoutButton");

      const checkoutButtonText = document.createElement("div");
      checkoutButtonText.classList.add("checkoutButtonText");
      checkoutButtonText.innerHTML = "<p>Checkout</p>";
      checkoutButton.appendChild(checkoutButtonText);

      
      payhere.onCompleted = function onCompleted(orderId) {
        alert("Payment successful!");
        window.location.href = `/wedding/${weddingID}`;
      };

      payhere.onDismissed = function onDismissed() {
        console.log("Payment dismissed.");
        alert("Payment dismissed.");
      };

      payhere.onError = function onError(error) {
        console.log("Error:", error);
        alert("An error occurred during payment.");
      };

      checkoutButton.onclick = function () {
        
        fetch(`/fetch-hash-for-paymentGateway/${assignmentID}`, {
          method: "GET",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            "Content-Type": "application/json",
          },
        })
          .then((res) => {
            if (res.status === 401) {
              window.location.href = "/signin";
            } else if (res.status === 200) {
              return res.json();
            } else {
              throw new Error("Failed to fetch hash for payment gateway");
            }
          })
          .then((Response) => {
            const hash = Response.hash;
            var payment = {
              sandbox: true,
              merchant_id: "1228991", 
              return_url: `http://planner.blissfulbeginnings.com/wedding/${weddingID}`,
              cancel_url: `http://planner.blissfulbeginnings.com/wedding/${weddingID}/payments/${assignmentID}`,
              notify_url: `https://blissfulbeginnings.loca.lt/plannerPaymentData`,
              order_id: Response.orderID,
              items: package.packageName,
              amount: package.price,
              currency: "LKR",
              hash: hash, 
              first_name: "Jehan",
              last_name: "Fernando",
              email: "jehan@gmail.com",
              phone: "0781234567",
              address: "Reid Avenue",
              city: "Colombo 07",
              country: "Sri Lanka",
              custom_1: assignmentID,
            };

            
            payhere.startPayment(payment);

            
          })
          .catch((error) => {
            console.error("Error fetching hash:", error);
            alert("Failed to fetch hash for payment. Please try again.");
          });
      };

      Container.appendChild(card);
      checkoutContainer.appendChild(checkoutCard);
      checkoutCardAction.appendChild(checkoutButton);
    })
    .catch((error) => {
      console.error("Error fetching package data:", error);
      alert("Failed to fetch package data. Please try again.");
    });
});
