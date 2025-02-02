document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", validateLoginForm);
  }
});

function validateLoginForm(event) {
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMessage = document.querySelector(".error");

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

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
