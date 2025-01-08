const path = window.location.pathname;
const pathParts = path.split("/");
const assignmentID = pathParts[pathParts.length - 1];
const weddingID = pathParts[pathParts.length - 2];

document.addEventListener("DOMContentLoaded", function () {
  const Container = document.querySelector(".container");

  // Fetch package data
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
      card.innerHTML = `
        <h3>${package.packageName}</h3>
        <p>${package.feature1}</p>
        <p>${package.feature2}</p>
        <p>${package.feature3}</p>
        <p>Cost: ${package.fixedCost}</p>
      `;

      const checkoutButton = document.createElement("button");
      checkoutButton.classList.add("checkoutButton");
      checkoutButton.innerHTML = "<p>Checkout</p>";

      // PayHere callbacks
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
        // Fetch hash for the payment gateway
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
            

            // Correctly assign hash from response

            // Prepare payment object
            var payment = {
              sandbox: true,
              merchant_id: "1228991", // Replace your Merchant ID
              return_url: `http://planner.blissfulbeginnings.com/wedding/${weddingID}`, // Important
              cancel_url: `http://planner.blissfulbeginnings.com/wedding/${weddingID}/${assignmentID}`, // Important
              // notify_url: `https://01jgnmtzfbspgkw5vx8ry3n7pf00-95b3dd672bc15808c447.requestinspector.com/wedding/${weddingID}/${assignmentID}/paymentData`,
              notify_url: `https://blissfulbeginnings.loca.lt/plannerPaymentData`,
              order_id: Response.orderID,
              items: package.packageName,
              amount: package.fixedCost,
              currency: "LKR",
              hash: hash, // *Replace with generated hash retrieved from backend
              first_name: "Jehan",
              last_name: "Fernando",
              email: "jehan@gmail.com",
              phone: "0781234567",
              address: "Reid Avenue",
              city: "Colombo 07",
              country: "Sri Lanka",
              custom_1: assignmentID
              
            };

            // Start payment
            payhere.startPayment(payment);

            fetch(`wedding/${weddingID}/${assignmentID}/paymentData`, {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
              },
              body: JSON.stringify(payment),
            })
              .then((res) => {
                if (res.status === 401) {
                  window.location.href = "/signin";
                }
                if (res.status === 200) {
                  return res.json();
                }
              })
              .then((data) => {
                if (data.status === "success") {
                  alert(data.message);
                  window.location.reload();
                } else {
                  alert("Error: " + data.message);
                }
              })
              .catch((error) => {
                console.error("Error recording payment data:", error);
              });
          })
          .catch((error) => {
            console.error("Error fetching hash:", error);
            alert("Failed to fetch hash for payment. Please try again.");
          });
      };

      card.appendChild(checkoutButton);
      Container.appendChild(card);
    })
    .catch((error) => {
      console.error("Error fetching package data:", error);
      alert("Failed to fetch package data. Please try again.");
    });
});
