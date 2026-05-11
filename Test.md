    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("test");
            const form = document.getElementById('regimes-form');
            const submitBtn = document.getElementById('regimes-submit-btn');
            const resultsSection = document.getElementById('regimes-results');
            const panel = document.getElementById('regimes-objectif-panel');

            // Récupération des données injectées dans le panel
            const poidsActuel = parseFloat(panel.dataset.poidsActuel) || 0;
            const poidsIdealMin = parseFloat(panel.dataset.poidsIdealMin) || 0;
            const poidsIdealMax = parseFloat(panel.dataset.poidsIdealMax) || 0;

            // Éléments de saisie manuelle
            const inputMin = document.getElementById('regimes-objectif-input-min');
            const inputMax = document.getElementById('regimes-objectif-input-max');

            submitBtn.addEventListener('click', async function() {
                const selectedRadio = document.querySelector('input[name="objectif"]:checked');

                if (!selectedRadio) {
                    alert("Veuillez choisir un objectif.");
                    return;
                }

                const objectifId = selectedRadio.value;
                let pMin, pMax;

                // --- LOGIQUE MÉTIER : IMC IDÉAL (ID 3) ---
                if (objectifId === "3") {
                    // On utilise les valeurs calculées par le serveur (poids idéal santé)
                    pMin = poidsIdealMin;
                    pMax = poidsIdealMax;
                } else {
                    // On utilise les valeurs saisies par l'utilisateur
                    pMin = parseFloat(inputMin.value);
                    pMax = parseFloat(inputMax.value);

                    if (isNaN(pMin) || isNaN(pMax)) {
                        alert("Veuillez saisir un intervalle de poids valide.");
                        return;
                    }
                }

                // --- APPEL AJAX ---
                const url = `<?= base_url('client/programmes/obtenir-suggestions') ?>?poidsIndividu=${poidsActuel}&poidsMin=${pMin}&poidsMax=${pMax}`;

                try {
                    submitBtn.disabled = true;
                    submitBtn.innerText = "Chargement...";

                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Erreur réseau');

                    const data = await response.json();

                    // --- MISE À JOUR DE L'AFFICHAGE ---
                    afficherResultats(data);

                    // Scroll fluide vers les résultats
                    resultsSection.scrollIntoView({
                        behavior: 'smooth'
                    });

                } catch (error) {
                    console.error("Erreur:", error);
                    alert("Impossible de récupérer les programmes.");
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `... (remettre ton SVG d'origine) ... Voir les programmes`;
                }
            });

            function afficherResultats(programmes) {
                const grid = document.querySelector('.regimes-cards-grid');
                grid.innerHTML = ''; // On vide les anciens résultats

                if (programmes.length === 0) {
                    grid.innerHTML = '<p>Aucun programme ne correspond exactement à cet intervalle.</p>';
                    return;
                }

                programmes.forEach(prog => {
                    // Ici tu génères dynamiquement le HTML de tes cartes
                    // selon la structure de ton objet "prog"
                    const card = `
                <div class="regime-card regime-card--blue">
                    <h4 class="regime-card-title">${prog.nom}</h4>
                    <p class="regime-card-objectif">${prog.description}</p>
                    <div class="regime-card-stats">
                        <div class="regime-stat">
                            <span class="regime-stat-val">${prog.calories}</span>
                            <span class="regime-stat-unit">kcal/jour</span>
                        </div>
                    </div>
                    <button class="regime-card-btn btn-primary">Choisir ce régime</button>
                </div>
            `;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            }

            // Gestion de l'affichage du panel (masquer/afficher les inputs)
            document.querySelectorAll('input[name="objectif"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    panel.hidden = false;
                    const isIMC = this.value === "3";
                    document.getElementById('regimes-objectif-field').hidden = isIMC;

                    if (isIMC) {
                        document.getElementById('regimes-objectif-summary-value').innerText = `${poidsIdealMin} - ${poidsIdealMax} kg`;
                    } else {
                        document.getElementById('regimes-objectif-summary-value').innerText = "-- kg";
                    }
                });
            });
        });
    </script> -->
