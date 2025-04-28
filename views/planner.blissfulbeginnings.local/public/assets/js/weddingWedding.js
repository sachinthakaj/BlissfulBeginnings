const selectedPriority = document.querySelector('input[name="priority"]:checked').value;

function validatePhoneNumber(number) {
  const regex = /^\d{10}$/;
  return regex.test(number);
}

const phoneNumber = "1234567890";
if (validatePhoneNumber(phoneNumber)) {
  console.log("Valid 10-digit number");
} else {
  console.log("Invalid number");
}


