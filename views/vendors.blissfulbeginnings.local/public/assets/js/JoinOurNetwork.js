const businessType = ["Photographer", "Dress Designer", "Salon", "Florist"];

document.addEventListener("DOMContentLoaded", () => {
  // options for business type
  const businessType_list = document.getElementById("businessType");

  businessType.forEach((element) => {
    businessType_list.innerHTML += `<option value="${element}">${element}</option>`;
  });

  // Handle single file drag and drop
  const fileInput = document.getElementById("photo");
  const nextButtons = document.querySelectorAll("#next-button");
  const prevButtons = document.querySelectorAll("#prev-button");
  const sections = document.querySelectorAll(".modal-section");
  const steps = document.querySelectorAll(".step");

  let currentStep = 0;

  function showStep(index) {
    sections.forEach((section, i) => {
      section.classList.toggle("active", i === index);
      steps[i].classList.toggle("active", i === index);
    });
    currentStep = index;
  }

  nextButtons.forEach((button) => {
    button.addEventListener("click", () => {
      if (currentStep < sections.length - 1) showStep(currentStep + 1);
    });
  });

  prevButtons.forEach((button) => {
    button.addEventListener("click", () => {
      if (currentStep > 0) showStep(currentStep - 1);
    });
  });

  // Handle file selection through input field
  // fileInput.addEventListener("change", (e) => {
  //   const files = e.target.files;
  //   if (files.length) {
  //     displayFileName(files[0]);
  //   }
  // });

  // Form validation (optional)
  const signupForm = document.getElementById("signup-form");

  signupForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log(signupForm.type);

    // Validate form inputs
    const businessName = signupForm.name.value.trim();
    const contact = signupForm.contact.value.trim();
    const description = signupForm.description.value.trim();
    const websiteLink = signupForm.websiteLink.value.trim();

    if (!businessName || !contact || !description || !websiteLink) {
      alert("Please fill in all required fields.");
      return;
    }

    // check if email and confirm email, password and confirm password match
    if (signupForm.email.value !== signupForm.confirmEmail.value) {
      alert("Email doesn't match");
      return;
    } else if (signupForm.password.value !== signupForm.confirmPassword.value) {
      alert("Password doesn't match");
      return;
    }
    const formData = {
      email: signupForm.email.value,
      password: signupForm.password.value,
      businessName: businessName,
      type: signupForm.businessType.value,
      contact: contact,
      address: signupForm.address.value,
      description: signupForm.description.value,
      websiteLink: websiteLink,
    };
    fetch("/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    })
      .then((response) => {
        console.log(response);
        if (!response.ok) {
          if (response.status == 409) {
            alert("Email is already registered");
            return;
          } else {
            throw new Error("Network response was not ok");
          }
        }
        return response.json();
      })
      .then((data) => {
        // Handle success (e.g., show a success message or redirect)
        console.log("Success:", data);
        localStorage.setItem('authToken', data.token); // Store token securely

        // next modal step
        showStep(2);

        const saveButton = document.querySelector("#save-button");
        saveButton.addEventListener("click", (event) => {
          event.preventDefault();
          const file = document.getElementById("photo").files[0];

          if (!file) {
            console.log("In here");
            window.location.href = "/vendor/" + data.vendorID;
            return;
          }

          const uploadFormData = new FormData();
          uploadFormData.append("image", file);

          fetch(
            "http://cdn.blissfulbeginnings.com/vendor/profile/" +
              data.vendorID,
            {
              method: "POST",
              body: uploadFormData,
            }
          )
            .then((response) => response.json())
            .then((data) => {
              if (!data.status) {
                throw new Error("Invalid response from server.");
              }
              console.log(data);
              window.location.href = "/vendor/" + data.vendorID;
            })
            .catch((error) => {
              console.error("Error:", error);
              alert("An error occurred while uploading the image.");
            });
        });
      })
      .catch((error) => {
        console.error("Error registering:", error);
        alert("Registration failed, please try again.");
      });

    // If validation passes, submit the form (could be an AJAX call or form submission)
    console.log("Form submitted successfully!");
  });
});
