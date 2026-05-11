<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content animate-fade-in">
    <div class="dashboard-header d-flex justify-between align-center">
        <div>
            <h1>Gestion Remise Gold</h1>
            <p class="subtitle">Historique et configuration du pourcentage de réduction</p>
        </div>
        <a href="<?= base_url('admin/remises/create') ?>" class="btn-submit-gradient" style="text-decoration: none;">
            <i class="fa-solid fa-plus"></i> Nouvelle Remise
        </a>
    </div>

    <div class="glass-card mt-30">
        <div class="card-header">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <h3>Historique des remises appliquées</h3>
        </div>
        <div class="card-body p-0">
            <table class="pastel-table">
                <thead>
                    <tr>
                        <th>Date d'application</th>
                        <th>Pourcentage</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($remises as $key => $r): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                        <td><span class="badge b-poisson" style="font-size: 1rem;"><?= $r['pourcent_remise'] ?> %</span></td>
                        <td>
                            <?php if($key === 0): ?>
                                <span class="weight-tag loss">Actif actuellement</span>
                            <?php else: ?>
                                <span class="badge" style="background:#eee; color:#999;">Ancien</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons justify-end">
                                <a href="<?= base_url('admin/remises/delete/'.$r['id']) ?>" 
                                   class="btn-icon delete" 
                                   onclick="return confirm('Supprimer cette archive ?')">
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
<?= $this->endSection() ?>