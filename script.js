// -------- Register Page Validation --------
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault(); // prevent page reload

      const email = form.querySelector("input[type='email']").value.trim();
      const password = form.querySelectorAll("input[type='password']")[0].value;
      const confirmPassword = form.querySelectorAll("input[type='password']")[1].value;

      // Simple email regex check
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
      }

      if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
      }

      // Success
      alert("Registration successful! Redirecting to login...");
      window.location.href = "login.html"; // redirect
    });
  }

  // -------- Permit Type Page Card Clicks --------
  const permitCards = document.querySelectorAll(".permit-card");
  if (permitCards.length > 0) {
    permitCards.forEach((card) => {
      card.addEventListener("click", () => {
        const type = card.querySelector("h3").innerText;

        switch (type) {
          case "Construction & Land Use":
            window.location.href = "building-permit.html";
            break;
          case "Business & Trade":
            window.location.href = "trade-license.html";
            break;
          case "Environment & Waste":
            window.location.href = "environmental-permit.html";
            break;
          case "Events":
            window.location.href = "event-permit.html";
            break;
          default:
            alert("Permit type not available yet.");
        }
      });
    });
  }
});
// Toggle dropdown on click
document.addEventListener("DOMContentLoaded", () => {
  const userAccount = document.querySelector(".user-account");

  userAccount.addEventListener("click", () => {
    userAccount.classList.toggle("active");
  });

  // Close dropdown if clicked outside
  document.addEventListener("click", (e) => {
    if (!userAccount.contains(e.target)) {
      userAccount.classList.remove("active");
    }
  });
});


// -------- Login Page Validation --------
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault(); // prevent page reload

      const email = form.querySelector("input[type='email']").value.trim();
      const password = form.querySelectorAll("input[type='password']")[0].value;

      // Simple email regex check
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
      }


      // Success
      alert("Login successful! Redirecting to dashboard...");
      window.location.href = "user/permit.html"; // redirect
    });
  }});



// Redirect on Register button click
/*document.getElementById("registerBtn").addEventListener("click", function() {
    // You can add validation or backend call here if needed
    window.location.href = "permitType.html";
});

// Redirect on Login button click
document.getElementById("loginBtn").addEventListener("click", function() {
    // You can add validation or backend call here if needed
    window.location.href = "permitType.html";
});*/


//function to validate email format
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// -------- Register button event --------
document.getElementById("registerBtn")?.addEventListener("click", function(){
    let email = document.getElementById("regEmail").value.trim();
    let pw = document.getElementById("regPassword").value.trim();
    let cpw = document.getElementById("conPassword").value.trim();
    let error = document.getElementById("regError");

    if (email === "" || pw === "" || cpw === "pw") {
        error.textContent = "Please fill in all fields correctly.";
        return;
    }
    if (!isValidEmail(email)) {
        error.textContent = "Please enter a valid email address.";
        return;
    }
    if (password.length < 6) {
        error.textContent = "Password must be at least 6 characters.";
        return;
    }

    //clear error and redirect
    error.textContent = "";
    window.location.href = "user/permit.html";
});

