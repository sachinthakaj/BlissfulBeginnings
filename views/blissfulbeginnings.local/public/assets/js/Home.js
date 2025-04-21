// Add animation to stats (count up effect)
function animateStats() {
  const statNumbers = document.querySelectorAll(".stat-number");

  statNumbers.forEach((stat) => {
    const targetValue = parseInt(stat.textContent);
    let currentValue = 0;
    const duration = 2000; // 2 seconds
    const increment = targetValue / (duration / 16); // 60fps

    function updateCounter() {
      currentValue += increment;
      if (currentValue < targetValue) {
        if (targetValue > 100 || targetValue < 15) {
          stat.textContent = Math.floor(currentValue) + "+";
        } else {
          stat.textContent = Math.floor(currentValue) + "%";
        }
        requestAnimationFrame(updateCounter);
      } else {
        if (targetValue > 100 || targetValue < 15) {
          stat.textContent = targetValue + "+";
        } else {
          stat.textContent = targetValue + "%";
        }
      }
    }

    // Start animation when scrolled into view
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            updateCounter();
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    observer.observe(stat);
  });
}

window.addEventListener("load", function () {
  animateStats();
});

document.addEventListener("DOMContentLoaded", function () {
  const sections = document.querySelectorAll("section, footer");
  const navLinks = document.querySelectorAll(".nav-link");
  const submitButton = document.querySelector(".submit-btn");

  submitButton.addEventListener("click", function (e) {
    e.preventDefault();
    console.log(e.target);

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (name === "" || email === "" || message === "") {
      alert("Please fill in all required fields.");
      return;
    } else if (!emailPattern.test(email)) {
      alert("Please enter a valid email address.");
    }

    // const formData = new FormData();
    // formData.append("name", name);
    // formData.append("email", email);
    // formData.append("message", message);
    const formData = {
      name: name,
      email: email,
      message: message,
    };

    fetch("/contact", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    })
      .then((response) => response.json())
      .then((data) => {
        if (!data.status) {
          throw new Error(
            "Invalid response from server. No storage path provided."
          );
        }

        alert("Message sent successfully!");

        setTimeout(() => {
          window.location.reload();
        }, 1000); // 1 second delay
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while sending the message.");
      });
  });

  // Handle page links and prevent default behavior
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const sectionId = this.getAttribute("data-section");
      document.getElementById(sectionId).scrollIntoView({ behavior: "smooth" });

      // Update URL to simulate navigation without page reload
      history.pushState(null, null, this.getAttribute("href"));
    });
  });

  // Highlight active section while scrolling
  window.addEventListener("scroll", function () {
    let current = "";
    console.log("scrolling");

    sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.clientHeight;
      if (pageYOffset >= sectionTop - sectionHeight / 4) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach((link) => {
      link.classList.remove("active");
      if (link.getAttribute("data-section") === current) {
        link.classList.add("active");
        console.log("Active section is: " + current);
      }
    });
  });

  // Handle initial page load based on URL
  function setInitialActive() {
    const path = window.location.pathname;
    let sectionId = "home"; // Default

    if (path === "/about") {
      sectionId = "about";
    } else if (path === "/services") {
      sectionId = "services";
    } else if (path === "/contact") {
      sectionId = "contact";
    }

    // Scroll to the right section
    document.getElementById(sectionId).scrollIntoView();

    // Update active state
    navLinks.forEach((link) => {
      link.classList.remove("active");
      if (link.getAttribute("data-section") === sectionId) {
        link.classList.add("active");
      }
    });
  }

  // Only run if we have a specific path
  if (window.location.pathname !== "/") {
    setInitialActive();
  }
});
