<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content" style="max-width: 800px;">
    <div class="dashboard-header animate-fade-in">
        <h1>🏃 Ajouter une Activité</h1>
    </div>

    <form action="<?= base_url('admin/sports/store') ?>" method="POST" class="pastel-form">
        <div class="card glass-card">
            <div class="card-body">
                <div class="form-group">
                    <label>Nom de l'activité sportive</label>
                    <input type="text" name="nom" placeholder="ex: Natation intensive" required>
                </div>
                <div class="form-group">
                    <label>Variation de poids par séance (kg)</label>
                    <input type="number" step="0.01" name="poids_variation" placeholder="ex: -0.5" required>
                    <small class="helper-text">Indiquez une valeur négative pour la perte de poids.</small>
                </div>
            </div>
        </div>

        <div class="form-footer-actions">
            <a href="<?= base_url('admin/sports') ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit-gradient">
                <i class="fa-solid fa-check"></i> Enregistrer l'activité
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>