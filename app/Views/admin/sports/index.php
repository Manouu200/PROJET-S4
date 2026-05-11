<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content">
    <div class="dashboard-header animate-fade-in space-between">
        <div>
            <h1>Activités Sportives</h1>
            <p class="subtitle">Gérez les exercices et leur impact sur le poids.</p>
        </div>
        <a href="<?= base_url('admin/sports/create') ?>" class="btn-submit-gradient">
            <i class="fa-solid fa-plus"></i> Nouvelle Activité
        </a>
    </div>

    <div class="card glass-card mt-30">
        <div class="table-responsive">
            <table class="pastel-table">
                <thead>
                    <tr>
                        <th>Nom de l'activité</th>
                        <th>Impact Poids</th>
                        <th>Type</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activites as $a): ?>
                    <tr>
                        <td class="font-bold"><?= esc($a['nom']) ?></td>
                        <td>
                            <span class="weight-tag <?= $a['poids_variation'] < 0 ? 'loss' : 'gain' ?>">
                                <?= ($a['poids_variation'] > 0 ? '+' : '') . $a['poids_variation'] ?> kg
                            </span>
                        </td>
                        <td>
                            <?php if($a['poids_variation'] < 0): ?>
                                <span class="badge b-poisson">Perte de poids</span>
                            <?php else: ?>
                                <span class="badge b-volaille">Prise de masse</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <a href="<?= base_url('admin/sports/edit/'.$a['id']) ?>" class="btn-icon edit"><i class="fa-solid fa-pen"></i></a>
                                <a href="<?= base_url('admin/sports/delete/'.$a['id']) ?>" class="btn-icon delete" onclick="return confirm('Supprimer ?')"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>