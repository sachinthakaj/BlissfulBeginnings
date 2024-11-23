document.addEventListener("DOMContentLoaded", function () {
  const vendors = [
    {
      vendor: "Male Saloon",
    },
    {
      vendor: "Female Saloon",
    },

    {
      vendor: "Male DressMaker",
    },
    {
      vendor: "Female DressMaker",
    },
    {
      vendor: "Photographer",
    },
    {
      vendor: "Flourist",
    },
  ];

  const vendorCardContainer = document.querySelector(".vendor-cards");

  vendors.forEach((vendor) => {
    const card = document.createElement("div");
    card.classList.add("vendor-card");
    card.innerHTML = `<p>${vendor.vendor}</p>`;
    vendorCardContainer.appendChild(card);
  });
});
