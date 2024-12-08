document.getElementById("signupBtn").addEventListener("click", function () {
  const name = document.getElementById("name").value.trim();
  const surname = document.getElementById("surname").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMessage = document.getElementById("error-message");

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

  if (!name) {
    errorMessage.textContent = "Name cannot be blank.";
    return;
  }

  if (!surname) {
    errorMessage.textContent = "Surname cannot be blank.";
    return;
  }

  if (!emailRegex.test(email)) {
    errorMessage.textContent = "Invalid email format.";
    return;
  }

  if (!passwordRegex.test(password)) {
    errorMessage.textContent =
      "Password must be at least 8 characters long and include at least 1 letter and 1 number.";
    return;
  }

  errorMessage.textContent = "Signup successful!";
  errorMessage.style.color = "#28a745";

  setTimeout(() => {
    window.location.href = "/login.html";
  }, 1000);
});
