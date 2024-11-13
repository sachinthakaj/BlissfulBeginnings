document.addEventListener("DOMContentLoaded", function () {
  const packages = [
    {
      package: "package-1",
    },
    {
      package: "package-2",
    },
    {
      package: "package-3",
    },
    {
      package: "package-3",
    },
    {
      package: "package-3",
    },
  ];

  const packageCardsContainer = document.querySelector(".package-cards");

  packages.forEach((package) => {
    const card = document.createElement("div");
    card.classList.add("package-card");

    card.innerHTML = `<p>${package.package}</P>`;

    packageCardsContainer.appendChild(card);
  });
});
