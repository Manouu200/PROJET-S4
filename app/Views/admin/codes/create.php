a<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content" style="max-width: 600px;">
    <div class="dashboard-header animate-fade-in">
        <h1> Générer un Code</h1>
        <p class="subtitle">Entrez le montant pour créer un nouveau jeton unique.</p>
    </div>

    <form action="<?= base_url('admin/codes/store') ?>" method="POST" class="pastel-form mt-20">
        <div class="card glass-card">
            <div class="card-body">
                <div class="form-group">
                    <label for="montant">Montant de la recharge (en Euro)</label>
                    <div class="input-with-hint">
                        <input type="number" id="montant" name="montant" placeholder="ex: 100" min="1" required>
                        <span class="hint-badge">£</span>
                    </div>
                    <small class="helper-text">
                        Le code sera généré sous le format <strong>CD[MONTANT]-[ID]</strong>.
                    </small>
                </div>
            </div>
        </div>

        <div class="form-footer-actions">
            <a href="<?= base_url('admin/codes') ?>" class="btn-cancel">Retour à la liste</a>
            <button type="submit" class="btn-submit-gradient">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Générer le code
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>