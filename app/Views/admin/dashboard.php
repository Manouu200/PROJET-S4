<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>Tableau de Bord<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-header animate-fade-in">
    <h1>Statistiques Globales</h1>
    <p class="subtitle">Aperçu en temps réel de l'activité de NutriPlan.</p>
</div>

<section class="stats-grid gold-dashboard">

    <div class="stat-card pastel-green animate-slide-in">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <div class="stat-details">
            <span class="label">Utilisateurs</span>
            <span class="value"><?= number_format($nombresClients, 0, '.', ' ') ?></span>
        </div>
        <div class="stat-progress"><small>Membres inscrits</small></div>
    </div>

    <div class="stat-card pastel-gold animate-slide-in" style="animation-delay: 0.1s;">
        <div class="stat-icon"><i class="fa-solid fa-crown"></i></div>
        <div class="stat-details">
            <span class="label">Membres Gold</span>
            <span class="value"><?= number_format($nombresClientsGold, 0, '.', ' ') ?></span>
        </div>
        <div class="stat-progress"><small>Membres Gold (-15%)</small></div>
    </div>

    <div class="stat-card pastel-yellow animate-slide-in" style="animation-delay: 0.2s;">
        <div class="stat-icon"><i class="fa-solid fa-utensils"></i></div>
        <div class="stat-details">
            <span class="label">Régimes</span>
            <span class="value"><?= number_format($nombresRegimes, 0, '.', ' ') ?></span>
        </div>
        <div class="stat-progress"><small>Programmes actifs</small></div>
    </div>

    <div class="stat-card pastel-blue animate-slide-in" style="animation-delay: 0.3s;">
        <div class="stat-icon"><i class="fa-solid fa-person-running"></i></div>
        <div class="stat-details">
            <span class="label">Sports</span>
            <span class="value"><?= number_format($nombresSports, 0, '.', ' ') ?></span>
        </div>
        <div class="stat-progress"><small>Activités sportives</small></div>
    </div>

</section>

<section class="stats-grid mt-30">
    <div class="stat-card pastel-green animate-slide-in" style="border-left: 5px solid #2ecc71;">
        <div class="stat-icon"><i class="fa-solid fa-money-bill-trend-up"></i></div>
        <div class="stat-details">
            <span class="label">Total Codes Utilisés</span>
            <span class="value"><?= number_format($montantCodesUtilises, 0, '.', ' ') ?> £</span>
        </div>
        <div class="stat-progress">
            <small>Sur <strong><?= $nbCodesUtilises ?></strong> codes utilisés</small>
        </div>
    </div>

    <div class="stat-card pastel-blue animate-slide-in" style="border-left: 5px solid #3498db;">
        <div class="stat-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
        <div class="stat-details">
            <span class="label">Total Codes en Valides</span>
            <span class="value"><?= number_format($montantCodesValides, 0, '.', ' ') ?> £</span>
        </div>
        <div class="stat-progress">
            <small>Sur <strong><?= $nbCodesValides ?></strong> codes valides</small>
        </div>
    </div>
</section>

<section class="charts-container mt-30">
    <div class="chart-box glass-card animate-fade-in">
        <div class="card-header">
            <i class="fa-solid fa-chart-line"></i>
            <h3>Actions Rapides</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions-grid">
                <a href="<?= base_url('admin/regimes/create') ?>" class="action-item">
                    <i class="fa-solid fa-plus"></i>
                    <span>Nouveau Régime</span>
                </a>
                <a href="<?= base_url('admin/activites/create') ?>" class="action-item">
                    <i class="fa-solid fa-dumbbell"></i>
                    <span>Nouveau Sport</span>
                </a>
                <a href="<?= base_url('admin/codes/create') ?>" class="action-item">
                    <i class="fa-solid fa-ticket"></i> 
                    <span>Nouveau Code de recharge</span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Couleur Gold spécifique pour le nouveau card */
    .pastel-gold {
        background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
        border: 1px solid #ffeeba;
    }

    .pastel-gold .stat-icon {
        color: #f1c40f;
    }

    .pastel-gold .value {
        color: #d4ac0d;
    }

    /* Ajustement de la grille pour 4 éléments */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    /* --- Ton CSS existant --- */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }

    .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background: #f8fafc;
        border-radius: 15px;
        text-decoration: none;
        color: #4b5563;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .action-item:hover {
        background: #ffffff;
        border-color: #6c5ce7;
        color: #6c5ce7;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(108, 92, 231, 0.1);
    }

    .action-item i {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
</style>
<?= $this->endSection() ?>