<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
    Tableau de Bord
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="dashboard-header">
        <h1>Statistiques Globales</h1>
        <p class="subtitle">Aperçu de l'activité de NutriPlan .</p>
    </div>

    <section class="stats-grid">
        <div class="stat-card pastel-green">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-details">
                <span class="label">Utilisateurs</span>
                <span class="value"><?= $nombresClients ?? 0 ?></span>
            </div>
            <div class="stat-progress">
                <small>Total inscrits</small>
            </div>
        </div>

        <div class="stat-card pastel-blue">
            <div class="stat-icon">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="stat-details">
                <span class="label">Revenus Totaux</span>
                <span class="value"><?= number_format($totalRevenus ?? 0, 0, ',', ' ') ?> Ar</span>
            </div>
            <div class="stat-progress">
                <small>Codes validés & Gold</small>
            </div>
        </div>

        <div class="stat-card pastel-yellow">
            <div class="stat-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <div class="stat-details">
                <span class="label">Régimes</span>
                <span class="value"><?= $nombreRegimes ?? 5 ?></span>
            </div>
            <div class="stat-progress">
                <small>Programmes disponibles</small>
            </div>
        </div>
    </section>

    <section class="charts-container">
        <div class="chart-box">
            <h3>Évolution des inscriptions</h3>
            <div class="chart-placeholder">
                <p>Graphique des tendances (À venir)</p>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>