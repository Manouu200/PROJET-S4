<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>Ajouter un Régime<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-page-content">
    <div class="dashboard-header animate-fade-in">
        <h1> Nouveau Programme</h1>
        <p class="subtitle">Configurez la composition nutritionnelle et les tarifs .</p>
    </div>

    <?php if (session()->has('error')): ?>
        <div style="background-color: #ff7675; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>⚠️ Erreur:</strong> <?= session('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/regimes/store') ?>" method="POST" class="pastel-form">
        <div class="main-form-grid">
            
            <div class="form-column">
                <div class="card glass-card">
                    <div class="card-header">
                        <i class="fa-solid fa-circle-info"></i>
                        <h3>Informations Générales </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nom">Nom du régime</label>
                            <input type="text" id="nom" name="nom" placeholder="ex: Brûle Graisse Express" required>
                        </div>
                        <div class="form-group">
                            <label for="poids_variation">Objectif de poids (kg) </label>
                            <div class="input-with-hint">
                                <input type="number" id="poids_variation" step="0.1" name="poids_variation" placeholder="ex: -2.5" required>
                                <span class="hint-badge">Kilos</span>
                            </div>
                            <small class="helper-text">Négatif pour perdre, positif pour gagner.</small>
                        </div>
                    </div>
                </div>

                <div class="card glass-card mt-30">
                    <div class="card-header">
                        <i class="fa-solid fa-chart-pie"></i>
                        <h3>Répartition Nutritionnelle (%) </h3>
                    </div>
                    <div class="card-body">
                        <div class="composition-grid">
                            <div class="form-group">
                                <label>Viande</label>
                                <input type="number" name="pourcent_viande" class="comp-input" min="0" max="100" value="0" required>
                            </div>
                            <div class="form-group">
                                <label>Poisson</label>
                                <input type="number" name="pourcent_poisson" class="comp-input" min="0" max="100" value="0" required>
                            </div>
                            <div class="form-group">
                                <label>Volaille</label>
                                <input type="number" name="pourcent_volaille" class="comp-input" min="0" max="100" value="0" required>
                            </div>
                        </div>
                        <div id="total-check" class="total-bar">Total: <span id="total-val">0</span>% / 100%</div>
                    </div>
                </div>
            </div>

            <div class="form-column">
                <div class="card glass-card height-100">
                    <div class="card-header space-between">
                        <div class="title-group">
                            <i class="fa-solid fa-tags"></i>
                            <h3>Grille des Tarifs </h3>
                        </div>
                        <button type="button" id="add-price-row" class="btn-add-pill">
                            <i class="fa-solid fa-plus"></i> Ajouter une durée
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="price-rows-container" class="price-list">
                            <div class="price-item animate-slide-in">
                                <div class="price-inputs">
                                    <div class="field">
                                        <label>Durée (jours)</label>
                                        <input type="number" name="prix_duree[]" placeholder="7" required>
                                    </div>
                                    <div class="field">
                                        <label>Prix (Ar)</label>
                                        <input type="number" name="prix_valeur[]" placeholder="15000" required>
                                    </div>
                                </div>
                                <button type="button" class="btn-delete" onclick="removeRow(this)">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer-actions">
            <a href="<?= base_url('admin/regimes') ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit-gradient" id="submit-btn">
                <i class="fa-solid fa-check"></i> Publier le régime
            </button>
        </div>
    </form>
</div>

<script>
    // Gestion des lignes de prix
    document.getElementById('add-price-row').addEventListener('click', function() {
        const container = document.getElementById('price-rows-container');
        const newRow = document.createElement('div');
        newRow.className = 'price-item animate-slide-in';
        newRow.innerHTML = `
            <div class="price-inputs">
                <div class="field">
                    <label>Durée (jours)</label>
                    <input type="number" name="prix_duree[]" required>
                </div>
                <div class="field">
                    <label>Prix (Ar)</label>
                    <input type="number" name="prix_valeur[]" required>
                </div>
            </div>
            <button type="button" class="btn-delete" onclick="removeRow(this)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        container.appendChild(newRow);
    });

    function removeRow(btn) {
        const rows = document.querySelectorAll('.price-item');
        if(rows.length > 1) btn.closest('.price-item').remove();
    }

    // Calcul du total des pourcentages en temps réel
    const inputs = document.querySelectorAll('.comp-input');
    const totalVal = document.getElementById('total-val');
    const submitBtn = document.getElementById('submit-btn');

    function updateTotal() {
        let total = 0;
        inputs.forEach(input => total += parseInt(input.value || 0));
        totalVal.textContent = total;
        
        if(total !== 100) {
            totalVal.style.color = '#ff7675';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
        } else {
            totalVal.style.color = '#2ecc71';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    }

    inputs.forEach(input => input.addEventListener('input', updateTotal));
</script>
<?= $this->endSection() ?>