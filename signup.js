document.addEventListener("DOMContentLoaded", function () {
  const signupForm = document.getElementById("signupForm");
  if (signupForm) {
    signupForm.addEventListener("submit", validateSignupForm);
  }
});

function validateSignupForm(event) {
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document
    .getElementById("confirm_password")
    .value.trim();

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

  if (name.length < 2) {
    showError("Name must be at least 2 characters long.");
    event.preventDefault();
    return;
  }

  if (!emailRegex.test(email)) {
    showError("Invalid email format.");
    event.preventDefault();
    return;
  }

  if (!passwordRegex.test(password)) {
    showError(
      "Password must be at least 8 characters long and include at least 1 letter and 1 number."
    );
    event.preventDefault();
    return;
  }

  if (password !== confirmPassword) {
    showError("Passwords do not match.");
    event.preventDefault();
    return;
  }
}

function showError(message) {
  const errorElement = document.querySelector(".error");
  if (errorElement) {
    errorElement.textContent = message;
    errorElement.style.display = "block";
  } else {
    const newErrorElement = document.createElement("div");
    newErrorElement.className = "error";
    newErrorElement.textContent = message;
    document
      .querySelector("form")
      .insertBefore(newErrorElement, document.querySelector("form").firstChild);
  }
}
