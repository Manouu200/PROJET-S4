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
        <div class="stat-progress"><small>Membres Gold (-<?= $remises ? $remises['pourcent_remise'] : 0 ?>%)</small></div>
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

<!-- 📊 GRAPHES INTERACTIFS -->
<section class="charts-container mt-30">
    <div class="row">
        <!-- Graphe 1: Utilisateurs (Pie Chart) -->
        <div class="col-lg-4 mb-30">
            <div class="chart-box glass-card animate-fade-in">
                <div class="card-header">
                    <i class="fa-solid fa-chart-pie"></i>
                    <h3>Répartition Utilisateurs</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 250px;">
                        <canvas id="chartUtilisateurs"></canvas>
                    </div>
                    <div class="chart-legend mt-3">
                        <div class="legend-item">
                            <span class="legend-color" style="background: #6c5ce7;"></span>
                            <small>Utilisateurs normaux: <strong><?= number_format($nombresClients - $nombresClientsGold, 0) ?></strong></small>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #f1c40f;"></span>
                            <small>Membres Gold: <strong><?= number_format($nombresClientsGold, 0) ?></strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphe 2: Programmes (Bar Chart) -->
        <div class="col-lg-4 mb-30">
            <div class="chart-box glass-card animate-fade-in" style="animation-delay: 0.1s;">
                <div class="card-header">
                    <i class="fa-solid fa-chart-column"></i>
                    <h3>Programmes & Activités</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 250px;">
                        <canvas id="chartProgrammes"></canvas>
                    </div>
                    <div class="chart-legend mt-3">
                        <div class="legend-item">
                            <span class="legend-color" style="background: #f1c40f;"></span>
                            <small>Régimes: <strong><?= number_format($nombresRegimes, 0) ?></strong></small>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #3498db;"></span>
                            <small>Sports: <strong><?= number_format($nombresSports, 0) ?></strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphe 3: Codes (Comparison) -->
        <div class="col-lg-4 mb-30">
            <div class="chart-box glass-card animate-fade-in" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <i class="fa-solid fa-chart-line"></i>
                    <h3>Status des Codes</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 250px;">
                        <canvas id="chartCodes"></canvas>
                    </div>
                    <div class="chart-legend mt-3">
                        <div class="legend-item">
                            <span class="legend-color" style="background: #2ecc71;"></span>
                            <small>Codes Valides: <strong><?= number_format($nbCodesValides, 0) ?></strong></small>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #e74c3c;"></span>
                            <small>Codes Utilisés: <strong><?= number_format($nbCodesUtilises, 0) ?></strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ⚡ ACTIONS RAPIDES -->
<section class="charts-container mt-30">
    <div class="chart-box glass-card animate-fade-in">
        <div class="card-header">
            <i class="fa-solid fa-zap"></i>
            <h3>Actions Rapides</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions-grid">
                <a href="<?= base_url('admin/regimes/create') ?>" class="action-item">
                    <i class="fa-solid fa-plus"></i>
                    <span>Nouveau Régime</span>
                </a>
                <a href="<?= base_url('admin/sports/create') ?>" class="action-item">
                    <i class="fa-solid fa-dumbbell"></i>
                    <span>Nouveau Sport</span>
                </a>
                <a href="<?= base_url('admin/codes/create') ?>" class="action-item">
                    <i class="fa-solid fa-ticket"></i> 
                    <span>Nouveau Code</span>
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

    /* Graphes */
    .charts-container {
        width: 100%;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin: 0;
    }

    .col-lg-4 {
        width: 100%;
    }

    .mb-30 {
        margin-bottom: 30px;
    }

    .chart-box {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .chart-box .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        max-height: 350px;
    }

    #chartUtilisateurs,
    #chartProgrammes,
    #chartCodes {
        max-height: 250px !important;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-header i {
        font-size: 1.3rem;
        color: #6c5ce7;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #2d3436;
    }

    .card-body {
        position: relative;
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chart-legend {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 15px;
        flex-shrink: 0;
        max-height: 80px;
        overflow-y: auto;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        display: inline-block;
        flex-shrink: 0;
    }

    .mt-3 {
        margin-top: 10px;
    }

    .mt-30 {
        margin-top: 30px;
    }

    /* Actions Rapides */
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

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

<!-- 📈 Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 🥧 Graphe 1: Répartition Utilisateurs (Pie Chart)
    const ctxUtilisateurs = document.getElementById('chartUtilisateurs').getContext('2d');
    new Chart(ctxUtilisateurs, {
        type: 'doughnut',
        data: {
            labels: ['Utilisateurs normaux', 'Membres Gold'],
            datasets: [{
                data: [
                    <?= $nombresClients - $nombresClientsGold ?>,
                    <?= $nombresClientsGold ?>
                ],
                backgroundColor: [
                    '#6c5ce7',
                    '#f1c40f'
                ],
                borderColor: ['#fff', '#fff'],
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // 📊 Graphe 2: Programmes (Bar Chart)
    const ctxProgrammes = document.getElementById('chartProgrammes').getContext('2d');
    new Chart(ctxProgrammes, {
        type: 'bar',
        data: {
            labels: ['Régimes', 'Sports'],
            datasets: [{
                label: 'Nombre',
                data: [
                    <?= $nombresRegimes ?>,
                    <?= $nombresSports ?>
                ],
                backgroundColor: [
                    '#f1c40f',
                    '#3498db'
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // 📈 Graphe 3: Status Codes (Line/Bar Comparison)
    const ctxCodes = document.getElementById('chartCodes').getContext('2d');
    new Chart(ctxCodes, {
        type: 'bar',
        data: {
            labels: ['Codes Valides', 'Codes Utilisés'],
            datasets: [{
                label: 'Nombre de codes',
                data: [
                    <?= $nbCodesValides ?>,
                    <?= $nbCodesUtilises ?>
                ],
                backgroundColor: [
                    '#2ecc71',
                    '#e74c3c'
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>