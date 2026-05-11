<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content animate-fade-in">
    <div class="dashboard-header d-flex justify-between align-center">
        <div>
            <h1>Paramètres IMC</h1>
            <p class="subtitle">Configuration des tranches et catégories corporelles</p>
        </div>
        <a href="<?= base_url('admin/imc/create') ?>" class="btn-submit-gradient" style="text-decoration: none;">
            <i class="fa-solid fa-plus"></i> Nouvelle Tranche
        </a>
    </div>

    <div class="glass-card mt-30">
        <div class="card-header">
            <i class="fa-solid fa-table-list"></i>
            <h3>Liste des catégories d'IMC</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="pastel-table">
                    <thead>
                        <tr>
                            <th>Libellé / Catégorie</th>
                            <th>Minimum</th>
                            <th>Maximum</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $cat): ?>
                        <tr>
                            <td><span class="font-bold"><?= esc($cat['libelle']) ?></span></td>
                            <td><span class="badge b-poisson"><?= number_format($cat['min'], 2) ?></span></td>
                            <td><span class="badge b-viande"><?= number_format($cat['max'], 2) ?></span></td>
                            <td class="text-right">
                                <div class="action-buttons justify-end">
                                    <a href="<?= base_url('admin/imc/edit/'.$cat['id']) ?>" class="btn-icon edit" title="Modifier">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= base_url('admin/imc/delete/'.$cat['id']) ?>" 
                                       class="btn-icon delete" 
                                       onclick="return confirm('Supprimer cette tranche ?')" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .justify-end { justify-content: flex-end; }
</style>
<?= $this->endSection() ?>