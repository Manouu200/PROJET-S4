function togglePasswordVisibility(inputId) {
  const input = document.getElementById(inputId);
  const icon = event.target.closest(".toggle-icon");
  const baseUrl = window.baseUrl || "/";

  if (input.type === "password") {
    input.type = "text";
    icon.innerHTML =
      '<img src="' +
      baseUrl +
      'assets/oeil_fermer.png" alt="Masquer" class="eye-icon">';
  } else {
    input.type = "password";
    icon.innerHTML =
      '<img src="' +
      baseUrl +
      'assets/oeil_ouvert.png" alt="Afficher" class="eye-icon">';
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
      this.classList.remove("invalid");
      this.classList.add("valid");
      if (errorMsg) errorMsg.style.display = "none";
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

function validateEmail(emailInput) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const errorMsg = document.getElementById("email-error");

  emailInput.addEventListener("input", function () {
    if (this.value === "") {
      this.classList.remove("invalid", "valid");
      if (errorMsg) errorMsg.style.display = "none";
    } else if (emailRegex.test(this.value)) {
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
        emailInput.classList.remove("valid");
        emailInput.classList.add("invalid");
        if (errorMsg) {
          errorMsg.textContent = "Cet email est déjà utilisé";
          errorMsg.style.display = "block";
        }
      } else {
        emailInput.classList.remove("invalid");
        emailInput.classList.add("valid");
        if (errorMsg) errorMsg.style.display = "none";
      }
    })
    .catch((error) => {});
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

function getBaseUrl() {
  return document.body?.dataset?.baseUrl || window.baseUrl || "/";
}

function initClientHome() {
  const mainContent = document.getElementById("main-content");
  if (!mainContent) {
    return;
  }

  const baseUrl = getBaseUrl().replace(/\/$/, "");

  function chargerPage(page) {
    fetch(page)
      .then((response) => {
        if (!response.ok) {
          if (response.status === 403 || response.status === 401) {
            throw new Error(`Erreur d'authentification (${response.status})`);
          }
          throw new Error(`HTTP ${response.status}`);
        }
        return response.text();
      })
      .then((data) => {
        if (!data || data.trim().length === 0) {
          throw new Error("Réponse vide");
        }
        mainContent.innerHTML = data;
        attachMenuLinks();
        attachRechargeForm();
      })
      .catch((error) => {
        mainContent.innerHTML = "";
      });
  }

  function attachMenuLinks() {
    document.querySelectorAll(".menu-link").forEach((link) => {
      link.onclick = function (e) {
        const href = this.getAttribute("href") || "";

        if (href.includes("/logout")) {
          window.location.href = href;
          return;
        }

        if (!this.classList.contains("dropdown-toggle")) {
          e.preventDefault();
          chargerPage(this.getAttribute("href"));
        }
      };
    });
  }

  function attachRechargeForm() {
    const form = document.getElementById("recharge-form");
    if (!form || form.dataset.bound === "true") {
      return;
    }

    form.dataset.bound = "true";
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const messages = document.getElementById("recharge-messages");
      if (messages) {
        messages.innerHTML = "";
      }

      fetch(form.action, {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        body: new FormData(form),
      })
        .then((response) =>
          response
            .json()
            .then((data) => ({ ok: response.ok, data }))
        )
        .then(({ ok, data }) => {
          if (!ok) {
            throw new Error(data?.message || "Erreur lors de la recharge");
          }

          const soldeEl = document.getElementById("solde-amount");
          if (soldeEl && typeof data.solde !== "undefined") {
            soldeEl.textContent = data.solde;
          }

          if (messages) {
            messages.innerHTML = "<pre>" + data.message + "</pre>";
          }

          form.reset();
        })
        .catch((error) => {
          if (messages) {
            messages.innerHTML = "<pre>" + error.message + "</pre>";
          }
        });
    });
  }

  const dropdownToggle = document.querySelector(".dropdown-toggle");
  if (dropdownToggle && !dropdownToggle.dataset.bound) {
    dropdownToggle.dataset.bound = "true";
    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      const menu = this.nextElementSibling;
      menu.classList.toggle("show");
    });
  }

  document.addEventListener("click", function (e) {
    const menu = document.querySelector(".dropdown-menu");
    if (!e.target.closest(".dropdown") && menu) {
      menu.classList.remove("show");
    }
  });

  // Afficher un message de chargement
  mainContent.innerHTML =
    '<div style="padding: 20px; text-align: center; color: #999;">⏳ Chargement...</div>';

  attachMenuLinks();
  const accueilUrl = baseUrl + "/client/page/accueil";
  chargerPage(accueilUrl);
}

document.addEventListener("DOMContentLoaded", function () {
  console.lo
  const emailInputs = document.querySelectorAll('input[type="email"]');
  const emailErrorDiv = document.getElementById("email-error");

  emailInputs.forEach((input) => {
    if (emailErrorDiv && emailErrorDiv.getAttribute("data-ajax") === "true") {
      validateEmail(input);
    } else {
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

  initClientHome();
});
