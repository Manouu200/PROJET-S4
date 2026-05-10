<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="admin-page-content">
    
    <section class="stats-grid mb-30">
        <div class="stat-card pastel-blue animate-slide-in">
            <div class="stat-icon"><i class="fa-solid fa-ticket"></i></div>
            <div class="stat-details">
                <span class="label">Codes Valides</span>
                <span class="value"><?= $totalValides ?></span>
            </div>
        </div>
        <div class="stat-card pastel-green animate-slide-in" style="animation-delay: 0.1s;">
            <div class="stat-icon"><i class="fa-solid fa-check-double"></i></div>
            <div class="stat-details">
                <span class="label">Codes Utilisés</span>
                <span class="value"><?= $totalUtilises ?></span>
            </div>
        </div>
    </section>

    <div class="dashboard-header space-between animate-fade-in">
        <div>
            <h1> Codes de Recharge</h1>
            <p class="subtitle">Liste des jetons générés pour le porte-monnaie.</p>
        </div>
        <a href="<?= base_url('admin/codes/create') ?>" class="btn-submit-gradient">
            <i class="fa-solid fa-plus"></i> Nouveau Montant
        </a>
    </div>

    <div class="card glass-card mt-20 animate-fade-in">
        <div class="table-responsive">
            <table class="pastel-table">
                <thead>
                    <tr>
                        <th>Code Unique</th>
                        <th>Valeur (£)</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($codes)): ?>
                        <tr><td colspan="5" style="text-align:center;">Aucun code généré pour le moment.</td></tr>
                    <?php endif; ?>
                    
                    <?php foreach ($codes as $c): ?>
                    <tr>
                        <td><code style="font-size: 1.1rem; color: #6c5ce7; font-weight: 700;"><?= $c['code'] ?></code></td>
                        <td class="font-bold"><?= number_format($c['montant'], 2, '.', ' ') ?> £</td>
                        <td>
                            <?php if($c['est_utilise'] == 1): ?>
                                <span class="badge b-viande">Utilisé</span>
                            <?php else: ?>
                                <span class="badge b-poisson">Disponible</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                        <td style="text-align: right;">
                            <?php if($c['est_utilise'] == 0): ?>
                                <a href="<?= base_url('admin/codes/delete/'.$c['id']) ?>" 
                                   class="btn-icon delete" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer ce code ?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted" style="font-size: 0.85rem;">Consommé</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>