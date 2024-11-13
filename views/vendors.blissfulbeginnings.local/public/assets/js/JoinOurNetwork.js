const businessType = ["Photographer", "Dress Designer", "Salon", "Florist"]
const banks = ["Access Bank", "Citibank", "Diamond Bank", "Ecobank",]
const branch = ["Colombo", "Wattala", "Kiribathgoda", "Ragama"]

document.addEventListener("DOMContentLoaded", () => {

  // options for banks
  const bank_list = document.getElementById("bank");

  banks.forEach(element => {
    bank_list.innerHTML += `<option value="${element}">${element}</option>`;
  });

  // options for branch
  const branch_list = document.getElementById("branch");

  branch.forEach(element => {
    branch_list.innerHTML += `<option value="${element}">${element}</option>`;
  });

  // options for business type
  const businessType_list = document.getElementById("businessType");

  businessType.forEach(element => {
    businessType_list.innerHTML += `<option value="${element}">${element}</option>`;
  });

  // Handle single file drag and drop
  const dropZone = document.getElementById("drop-zone");
  const fileInput = document.getElementById("photo");

  // Highlight drop zone when file is dragged over it
  dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("highlight");
  });

  // Remove highlight when file is dragged away
  dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("highlight");
  });

  // Handle dropped files
  dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("highlight");

    const files = e.dataTransfer.files;
    if (files.length) {
      fileInput.files = files;
      displayFileName(files[0]);
    }
  });

  // Handle file selection through input field
  fileInput.addEventListener("change", (e) => {
    const files = e.target.files;
    if (files.length) {
      displayFileName(files[0]);
    }
  });

  function displayFileName(file) {
    const dropZoneImage = dropZone.querySelector("img");
    const dropZoneText = dropZone.querySelector("h3");
    const dropZoneDesc = dropZone.querySelector("p");

    dropZoneImage.src = URL.createObjectURL(file);
    dropZoneImage.alt = file.name;
    dropZoneText.textContent = file.name;
    dropZoneDesc.textContent = "File selected";
  }

  // Handle multiple file drag and drop
  const dropZoneMultiple = document.getElementById("drop-zone-multiple");
  const fileInputMultiple = document.getElementById("photos");

  // Highlight drop zone when files are dragged over it
  dropZoneMultiple.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneMultiple.classList.add("highlight");
  });

  // Remove highlight when files are dragged away
  dropZoneMultiple.addEventListener("dragleave", () => {
    dropZoneMultiple.classList.remove("highlight");
  });

  // Handle dropped files
  dropZoneMultiple.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZoneMultiple.classList.remove("highlight");

    const files = e.dataTransfer.files;
    if (files.length) {
      fileInputMultiple.files = files;
      displayFileNames(files);
    }
  });

  // Handle file selection through input field
  fileInputMultiple.addEventListener("change", (e) => {
    const files = e.target.files;
    if (files.length) {
      displayFileNames(files);
    }
  });

  function displayFileNames(files) {
    dropZoneMultiple.innerHTML = ""; // Clear the drop zone content

    Array.from(files).forEach(file => {
      const fileElement = document.createElement("div");
      fileElement.classList.add("file-details");

      const dropZoneImage = document.createElement("img");
      dropZoneImage.src = URL.createObjectURL(file);
      dropZoneImage.alt = file.name;

      const fileName = document.createElement("h4");
      fileName.textContent = file.name;

      fileElement.appendChild(dropZoneImage);
      fileElement.appendChild(fileName);
      dropZoneMultiple.appendChild(fileElement);
    });
  }

  // Form validation (optional)
  const signupForm = document.getElementById("signup-form");

  signupForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log(signupForm.type);

    // Validate form inputs
    const businessName = signupForm.name.value.trim();
    const contact = signupForm.contact.value.trim();
    const description = signupForm.description.value.trim();
    const social = signupForm.social.value.trim();

    if (!businessName || !contact || !description || !social) {
      alert("Please fill in all required fields.");
      return;
    }

    // check if email and confirm email, password and confirm password match
    if (signupForm.email.value !== signupForm.confirmEmail.value) {
      alert("Email doesn't match");
      return;
    }
    else if (signupForm.password.value !== signupForm.confirmPassword.value) {
      alert("Password doesn't match");
      return;
    }
    const formData={
      email:signupForm.email.value,
      password:signupForm.password.value,
      businessName:businessName,
      type:signupForm.businessType.value,
      contact:contact,
      address:signupForm.address.value,
      bankAcc:signupForm.accountNumber.value,
    }
    fetch('/register', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify(formData)
  })
  .then(response => {
      console.log(response);
      if (!response.ok) {
          if (response.status == 409) {
              alert("Email is already registered");
              return;
          } else {
              throw new Error('Network response was not ok');
          }
      }
      return response.json();
  })
  .then(data => {
      // Handle success (e.g., show a success message or redirect)
      alert('Registration successful!');
      console.log('Success:', data);
      window.location.href = '/vendor/' + data.vendorID
  })
  .catch(error => {
      // Handle error (e.g., show an error message)
      console.error('Error registering:', error);
      alert('Registration failed, please try again.');
  });

    // If validation passes, submit the form (could be an AJAX call or form submission)
    console.log("Form submitted successfully!");
  });
});
