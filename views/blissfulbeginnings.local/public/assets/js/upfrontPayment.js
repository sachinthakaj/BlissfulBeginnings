const path = window.location.pathname;
const pathParts = path.split("/");
const weddingID = pathParts[pathParts.length - 1];

document.addEventListener("DOMContentLoaded", function () {
  const Container = document.querySelector(".container");
  const checkoutContainer = document.querySelector(".checkout_container");

  fetch(`/get_upfront_amount_pay_customer/${weddingID}`, {
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
    .then((amount) => {
      console.log(amount);
      const checkoutCard = document.createElement("div");
      checkoutCard.classList.add("checkout_card");

      const checkoutCardDetails = document.createElement("div");
      checkoutCardDetails.classList.add("checkout_card_details");
      checkoutCardDetails.innerHTML = `<p><B>Total:LKR ${amount}</B></p>`;
      checkoutCard.appendChild(checkoutCardDetails);

      const checkoutCardAction = document.createElement("div");
      checkoutCardAction.classList.add("checkout_card_action");
      checkoutCard.appendChild(checkoutCardAction);

      const checkoutButton = document.createElement("button");
      checkoutButton.classList.add("checkoutButton");

      const checkoutButtonText = document.createElement("div");
      checkoutButtonText.classList.add("checkoutButtonText");
      checkoutButtonText.innerHTML = "<p>Pay</p>";
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
        
        fetch(`/fetch-hash-for-upfrontpaymentGateway/${weddingID}`, {
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
              return_url: `http://blissfulbeginnings.com/wedding/upFrontpayment/${weddingID}`, 
              cancel_url: `http://blissfulbeginnings.com/wedding/upFrontpayment/${weddingID}`, 
              
              notify_url: `https://blissfulbeginnings.loca.lt/customerUpfrontPaymentData`,
              order_id: Response.orderID,
              items: "Wedding Up Front Payment",
              amount: Response.amount,
              currency: "LKR",
              hash: hash, 
              first_name: "",
              last_name: "",
              email: "",
              phone: "",
              address: "",
              city: "",
              country: "",
              custom_1: weddingID,
            };

            
            payhere.startPayment(payment);
          })
          .catch((error) => {
            console.error("Error fetching hash:", error);
            alert("Failed to fetch hash for payment. Please try again.");
          });
      };

      
      checkoutContainer.appendChild(checkoutCard);
      checkoutCardAction.appendChild(checkoutButton);
    })
    .catch((error) => {
      console.error("Error fetching package data:", error);
      alert("Failed to fetch package data. Please try again.");
    });

  fetch(`/get_packagenames_for_payments/${weddingID}`, {
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
    .then((packages) => {
      console.log(packages);
      const card = document.createElement("div");
      card.classList.add("package-card");
      Container.appendChild(card);

      const contentDescription = document.createElement("div");
      contentDescription.classList.add("content_description");
      card.appendChild(contentDescription);

      const contentDescriptionText = document.createElement("div");
      contentDescriptionText.classList.add("content_description_text");
      contentDescription.appendChild(contentDescriptionText);

     
      contentDescriptionText.innerHTML = `
      <ul style="
        list-style-type: none; 
        padding: 0; 
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 15px;
      ">
        ${packages
          .map(
            (pkg) => `
          <li style="
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(99, 102, 241, 0.1);
            position: relative;
            overflow: hidden;
          ">
            <div style="
              display: flex;
              align-items: center;
              gap: 10px;
            ">
              <span style="
                color: #6366f1;
                font-size: 16px;
                line-height: 1;
              ">✦</span>
              <span style="
                font-weight: 600;
                font-size: 18px;
                color: #2d3748;
                font-family: 'Poppins', sans-serif;
              ">${pkg.packageName}</span>
            </div>
            
            <span style="
              color: #6366f1;
              font-size: 16px;
              font-weight: 500;
              display: flex;
              align-items: center;
              gap: 4px;
              margin-left: 26px;
            ">
              <span style="
                font-size: 14px;
                color: #718096;
              ">Cost:</span>
              LKR ${pkg.price.toLocaleString()}
            </span>
          </li>
        `
          )
          .join("")}
      </ul>
    `;
    });
});
