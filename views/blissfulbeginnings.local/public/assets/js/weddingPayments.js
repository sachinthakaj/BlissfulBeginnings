const path = window.location.pathname;
const pathParts = path.split("/");
const weddingID = pathParts[pathParts.length - 1];

document.addEventListener("DOMContentLoaded", function () {
  const Container = document.querySelector(".container");
  const checkoutContainer = document.querySelector(".checkout_container");

  fetch(`/get_ongoing_payments/${weddingID}`, {
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
    .then((result) => {
      console.log(result);
      const confirmationContainer = document.createElement("div");
      confirmationContainer.classList.add("confirmation-container");

      const confirmationDetails = document.createElement("div");
      confirmationDetails.classList.add("confirmation-details");
      confirmationDetails.innerHTML = `
            <h3>Payment Confirmation</h3>
            <p>Amount to Pay: LKR ${result.amount}</p>
        `;

      const conformationActions = document.createElement("div");
      conformationActions.classList.add("conformation-actions");

      const confirmCheckoutButton = document.createElement("button");
      confirmCheckoutButton.classList.add("confirm-checkout-button");
      confirmCheckoutButton.innerHTML = "Pay Now";
      conformationActions.appendChild(confirmCheckoutButton);

      const confirmCancelButton = document.createElement("button");
      confirmCancelButton.classList.add("confirm-cancel-button");
      confirmCancelButton.innerHTML = "Cancel";
      conformationActions.appendChild(confirmCancelButton);

      confirmationContainer.appendChild(confirmationDetails);
      confirmationContainer.appendChild(conformationActions);
      document.querySelector(".right-page").appendChild(confirmationContainer);

      const paymentID = result.paymentID;

      payhere.onCompleted = function onCompleted(orderId) {
        alert("Payment successful!");
        window.location.reload();
      };

      payhere.onDismissed = function onDismissed() {
        console.log("Payment dismissed.");
        alert("Payment dismissed.");
      };

      payhere.onError = function onError(error) {
        console.log("Error:", error);
        alert("An error occurred during payment.");
      };

      confirmCheckoutButton.addEventListener("click", function () {
        fetch(`/fetch-hash-for-paymentGateway/${weddingID}`, {
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
            console.log(Response);
            const hash = Response.hash;

            // Correctly assign hash from response

            // Prepare payment object
            var payment = {
              sandbox: true,
              merchant_id: "1228991", // Replace your Merchant ID
              return_url: `http://blissfulbeginnings.com/wedding/payment/${weddingID}`,
              cancel_url: `http://blissfulbeginnings.com/wedding/payment/${weddingID}`,
              notify_url: `https://blissfulbeginnings.loca.lt/customerPaymentData`,
              order_id: Response.orderID,
              items: "Wedding Payment",
              amount: Response.amount,
              currency: "LKR",
              hash: hash, // *Replace with generated hash retrieved from backend
              first_name: "",
              last_name: "",
              email: "",
              phone: "",
              address: "",
              city: "",
              country: "",
              custom_1: Response.paymentID,
              custom_2: weddingID,
            };

            // Start payment
            payhere.startPayment(payment);
          })
          .catch((error) => {
            console.error("Error fetching hash:", error);
            alert("Failed to fetch hash for payment. Please try again.");
          });
      });

      confirmCancelButton.addEventListener("click", function () {
        const isConfirmed = window.confirm(
          `Are you sure you want to cancel the payment?`
        );
        if (!isConfirmed) {
          return;
        }
        fetch(`/delete_ongoing_payments/${weddingID}`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            paymentID: paymentID,
          }),
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
          .then((result) => {
            console.log(result);
            window.location.reload();
          });
      });
    });

  fetch(`/get_amount_pay_customer/${weddingID}`, {
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
      checkoutContainer.appendChild(checkoutCard);

      const checkoutCardDetails = document.createElement("div");
      checkoutCardDetails.classList.add("checkout_card_details");
      checkoutCardDetails.innerHTML = `<p><B>Total:LKR ${
        amount.totalPrice - amount.currentPaid
      }</B></p>`;
      checkoutCard.appendChild(checkoutCardDetails);

      const formWrapper = document.createElement("div");
      formWrapper.classList.add("payment-form-wrapper");

      const paymentForm = document.createElement("form");
      paymentForm.classList.add("payment-form");

      const inputContainer = document.createElement("div");
      inputContainer.classList.add("input-container");

      const label = document.createElement("label");
      label.htmlFor = "paymentAmount";
      label.textContent = "Enter Amount (LKR):";
      label.classList.add("payment-label");

      const input = document.createElement("input");
      input.type = "number";
      input.id = "paymentAmount";
      input.classList.add("payment-input");
      input.min = 0;
      input.max = amount.totalPrice - amount.currentPaid;
      input.required = true;

      const payButton = document.createElement("button");
      payButton.classList.add("payment-button");
      payButton.innerHTML = "<span>Checkout</span>";

      inputContainer.appendChild(label);
      inputContainer.appendChild(input);

      paymentForm.appendChild(inputContainer);
      paymentForm.appendChild(payButton);

      formWrapper.appendChild(paymentForm);
      checkoutCard.appendChild(formWrapper);

      payButton.addEventListener("click", function (e) {
        e.preventDefault();
        const amountToPay = input.value;
        const isExist = document.querySelector(".confirmation-container");

        if ((!amountToPay || amountToPay.trim() === "") && !isExist) {
          alert("Please enter an amount");
          input.focus();
          return;
        }

        if ((!amountToPay || amountToPay.trim() === "") && isExist) {
          return;
        }

        if (isExist) {
          alert(
            "Please cancel the ongoing payment before proceeding with a new payment"
          );

          return;
        }

        if (
          isNaN(amountToPay) ||
          amountToPay <= 0 ||
          amountToPay > amount.totalPrice - amount.currentPaid
        ) {
          alert("Please enter a valid amount");
          input.value = "";
          input.focus();
          return;
        }

        const isConfirmed = window.confirm(
          `Are you sure you want to pay LKR ${amountToPay}?`
        );
        if (!isConfirmed) {
          return;
        }

        fetch(`/add_customer_payment_data/${weddingID}`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            weddingID: weddingID,
            amount: amountToPay,
            currency: "LKR",
            statusCode: "0",
          }),
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
          .then((data) => {
            console.log(data);
          });

        window.location.reload();
      });
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

      // Create HTML for all packages
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
