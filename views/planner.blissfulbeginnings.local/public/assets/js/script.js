

document.addEventListener("DOMContentLoaded", function () {
  
  const weddingCardsContainer = document.querySelector(".wedding-cards");

  fetch('/fetch-wedding-data')
  .then(response => {
    if(!response.ok) throw new Error("Network response was not ok");
    return response.json();

  })
  .then(weddings => {

  weddings.forEach((wedding) => {
    const card = document.createElement("div");
    card.classList.add("wedding-card");

    card.innerHTML = `
            <p>${wedding.weddingID}<p>
            <p>${wedding.date}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
            
        `;

    if (wedding.isNew) {
      card.innerHTML = `
            <p>${wedding.weddingID}<p>
            <p>${wedding.date}</p>
            <p>${wedding.location}</p>
            <p>${wedding.theme}</p>
        
        `;
      card.classList.add("new");
      const acceptButton = document.createElement("button");
      acceptButton.classList.add("acceptButton");
      acceptButton.textContent = "Accept";
      acceptButton.addEventListener("click", (e) => {
        e.stopPropagation();
        window.location.href=`/selectPackages/${wedding.weddingID}`;
      });
      card.appendChild(acceptButton);

      const rejectButton = document.createElement("button");
      rejectButton.classList.add("rejectButton");
      rejectButton.textContent = "Reject";
      rejectButton.addEventListener("click", (e) => {
        e.stopPropagation();
        alert("Planner Reject the wedding");
      });
      card.appendChild(rejectButton);
    }

    if (!wedding.isNew) {
      card.addEventListener("click", () => {
        window.location.href="/plannerWedding";
      });
    }

    weddingCardsContainer.appendChild(card);
  });
})
.catch(error=>console.error("Error fetching wedding data:",error));
});
