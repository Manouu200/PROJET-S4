function togglePasswordVisibility(inputId) {
  const input = document.getElementById(inputId);
  const icon = event.target;

  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🙈";
  } else {
    input.type = "password";
    icon.textContent = "👁️";
  }
}

function validateEmailFormatOnly(emailInput) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const errorMsg = document.getElementById("email-error");

  emailInput.addEventListener("input", function () {
    if (this.value === "") {
      this.classList.remove("invalid", "valid");
      if (errorMsg) errorMsg.style.display = "none";
    } else if (emailRegex.test(this.value)) {
      // Format valide
      this.classList.remove("invalid");
      this.classList.add("valid");
      if (errorMsg) errorMsg.style.display = "none";
    } else {
      // Format invalide
      this.classList.remove("valid");
      this.classList.add("invalid");
      if (errorMsg) {
        errorMsg.textContent = "Format incorrect";
        errorMsg.style.display = "block";
      }
    }
  });
}

function validateEmail(emailInput) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const errorMsg = document.getElementById("email-error");

  emailInput.addEventListener("input", function () {
    if (this.value === "") {
      this.classList.remove("invalid", "valid");
      if (errorMsg) errorMsg.style.display = "none";
    } else if (emailRegex.test(this.value)) {
      // Format valide, vérifier si l'email existe en base
      checkEmailExists(this.value, emailInput);
    } else {
      this.classList.remove("valid");
      this.classList.add("invalid");
      if (errorMsg) {
        errorMsg.textContent = "Format incorrect";
        errorMsg.style.display = "block";
      }
    }
  });
}

function checkEmailExists(email, emailInput) {
  fetch("/api/check-email", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "email=" + encodeURIComponent(email),
  })
    .then((response) => response.json())
    .then((data) => {
      const errorMsg = document.getElementById("email-error");
      if (data.exists) {
        // Email existe, marquer comme invalide
        emailInput.classList.remove("valid");
        emailInput.classList.add("invalid");
        if (errorMsg) {
          errorMsg.textContent = "Cet email est déjà utilisé";
          errorMsg.style.display = "block";
        }
      } else {
        // Email n'existe pas, marquer comme valide
        emailInput.classList.remove("invalid");
        emailInput.classList.add("valid");
        if (errorMsg) errorMsg.style.display = "none";
      }
    })
    .catch((error) => {
      console.error("Erreur lors de la vérification de l'email:", error);
    });
}

function validateNumber(numberInput, min, max) {
  numberInput.addEventListener("input", function () {
    if (this.value.trim() === "") {
      this.classList.remove("invalid", "valid");
    } else {
      const value = parseFloat(this.value);
      if (isNaN(value) || value < min || value > max) {
        this.classList.remove("valid");
        this.classList.add("invalid");
      } else {
        this.classList.remove("invalid");
        this.classList.add("valid");
      }
    }
  });
}

// Initialiser la validation au chargement
document.addEventListener("DOMContentLoaded", function () {
  const emailInputs = document.querySelectorAll('input[type="email"]');
  const emailErrorDiv = document.getElementById("email-error");

  emailInputs.forEach((input) => {
    // Si email-error a data-ajax="true", c'est une page avec vérification AJAX
    if (emailErrorDiv && emailErrorDiv.getAttribute("data-ajax") === "true") {
      validateEmail(input);
    } else {
      // Sinon, juste validation de format
      validateEmailFormatOnly(input);
    }
  });

  const tailleInput = document.getElementById("taille");
  if (tailleInput) {
    validateNumber(tailleInput, 50, 250);
  }

  const poidsInput = document.getElementById("poids");
  if (poidsInput) {
    validateNumber(poidsInput, 20, 300);
  }
});
