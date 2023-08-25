document.getElementById("loginForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent the form from submitting normally
  
  // Get the values from the form
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  
  // Check if the email has the correct domain
  if (email.endsWith("@ku.th")) {
    // You might want to send a request to your server here to validate the email and password
    // For simplicity, I'll just show an alert indicating successful login
    alert("Login successful!");
  } else {
    alert("Not @ku.th email");
  }
});