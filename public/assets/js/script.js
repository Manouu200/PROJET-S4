/* === fonctions utilitaire */
const attendre = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

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

function initRegimesSuggestions() {
  const form = document.getElementById("regimes-form");
  const submitBtn = document.getElementById("regimes-submit-btn");
  const resultsSection = document.getElementById("regimes-results");
  const grid = document.getElementById("regimes-cards-grid");
  const emptyState = document.getElementById("regimes-empty-state");
  const panel = document.getElementById("regimes-objectif-panel");

  if (!form || !submitBtn || !panel || !grid || !resultsSection) return;

  const originalBtnContent = submitBtn.innerHTML;
  const baseUrl = getBaseUrl().replace(/\/$/, "");

  const poidsActuel = panel.dataset.poidsActuel;
  const poidsIdealMin = panel.dataset.poidsIdealMin;
  const poidsIdealMax = panel.dataset.poidsIdealMax;

        try {
            submitBtn.disabled = true;
            submitBtn.innerHTML = "⏳ Recherche...";

            const formData = new FormData();
            formData.append('poidsIndividu', poidsActuel);
            formData.append('poidsMin', pMin);
            formData.append('poidsMax', pMax);

            const response = await fetch(`${baseUrl}/client/programmes/obtenir-suggestions`, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const programmes = await response.json();
            const grid = document.querySelector('.regimes-cards-grid');
            grid.innerHTML = '';


            if (!programmes || programmes.length === 0) {
              grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px;">Aucun programme trouvé.</p>';
            } else {
              programmes.forEach((prog, idx) => {
                // Construction de la carte avec les bonnes clés du JSON
                const card = `
                  <div class="regime-card regime-card--blue">
                    <div class="regime-card-top">
                      <span class="regime-card-badge">Score: ${prog.score.toFixed(1)}</span>
                    </div>
                    <h4 class="regime-card-title">${prog.regime}</h4>
                    <p class="regime-card-objectif">
                      🎯 Objectif final : <strong>${prog.poids_final} kg</strong>
                    </p>
                    <div class="regime-card-stats">
                      <div class="regime-stat">
                        <span class="regime-stat-val">${prog.duree}</span>
                        <span class="regime-stat-unit">jours</span>
                      </div>
                      <div class="regime-stat">
                        <span class="regime-stat-val">${prog.prix.toFixed(2)}</span>
                        <span class="regime-stat-unit">€</span>
                      </div>
                    </div>
                    <div class="regime-card-tags">
                      <span class="badge-pill badge-pill--blue">${prog.type}</span>
                      ${prog.sport ? `<span class="badge-pill badge-pill--orange">Sport inclus</span>` : ''}
                    </div>
                    <button type="button" class="regime-card-btn btn-primary choisir-programme-btn" data-idx="${idx}" style="margin-top:14px;">
                      Choisir ce programme
                    </button>
                  </div>`;
                grid.insertAdjacentHTML('beforeend', card);
              });

              // Ajout du gestionnaire sur tous les boutons "Choisir ce programme"
              const btns = grid.querySelectorAll('.choisir-programme-btn');
              btns.forEach((btn) => {
                btn.addEventListener('click', function () {
                  const idx = parseInt(this.getAttribute('data-idx'), 10);
                  const programme = programmes[idx];
                  // Stocker les infos du programme dans sessionStorage
                  sessionStorage.setItem('programmeChoisi', JSON.stringify(programme));
                  // Rediriger vers la page de paiement (à créer côté serveur)
                  window.location.href = getBaseUrl().replace(/\/$/, "") + '/client/programmes/payer';
                });
              });
            }

            resultsSection.scrollIntoView({ behavior: "smooth" });
  const inputMin = document.getElementById("regimes-objectif-input-min");
  const inputMax = document.getElementById("regimes-objectif-input-max");

  submitBtn.onclick = async function (e) {
    e.preventDefault();

    const selectedRadio = document.querySelector(
      'input[name="objectif"]:checked',
    );
    if (!selectedRadio) {
      alert("Veuillez choisir un objectif.");
      return;
    }

    let pMin = selectedRadio.value === "3" ? poidsIdealMin : inputMin.value;
    let pMax = selectedRadio.value === "3" ? poidsIdealMax : inputMax.value;

    if (!pMin || !pMax) {
      alert("Veuillez définir un intervalle de poids.");
      return;
    }

    try {
      submitBtn.disabled = true;
      submitBtn.innerHTML = "⏳ Recherche...";

      const formData = new FormData();
      formData.append("poidsIndividu", poidsActuel);
      formData.append("poidsMin", pMin);
      formData.append("poidsMax", pMax);

      const response = await fetch(
        `${baseUrl}/client/programmes/obtenir-suggestions`,
        {
          method: "POST",
          body: formData,
          headers: { "X-Requested-With": "XMLHttpRequest" },
        },
      );

      const programmes = await response.json();
      resultsSection.hidden = false;
      grid.innerHTML = "";

      if (!programmes || programmes.length === 0) {
        grid.innerHTML =
          '<p class="regimes-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 40px;">Aucun programme trouvé.</p>';
      } else {
        programmes.forEach((prog) => {
          const badge = prog.type === "sport" ? "Avec sport" : "Sans sport";
          const sportLabel = prog.sport
            ? `<span class="badge-pill badge-pill--orange">${prog.sport}</span>`
            : "";
          const card = `
                  <div class="regime-card ${prog.type === "sport" ? "regime-card--green" : "regime-card--blue"}">
                            <div class="regime-card-top">
                      <span class="regime-card-badge">Score: ${Number(prog.score).toFixed(1)}</span>
                            </div>
                            <h4 class="regime-card-title">${prog.regime}</h4>
                            <p class="regime-card-objectif">
                      Objectif final : <strong>${Number(prog.poids_final).toFixed(1)} kg</strong>
                            </p>
                            <div class="regime-card-stats">
                                <div class="regime-stat">
                        <span class="regime-stat-val">${prog.duree}</span>
                                    <span class="regime-stat-unit">jours</span>
                                </div>
                                <div class="regime-stat">
                        <span class="regime-stat-val">${Number(prog.prix).toFixed(2)}</span>
                                    <span class="regime-stat-unit">€</span>
                                </div>
                            </div>
                            <div class="regime-card-tags">
                      <span class="badge-pill badge-pill--blue">${badge}</span>
                      ${sportLabel}
                            </div>
                            <button type="button" class="regime-card-btn btn-primary" style="margin-top:14px;">
                                Choisir ce programme
                            </button>
                        </div>`;
          grid.insertAdjacentHTML("beforeend", card);
        });
      }

      resultsSection.scrollIntoView({ behavior: "smooth" });
    } catch (error) {
      console.error("Erreur:", error);
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnContent;
    }
  };
}
function initClientHome() {
  const mainContent = document.getElementById("main-content");
  if (!mainContent) return;

  const baseUrl = getBaseUrl().replace(/\/$/, "");

  function chargerPage(page) {
    fetch(page)
      .then((response) => response.text())
      .then((data) => {
        mainContent.innerHTML = data;
        // ON RÉ-INITIALISE TOUT APRÈS CHAQUE CHARGEMENT AJAX
        attachMenuLinks();
        attachRechargeForm();
        initImcGraph();
        initImcRing();
        initProfileWizard();
        initGoldPayment();
        initRegimesObjectives(); // Gestion visuelle du panel
        initRegimesSuggestions(); // Gestion du calcul et de l'envoi
      })
      .catch((error) => {
        console.error("Erreur chargement page:", error);
      });
  }

  function attachMenuLinks() {
    document.querySelectorAll(".menu-link").forEach((link) => {
      link.onclick = function (e) {
        const href = this.getAttribute("href") || "";
        if (href.includes("/logout")) return;
        if (!this.classList.contains("dropdown-toggle")) {
          e.preventDefault();
          chargerPage(href);
        }
      };
    });
  }

  async function attachRechargeForm() {
    const form = document.getElementById("recharge-form");
    if (!form || form.dataset.bound === "true") {
      return;
    }

    form.dataset.bound = "true";
    form.addEventListener("submit", async function (e) {
      e.preventDefault();

      const messages = document.getElementById("recharge-messages");
      const submitButton = form.querySelector('button[type="submit"]');
      const startedAt = Date.now();

      if (messages) {
        messages.innerHTML =
          '<div class="alert alert-info" role="alert">Traitement en cours...</div>';
      }
      if (submitButton) {
        submitButton.disabled = true;
      }

      try {
        const response = await fetch(form.action, {
          method: "POST",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
          body: new FormData(form),
        });

        const data = await response.json();
        const elapsed = Date.now() - startedAt;
        if (elapsed < 400) {
          await attendre(400 - elapsed);
        }

        if (!response.ok) {
          throw new Error(data?.message || "Erreur lors de la recharge");
        }

        const soldeEl = document.getElementById("solde-amount");
        if (soldeEl && typeof data.solde !== "undefined") {
          soldeEl.textContent = data.solde;
        }

        if (messages) {
          messages.innerHTML =
            '<div class="alert alert-success" role="alert">' +
            data.message +
            "</div>";
        }

        form.reset();
      } catch (error) {
        const elapsed = Date.now() - startedAt;
        if (elapsed < 400) {
          await attendre(400 - elapsed);
        }

        if (messages) {
          messages.innerHTML =
            '<div class="alert alert-danger" role="alert">' +
            error.message +
            "</div>";
        }
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
        }
      }
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

function initImcGraph() {
  const imcCard = document.querySelector(".imc-card");
  if (!imcCard) {
    return;
  }

  const imcValueElement = imcCard.querySelector(".imc-value");
  const indicator = imcCard.querySelector(".imc-indicator");

  if (!imcValueElement || !indicator) {
    return;
  }

  const rawValue = (imcValueElement.textContent || "").trim().replace(",", ".");
  const imcValue = parseFloat(rawValue);

  if (Number.isNaN(imcValue)) {
    return;
  }

  const minImc = 16;
  const maxImc = 40;
  const ratio = (imcValue - minImc) / (maxImc - minImc);
  const percent = Math.max(0, Math.min(100, ratio * 100));

  indicator.style.left = `${percent.toFixed(2)}%`;
}

function initImcRing() {
  const ringWrap = document.querySelector(".imc-ring");
  if (!ringWrap) return;

  const dataImc = ringWrap.getAttribute("data-imc") || "";
  const ringText = ringWrap.querySelector("#ringImcText");
  const progress = ringWrap.querySelector("#ringProgress");
  const grad = ringWrap.querySelector("#ringGrad");

  // Try parse numeric IMC
  const raw = (dataImc || (ringText ? ringText.textContent : ""))
    .toString()
    .trim()
    .replace(",", ".");
  const imc = parseFloat(raw);
  if (Number.isNaN(imc)) return;

  // Compute percent on same scale [16..40]
  const minImc = 16;
  const maxImc = 40;
  const ratio = (imc - minImc) / (maxImc - minImc);
  const percent = Math.max(0, Math.min(100, ratio * 100));

  // Compute circumference from r attribute
  if (!progress) return;
  const r = parseFloat(progress.getAttribute("r") || "52");
  const circumference = 2 * Math.PI * r;

  progress.style.strokeDasharray = `${circumference}`;
  // offset to hide the remaining portion
  progress.style.strokeDashoffset = `${circumference * (1 - percent / 100)}`;

  // Update displayed text
  if (ringText) {
    ringText.textContent = imc.toFixed(1);
  }

  // Ensure gradient exists and zones are already defined in SVG; nothing else to do
}

function initProfileWizard() {
  const form = document.querySelector('[data-profile-wizard="true"]');
  if (!form) {
    return;
  }

  const pages = Array.from(form.querySelectorAll("[data-wizard-page]"));
  const prevButton = form.querySelector("[data-wizard-prev]");
  const nextButton = form.querySelector("[data-wizard-next]");
  const saveButton = form.querySelector("[data-wizard-save]");
  const dots = Array.from(form.querySelectorAll("[data-wizard-dot]"));
  let currentStep = parseInt(form.dataset.startStep || "1", 10);

  function setStep(step) {
    currentStep = step;
    pages.forEach((page) => {
      const pageStep = parseInt(
        page.getAttribute("data-wizard-page") || "1",
        10,
      );
      page.hidden = pageStep !== currentStep;
    });

    dots.forEach((dot) => {
      const dotStep = parseInt(dot.getAttribute("data-wizard-dot") || "1", 10);
      dot.classList.toggle("is-active", dotStep === currentStep);
      dot.classList.toggle("is-done", dotStep < currentStep);
    });

    if (prevButton) {
      prevButton.hidden = currentStep === 1;
    }
    if (nextButton) {
      nextButton.hidden = currentStep !== 1;
    }
    if (saveButton) {
      saveButton.hidden = currentStep !== 2;
    }
  }

  function validateStep(step) {
    const page = pages.find(
      (item) =>
        parseInt(item.getAttribute("data-wizard-page") || "1", 10) === step,
    );
    if (!page) {
      return true;
    }

    const fields = Array.from(page.querySelectorAll("input, select, textarea"));
    for (const field of fields) {
      if (field.required && !field.checkValidity()) {
        field.reportValidity();
        return false;
      }
    }

    return true;
  }

  if (prevButton) {
    prevButton.addEventListener("click", function () {
      setStep(1);
    });
  }

  if (nextButton) {
    nextButton.addEventListener("click", function () {
      if (!validateStep(1)) {
        return;
      }
      setStep(2);
    });
  }

  form.addEventListener("submit", function (event) {
    if (currentStep !== 2) {
      event.preventDefault();
      setStep(2);
      return;
    }

    if (!validateStep(2)) {
      event.preventDefault();
    }
  });

  setStep(currentStep);
}

function showGoldError(message) {
  const box = document.getElementById("gold-error");
  if (!box) return;

  box.style.display = "block";
  box.textContent = message;
}

function initGoldPayment() {
  const btn = document.getElementById("paiement-gold-btn");
  if (!btn || btn.dataset.bound === "true") return;

  btn.dataset.bound = "true";

  const modal = document.getElementById("gold-modal");
  const modalText = document.getElementById("gold-modal-text");
  const confirmBtn = document.getElementById("gold-confirm-btn");
  const cancelBtn = document.getElementById("gold-cancel-btn");

  let prixGlobal = 0;

  function openModal(prix) {
    prixGlobal = prix;
    modalText.textContent = `Le prix de l'abonnement GOLD est de £${prix.toFixed(2)}`;
    modal.style.display = "flex";
    document.getElementById("gold-error").style.display = "none";
  }

  function closeModal() {
    modal.style.display = "none";
  }

  btn.addEventListener("click", function () {
    const prix = parseFloat(this.dataset.prix);

    if (isNaN(prix)) {
      alert("Prix invalide");
      return;
    }

    openModal(prix);
  });

  cancelBtn.addEventListener("click", closeModal);

  confirmBtn.addEventListener("click", async function () {
    closeModal();

    btn.disabled = true;
    btn.textContent = "Traitement...";

    try {
      const response = await fetch("/client/gold/payer", {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      });

      const data = await response.json();

      // ❌ erreur HTTP (serveur)
      if (!response.ok) {
        throw new Error(data.details || "Erreur serveur");
      }

      // ❌ erreur métier (solde insuffisant / déjà GOLD etc.)
      if (!data.isSuccess) {
        showGoldError(data.details);
        return;
      }

      // ✅ succès
      document.getElementById("gold-error").style.display = "none";

      // UX propre : message + reload
      const box = document.getElementById("gold-error");
      if (box) {
        box.style.display = "block";
        box.style.color = "green";
        box.textContent = data.details || "Compte GOLD activé avec succès";
      }

      setTimeout(() => {
        location.reload();
      }, 800);
    } catch (err) {
      showGoldError(err.message);
    } finally {
      btn.disabled = false;
      btn.textContent = "Devenir GOLD";
    }
  });

  modal.addEventListener("click", function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });
}

function initRegimesObjectives() {
  const cards = Array.from(document.querySelectorAll(".regimes-objectif-card"));
  const layout = document.querySelector(".regimes-objectifs-layout");
  const panel = document.getElementById("regimes-objectif-panel");
  const field = document.getElementById("regimes-objectif-field");
  const fieldLabel = document.getElementById("regimes-objectif-field-label");
  const inputMin = document.getElementById("regimes-objectif-input-min");
  const inputMax = document.getElementById("regimes-objectif-input-max");
  const summaryLabel = document.getElementById(
    "regimes-objectif-summary-label",
  );
  const summaryValue = document.getElementById(
    "regimes-objectif-summary-value",
  );
  const title = document.getElementById("regimes-objectif-panel-title");
  const subtitle = document.getElementById("regimes-objectif-panel-subtitle");
  const submitBtn = document.getElementById("regimes-submit-btn");

  if (
    !cards.length ||
    !panel ||
    !field ||
    !fieldLabel ||
    !inputMin ||
    !inputMax ||
    !summaryLabel ||
    !summaryValue ||
    !title ||
    !subtitle
  ) {
    return;
  }

  const baseUrl = getBaseUrl().replace(/\/$/, "");
  const defaultTitle = title.textContent || "Cliquez sur un objectif";
  const defaultSubtitle = subtitle.textContent || "Le calcul s'affichera ici.";
  let activeId = null;
  let debounceTimer = null;

  function formatKg(value) {
    const numericValue = Number(value);
    if (!Number.isFinite(numericValue)) {
      return "-- kg";
    }

    return `${numericValue.toFixed(1)} kg`;
  }

  function formatRange(min, max) {
    const a = Number(min);
    const b = Number(max);
    if (!Number.isFinite(a) || !Number.isFinite(b)) return "-- kg";
    return `${a.toFixed(1)}–${b.toFixed(1)} kg`;
  }

  function resetPanel() {
    activeId = null;
    if (layout) {
      layout.classList.remove("is-active");
    }
    panel.hidden = true;
    field.hidden = true;
    inputMin.value = "";
    inputMax.value = "";
    summaryLabel.textContent = "Objectif";
    summaryValue.textContent = "-- kg";
    title.textContent = defaultTitle;
    subtitle.textContent = defaultSubtitle;

    cards.forEach((card) => {
      const radio = card.querySelector('input[type="radio"]');
      if (radio) {
        radio.checked = false;
      }
    });
  }

  async function fetchObjective(objectifId, valeur) {
    // valeur can be an object {min, max} or strings
    let url = `${baseUrl}/client/regimes/calculer?objectif_id=${encodeURIComponent(objectifId)}`;
    if (valeur && typeof valeur === "object") {
      if (valeur.min !== undefined && valeur.min !== null) {
        url += `&min=${encodeURIComponent(String(valeur.min))}`;
      }
      if (valeur.max !== undefined && valeur.max !== null) {
        url += `&max=${encodeURIComponent(String(valeur.max))}`;
      }
    } else {
      url += `&min=&max=`;
    }
    const response = await fetch(url, {
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    });

    const data = await response.json();

    // Return full payload; caller handles success vs validation
    return { ok: response.ok, ...data };
  }

  function renderObjective(data) {
    if (layout) {
      layout.classList.add("is-active");
    }
    panel.hidden = false;
    title.textContent = data.objectif_label || defaultTitle;
    subtitle.textContent = data.description || defaultSubtitle;
    summaryLabel.textContent = data.needs_input
      ? "Objectif"
      : "Poids idéal cible";

    if (data.needs_input) {
      field.hidden = false;
      fieldLabel.textContent = data.input_label || "Plage cible";
      // prefill min/max if provided
      if (
        data.target_min !== undefined &&
        data.target_max !== undefined &&
        data.target_min !== null &&
        data.target_max !== null
      ) {
        inputMin.value = data.target_min;
        inputMax.value = data.target_max;
      } else {
        inputMin.value = "";
        inputMax.value = "";
      }
      summaryValue.textContent =
        data.target_min !== undefined &&
        data.target_max !== undefined &&
        data.target_min !== null &&
        data.target_max !== null
          ? formatRange(data.target_min, data.target_max)
          : "-- kg";
    } else {
      field.hidden = true;
      inputMin.value = "";
      inputMax.value = "";
      summaryValue.textContent =
        data.target_min !== undefined &&
        data.target_max !== undefined &&
        data.target_min !== null &&
        data.target_max !== null
          ? formatRange(data.target_min, data.target_max)
          : data.target_weight !== undefined
            ? formatKg(data.target_weight)
            : "-- kg";
    }
  }

  function scheduleRefresh() {
    if (!activeId) {
      return;
    }

    if (debounceTimer) {
      clearTimeout(debounceTimer);
    }

    debounceTimer = setTimeout(async () => {
      // client-side validation: mark offending inputs, do not call server if invalid
      const minVal = inputMin.value.trim();
      const maxVal = inputMax.value.trim();
      const minNum = minVal === "" ? null : Number(minVal.replace(",", "."));
      const maxNum = maxVal === "" ? null : Number(maxVal.replace(",", "."));

      // clear previous error marks
      inputMin.classList.remove("input-error");
      inputMax.classList.remove("input-error");

      // If either input is empty, show field but don't call server yet
      if (minNum === null || maxNum === null) {
        if (minNum === null) inputMin.classList.add("input-error");
        if (maxNum === null) inputMax.classList.add("input-error");
        summaryValue.textContent = "-- kg";
        return;
      }

      // invalid numbers
      if (
        !Number.isFinite(minNum) ||
        !Number.isFinite(maxNum) ||
        minNum < 0 ||
        maxNum < 0
      ) {
        if (!Number.isFinite(minNum) || minNum < 0)
          inputMin.classList.add("input-error");
        if (!Number.isFinite(maxNum) || maxNum < 0)
          inputMax.classList.add("input-error");
        summaryValue.textContent = "-- kg";
        return;
      }

      // min must be <= max
      if (minNum > maxNum) {
        inputMin.classList.add("input-error");
        inputMax.classList.add("input-error");
        summaryValue.textContent = "-- kg";
        return;
      }

      try {
        const payload = { min: String(minNum), max: String(maxNum) };
        const data = await fetchObjective(activeId, payload);

        if (!data.ok || !data.success) {
          // mark inputs on server-side validation failure
          inputMin.classList.add("input-error");
          inputMax.classList.add("input-error");
          summaryValue.textContent = "-- kg";
          return;
        }

        // success
        inputMin.classList.remove("input-error");
        inputMax.classList.remove("input-error");
        renderObjective(data);
      } catch (err) {
        // network/fetch error: keep summary neutral and mark inputs
        inputMin.classList.add("input-error");
        inputMax.classList.add("input-error");
        summaryValue.textContent = "-- kg";
      }
    }, 250);
  }

  cards.forEach((card) => {
    const radio = card.querySelector('input[type="radio"]');
    if (!radio) {
      return;
    }

    card.addEventListener("click", async function (event) {
      event.preventDefault();

      const objectifId = radio.value;
      const isSameObjective = activeId === objectifId && radio.checked;

      if (isSameObjective) {
        resetPanel();
        return;
      }

      cards.forEach((otherCard) => {
        const otherRadio = otherCard.querySelector('input[type="radio"]');
        if (otherRadio) {
          otherRadio.checked = false;
        }
      });

      radio.checked = true;
      activeId = objectifId;
      inputMin.value = "";
      inputMax.value = "";
      summaryLabel.textContent = "Objectif";
      summaryValue.textContent = "Calcul en cours...";
      if (layout) {
        layout.classList.add("is-active");
      }
      panel.hidden = false;
      field.hidden = false;

      try {
        const data = await fetchObjective(objectifId, { min: null, max: null });
        renderObjective(data);

        if (data.needs_input) {
          inputMin.focus();
        }
      } catch (error) {
        summaryValue.textContent = error.message;
      }
    });
  });

  inputMin.addEventListener("input", scheduleRefresh);
  inputMax.addEventListener("input", scheduleRefresh);

  if (submitBtn) {
    submitBtn.addEventListener("click", function () {
      const target = document.getElementById("regimes-results");
      if (target) {
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  console.log("Script chargé avec succès");

  const emailInputs = document.querySelectorAll('input[type="email"]');
  emailInputs.forEach((input) => {
    const emailErrorDiv = document.getElementById("email-error");
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
  initImcGraph();
  initImcRing();
  initProfileWizard();
  initGoldPayment();
  initRegimesSuggestions();
});
