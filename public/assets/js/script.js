/* === fonctions utilitaire */
const attendre = (ms) => new Promise(resolve => setTimeout(resolve, ms));



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
		.catch((error) => { });
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
				initImcGraph();
				initImcRing();
				initProfileWizard();
				initProfileWizard();
				initGoldPayment();
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

	async function attachRechargeForm() {
		const form = document.getElementById("recharge-form");
		if (!form || form.dataset.bound === "true") {
			return;
		}

		form.dataset.bound = "true";
		form.addEventListener("submit", async function (e) {
			e.preventDefault();

			const messages = document.getElementById("recharge-messages");
			const submitButton = form.querySelector("button[type=\"submit\"]");
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
		modalText.textContent = `Le prix de l'abonnement GOLD est de $${prix.toFixed(2)}`;
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
	initImcGraph();
	initImcRing();
	initProfileWizard();
	initGoldPayment();
});
