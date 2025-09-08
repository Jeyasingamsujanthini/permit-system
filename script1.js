function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
// -------- Login form event --------


const loginForm = document.getElementById("loginForm");
if (loginForm) {
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    let email = document.getElementById("loginEmail").value.trim();
    let password = document.getElementById("loginPassword").value.trim();
    let error = document.getElementById("loginError");

    if (email === "" || password === "") {
      error.textContent = "Please fill in all fields.";
      return;
    }

    if (!isValidEmail(email)) {
      error.textContent = "Invalid email format.";
      return;
    }

    if (password.length < 6) {
      error.textContent = "Password must be at least 6 characters.";
      return;
    }

    error.textContent = "";
    window.location.href = "permit.html";
  });
}

// Wait until DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".permit-form");

  form.addEventListener("submit", (event) => {
    event.preventDefault(); // prevent form submission until validation

    // Collect values
    const name = document.getElementById("applicantName").value.trim();
    const nic = document.getElementById("nicNo").value.trim();
    const age = document.getElementById("age").value.trim();
    const contact = document.getElementById("contactNumber").value.trim();
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;

    // Validate applicant name
    if (name.length < 3) {
      alert("Applicant name must be at least 3 characters.");
      return;
    }

    // Validate NIC (Sri Lanka NIC format: 9 digits + V/X OR 12 digits)
    const nicPattern = /^([0-9]{9}[vVxX]|[0-9]{12})$/;
    if (!nicPattern.test(nic)) {
      alert("Invalid NIC format. Use 9 digits + V/X or 12 digits.");
      return;
    }

    // Validate age
    if (age < 18 || age > 100) {
      alert("Age must be between 18 and 100.");
      return;
    }

    // Validate contact number (Sri Lanka: 10 digits, starts with 0)
    const phonePattern = /^0\d{9}$/;
    if (!phonePattern.test(contact)) {
      alert("Invalid phone number. Must be 10 digits starting with 0.");
      return;
    }

    // Validate date range
    if (new Date(startDate) > new Date(endDate)) {
      alert("End Date must be after Start Date.");
      return;
    }

    // Validate required file upload
    const files = document.getElementById("documents").files;
    if (files.length === 0) {
      alert("Please upload required documents.");
      return;
    }

    // If everything is valid
    alert("Application submitted successfully ✅");

    // Later you can send data to server:
    // form.submit();  // uncomment when backend is ready
  });
});
