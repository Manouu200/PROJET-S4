<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>Modifier le Régime<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-page-content">
    <div class="dashboard-header animate-fade-in">
        <h1> Modifier le Programme</h1>
        <p class="subtitle">Mettez à jour les détails de "<?= esc($regime['nom']) ?>"</p>
    </div>

    <form action="<?= base_url('admin/regimes/update/' . $regime['id']) ?>" method="POST" class="pastel-form">
        <div class="main-form-grid">
            
            <div class="form-column">
                <div class="card glass-card">
                    <div class="card-header">
                        <i class="fa-solid fa-pen"></i>
                        <h3>Informations Générales</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nom du régime</label>
                            <input type="text" name="nom" value="<?= esc($regime['nom']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Objectif de poids (kg)</label>
                            <div class="input-with-hint">
                                <input type="number" step="0.1" name="poids_variation" value="<?= $regime['poids_variation'] ?>" required>
                                <span class="hint-badge">Kilos</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card glass-card mt-30">
                    <div class="card-header">
                        <i class="fa-solid fa-chart-pie"></i>
                        <h3>Composition (%)</h3>
                    </div>
                    <div class="card-body">
                        <div class="composition-grid">
                            <div class="form-group">
                                <label>Viande</label>
                                <input type="number" name="pourcent_viande" class="comp-input" min="0" max="100" value="<?= $regime['pourcent_viande'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Poisson</label>
                                <input type="number" name="pourcent_poisson" class="comp-input" min="0" max="100" value="<?= $regime['pourcent_poisson'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Volaille</label>
                                <input type="number" name="pourcent_volaille" class="comp-input" min="0" max="100" value="<?= $regime['pourcent_volaille'] ?>" required>
                            </div>
                        </div>
                        <div id="total-check" class="total-bar">Total: <span id="total-val">100</span>% / 100%</div>
                    </div>
                </div>
            </div>

            <div class="form-column">
                <div class="card glass-card height-100">
                    <div class="card-header space-between">
                        <div class="title-group">
                            <i class="fa-solid fa-tags"></i>
                            <h3>Grille des Tarifs</h3>
                        </div>
                        <button type="button" id="add-price-row" class="btn-add-pill">
                            <i class="fa-solid fa-plus"></i> Ajouter
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="price-rows-container" class="price-list">
                            <?php foreach ($prix as $p) : ?>
                            <div class="price-item animate-slide-in">
                                <div class="price-inputs">
                                    <div class="field">
                                        <label>Durée (jours)</label>
                                        <input type="number" name="prix_duree[]" value="<?= $p['duree_jours'] ?>" required>
                                    </div>
                                    <div class="field">
                                        <label>Prix (£)</label>
                                        <input type="number" name="prix_valeur[]" value="<?= $p['prix'] ?>" required>
                                    </div>
                                </div>
                                <button type="button" class="btn-delete" onclick="removeRow(this)">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer-actions">
            <a href="<?= base_url('admin/regimes') ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit-gradient" id="submit-btn">
                <i class="fa-solid fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<script>
    // Réutilisation du script de create.php pour le bouton "+" et le total %
    document.getElementById('add-price-row').addEventListener('click', function() {
        const container = document.getElementById('price-rows-container');
        const newRow = document.createElement('div');
        newRow.className = 'price-item animate-slide-in';
        newRow.innerHTML = `
            <div class="price-inputs">
                <div class="field"><label>Durée (jours)</label><input type="number" name="prix_duree[]" required></div>
                <div class="field"><label>Prix (£)</label><input type="number" name="prix_valeur[]" required></div>
            </div>
            <button type="button" class="btn-delete" onclick="removeRow(this)"><i class="fa-solid fa-xmark"></i></button>
        `;
        container.appendChild(newRow);
    });

    function removeRow(btn) {
        const rows = document.querySelectorAll('.price-item');
        if(rows.length > 1) btn.closest('.price-item').remove();
    }

    const inputs = document.querySelectorAll('.comp-input');
    function updateTotal() {
        let total = 0;
        inputs.forEach(input => total += parseInt(input.value || 0));
        document.getElementById('total-val').textContent = total;
        document.getElementById('submit-btn').disabled = (total !== 100);
        document.getElementById('total-val').style.color = (total === 100) ? '#2ecc71' : '#ff7675';
    }
    inputs.forEach(input => input.addEventListener('input', updateTotal));
    updateTotal(); // Initial call
</script>
<?= $this->endSection() ?>