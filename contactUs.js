document
  .getElementById("contact-form")
  .addEventListener("submit", function (event) {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    const nameRegex = /^[a-zA-Z\s]{3,50}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const messageRegex = /^.{10,500}$/;

    document.getElementById("name-error").textContent = "";
    document.getElementById("email-error").textContent = "";
    document.getElementById("message-error").textContent = "";

    let isValid = true;

    if (!nameRegex.test(name)) {
      document.getElementById("name-error").textContent =
        "Invalid Name: Must be 3-50 characters and contain only letters and spaces.";
      isValid = false;
    }

    if (!emailRegex.test(email)) {
      document.getElementById("email-error").textContent =
        "Invalid Email: Please enter a valid email address.";
      isValid = false;
    }

    if (!messageRegex.test(message)) {
      document.getElementById("message-error").textContent =
        "Invalid Message: Must be between 10-500 characters.";
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
