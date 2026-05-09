<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>Modifier l'Activité<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-page-content" style="max-width: 800px;">
    <div class="dashboard-header animate-fade-in">
        <h1>Modifier l'Activité</h1>
        <p class="subtitle">Mise à jour de : <strong><?= esc($activite['nom']) ?></strong></p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/sports/update/' . $activite['id']) ?>" method="POST" class="pastel-form">
        <div class="card glass-card">
            <div class="card-header">
                <i class="fa-solid fa-dumbbell"></i>
                <h3>Détails de l'exercice</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nom">Nom de l'activité</label>
                    <input type="text" id="nom" name="nom" value="<?= esc($activite['nom']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="poids_variation">Variation de poids par séance (kg)</label>
                    <div class="input-with-hint">
                        <input type="number" step="0.01" id="poids_variation" name="poids_variation" value="<?= $activite['poids_variation'] ?>" required>
                        <span class="hint-badge">Kilos</span>
                    </div>
                    <small class="helper-text">
                        Utilisez une valeur négative (ex: -0.4) pour une activité qui fait perdre du poids.
                    </small>
                </div>
            </div>
        </div>

        <div class="form-footer-actions">
            <a href="<?= base_url('admin/sports') ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit-gradient">
                <i class="fa-solid fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>