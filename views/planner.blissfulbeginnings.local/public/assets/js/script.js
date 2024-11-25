document.addEventListener("DOMContentLoaded", function () {
  const weddingCardsContainer = document.querySelector(".wedding-cards");

  fetch("/fetch-wedding-data")
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((weddings) => {
      weddings.forEach((wedding) => {
        const card = document.createElement("div");
        card.classList.add("wedding-card");

        card.innerHTML = `
           <h4>${wedding.brideName} & ${wedding.groomName} </h4>
            <p>${wedding.date}</p>
            <p>${wedding.dayNight}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
           

            
        `;

        if (wedding.weddingState == "new") {
          card.innerHTML = `
           <h4>${wedding.brideName} & ${wedding.groomName} </h4>
            <p>${wedding.date}</p>
            <p>${wedding.dayNight}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
            
        
        `;
          card.classList.add("new");
          const acceptButton = document.createElement("button");
          acceptButton.classList.add("acceptButton");
          acceptButton.textContent = "Accept";
          acceptButton.addEventListener("click", (e) => {
            const confirmed = confirm("Are you sure you want to accept?");
            if (confirmed) {
              e.stopPropagation();

              fetch("/update-wedding-state", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  weddingID: wedding.weddingID,
                }),
              })
                .then((res) => res.json())
                .then((data) => {
                  if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                  } else {
                    alert("Error" + data.message);
                  }
                })
                .catch((error) => {
                  console.error("Error updating wedding state:", error);
                });
            }
          });
          card.appendChild(acceptButton);

          const rejectButton = document.createElement("button");
          rejectButton.classList.add("rejectButton");
          rejectButton.textContent = "Reject";
          rejectButton.addEventListener("click", (e) => {
            const confirmed = confirm("Are you sure you want to delete?");
            if (confirmed) {
              e.stopPropagation();

              fetch("/delete-wedding", {
                method: "DELETE",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  weddingID: wedding.weddingID,
                }),
              })
                .then((res) => res.json())
                .then((data) => {
                  if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                  } else {
                    alert("Error" + data.message);
                  }
                })
                .catch((error) => {
                  console.error("Error deleting wedding:", error);
                });
            }
          });
          card.appendChild(rejectButton);
        }

        if (wedding.weddingState == "unassigned") {
          card.innerHTML = `
           <h4>${wedding.brideName} & ${wedding.groomName} </h4>
            <p>${wedding.date}</p>
            <p>${wedding.dayNight}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
            
        
        `;
          card.classList.add("Unassigned");
          const selectPackagesButton = document.createElement("button");
          selectPackagesButton.classList.add("selectPackagesButton");
          selectPackagesButton.textContent = "Select Packages";
          selectPackagesButton.addEventListener("click", (e) => {
            e.stopPropagation();
            window.location.href = "/selectPackages";
          });
          card.appendChild(selectPackagesButton);
        }

        if (wedding.weddingState == "ongoing") {
          card.innerHTML = `
          <h4>${wedding.brideName} & ${wedding.groomName} </h4>
           <p>${wedding.date}</p>
           <p>${wedding.dayNight}</p>
           <p>${wedding.location}</p>
           <p>${wedding.theme}</p>
           
       
       `;
          card.classList.add("ongoing");
          card.addEventListener("click", () => {
            window.location.href = `/plannerWedding?id=${wedding.weddingID}`;
          });
        }

        weddingCardsContainer.appendChild(card);
      });
    })
    .catch((error) => console.error("Error fetching wedding data:", error));

  const logoutbutton = document.querySelector(".LogOut");
  if (logoutbutton) {
    logoutbutton.addEventListener("click", () => {
      const confirmed = confirm("Are you sure you want to log out?");
      if (confirmed) {
        fetch("/planner-logout", {
          method: "POST",
        })
          .then((response) => response.json())
          .then((data) => {
            alert(data.message);
            window.location.href =
              "http://planner.blissfulbeginnings.local/SignIn";
          })
          .catch((error) => console.error("Error logging out", error));
      }
    });
  }
});
