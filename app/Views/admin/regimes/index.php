<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>Liste des Régimes<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-page-content">
    <div class="dashboard-header animate-fade-in space-between">
        <div>
            <h1> Gestion des Régimes</h1>
            <p class="subtitle">Visualisez, modifiez ou gérez les tarifs de vos programmes.</p>
        </div>
        <a href="<?= base_url('admin/regimes/create') ?>" class="btn-submit-gradient">
            <i class="fa-solid fa-plus"></i> Nouveau Régime
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card glass-card mt-30">
        <div class="table-responsive">
            <table class="pastel-table">
                <thead>
                    <tr>
                        <th>Nom du Régime</th>
                        <th>Composition (%)</th>
                        <th>Objectif Poids</th>
                        <th>Durée Réf.</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($regimes) && is_array($regimes)) : ?>
                        <?php foreach ($regimes as $r) : ?>
                            <tr>
                                <?php
                                    $nom = $r['nom'] ?? '';
                                    while (is_array($nom)) {
                                        $nom = array_values($nom)[0] ?? '';
                                    }
                                    $nom = is_scalar($nom) ? (string) $nom : '';
                                ?>
                                <td class="font-bold"><?= esc($nom) ?></td>
                                <td>
                                    <div class="comp-badges">
                                        <span class="badge b-viande" title="Viande"><?= $r['pourcent_viande'] ?>% Viande</span>
                                        <span class="badge b-poisson" title="Poisson"><?= $r['pourcent_poisson'] ?>% Poisson</span>
                                        <span class="badge b-volaille" title="Volaille"><?= $r['pourcent_volaille'] ?>% Volaille</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="weight-tag <?= $r['poids_variation'] < 0 ? 'loss' : 'gain' ?>">
                                        <?= ($r['poids_variation'] > 0 ? '+' : '') . $r['poids_variation'] ?> kg
                                    </span>
                                </td>
                                <td><?= $r['duree_jours'] ?> jours</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= base_url('admin/regimes/edit/' . $r['id']) ?>" class="btn-icon edit" title="Modifier">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/regimes/delete/' . $r['id']) ?>" class="btn-icon delete" title="Supprimer" onclick="return confirm('Supprimer ce régime et ses prix associés ?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun régime enregistré pour le moment.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>