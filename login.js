document.getElementById("loginBtn").addEventListener("click", function () {
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMessage = document.getElementById("error-message");

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

  if (!emailRegex.test(email)) {
    errorMessage.textContent = "Invalid email format.";
    return;
  }

  if (!passwordRegex.test(password)) {
    errorMessage.textContent =
      "Password must be at least 8 characters long and include at least 1 letter and 1 number.";
    return;
  }

  errorMessage.textContent = "Login successful!";
  errorMessage.style.color = "#28a745";

  setTimeout(() => {
    window.location.href = "index.php";
  }, 1000);
});
