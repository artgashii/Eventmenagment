document.getElementById("signupBtn").addEventListener("click", function () {
  const name = document.getElementById("name").value.trim();
  const surname = document.getElementById("surname").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMessage = document.getElementById("error-message");

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email validation
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // At least 8 characters, 1 letter, 1 number

  // Check if name and surname are not blank
  if (!name) {
    errorMessage.textContent = "Name cannot be blank.";
    return;
  }

  if (!surname) {
    errorMessage.textContent = "Surname cannot be blank.";
    return;
  }

  // Validate email format
  if (!emailRegex.test(email)) {
    errorMessage.textContent = "Invalid email format.";
    return;
  }

  // Validate password format
  if (!passwordRegex.test(password)) {
    errorMessage.textContent =
      "Password must be at least 8 characters long and include at least 1 letter and 1 number.";
    return;
  }

  // Successful signup
  errorMessage.textContent = "Signup successful!";
  errorMessage.style.color = "#28a745"; // Green for success

  // Redirect to the main page or login page
  setTimeout(() => {
    window.location.href = "/login.html"; // Replace "login.html" with the page to redirect after signup
  }, 100); // 1-second delay for better UX
});
