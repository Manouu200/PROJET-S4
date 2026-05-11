<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content animate-slide-up">
    <div class="dashboard-header">
        <h1>Ajuster la Remise Gold</h1>
        <p class="subtitle">Définissez le nouveau pourcentage qui sera appliqué aux clients Gold</p>
    </div>

    <div class="glass-card mt-30" style="max-width: 500px; margin: 0 auto;">
        <div class="card-header">
            <i class="fa-solid fa-percentage"></i>
            <h3>Nouvelle configuration</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/remises/store') ?>" method="POST">
                <div class="form-group">
                    <label>Pourcentage de réduction (%)</label>
                    <input type="number" step="0.01" name="pourcent_remise" 
                           placeholder="Ex: 15.00" class="form-control" required>
                    <small style="color: #636e72; display:block; mt-2;">
                        Cette valeur sera immédiatement visible par les utilisateurs sur le site.
                    </small>
                </div>

                <div class="form-footer-actions">
                    <button type="submit" class="btn-submit-gradient w-100 justify-center">
                        <i class="fa-solid fa-check"></i> Appliquer la remise
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>