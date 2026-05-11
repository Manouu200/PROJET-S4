<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content animate-slide-up">
    <div class="dashboard-header">
        <h1><?= isset($categorie) ? 'Modifier' : 'Ajouter' ?> une tranche</h1>
        <p class="subtitle">Définissez les seuils de calcul pour les bilans nutritionnels</p>
    </div>

    <div class="glass-card mt-30" style="max-width: 800px; margin-left: auto; margin-right: auto;">
        <div class="card-header space-between">
            <div class="d-flex align-center gap-12">
                <i class="fa-solid fa-chart-pie"></i>
                <h3>Informations de la catégorie</h3>
            </div>
            <a href="<?= base_url('admin/imc') ?>" class="btn-cancel">
                <i class="fa-solid fa-xmark"></i> Annuler
            </a>
        </div>

        <div class="card-body">
            <form action="<?= isset($categorie) ? base_url('admin/imc/update/'.$categorie['id']) : base_url('admin/imc/store') ?>" method="POST">
                
                <div class="form-group">
                    <label>Nom de la catégorie</label>
                    <input type="text" name="libelle" value="<?= isset($categorie) ? esc($categorie['libelle']) : '' ?>" placeholder="Ex: Poids idéal, Obésité modérée..." required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Valeur IMC Minimum</label>
                        <input type="number" step="0.01" name="min" value="<?= isset($categorie) ? $categorie['min'] : '' ?>" placeholder="18.5" required>
                    </div>
                    <div class="form-group">
                        <label>Valeur IMC Maximum</label>
                        <input type="number" step="0.01" name="max" value="<?= isset($categorie) ? $categorie['max'] : '' ?>" placeholder="25.0" required>
                    </div>
                </div>

                <div class="form-footer-actions">
                    <a href="<?= base_url('admin/imc') ?>" class="btn-cancel">Retour à la liste</a>
                    <button type="submit" class="btn-submit-gradient">
                        <i class="fa-solid fa-check"></i> 
                        <?= isset($categorie) ? 'Mettre à jour' : 'Enregistrer la tranche' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .gap-12 { gap: 12px; }
</style>
<?= $this->endSection() ?>