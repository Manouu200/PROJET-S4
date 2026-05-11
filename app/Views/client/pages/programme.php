<?php

/**
 * @var array $programmes
 * @var array|null $lastProgrammeBought
 * @var int|null $lastProgrammeId
 * @var float|null $poids_actuel
 */
?>

<div class="page-box">

    <!-- ── SECTION RÉSUMÉ ───────────────────────── -->
    <div class="imc-card">
        <div class="imc-header">
            <div>
                <span class="imc-badge">Programmes</span>
                <h2>Mes programmes</h2>
            </div>

            <div class="imc-value">
                <?= count($programmes) ?>
            </div>
        </div>

        <div class="imc-status">
            <span class="status-dot"></span>
            <?php if (empty($programmes)): ?>
                Aucun programme acheté pour le moment
            <?php else: ?>
                <?= count($programmes) ?> programme<?= count($programmes) > 1 ? 's' : '' ?> acheté<?= count($programmes) > 1 ? 's' : '' ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── SECTION PROGRAMMES ───────────────────── -->
    <div class="profile-section">

        <div class="section-heading">
            <span class="section-badge">Historique</span>
            <h1>Vos programmes achetés</h1>
            <p>
                Retrouvez l'ensemble des programmes nutritionnels que vous avez
                souscrits et suivez votre progression santé.
            </p>
        </div>

        <!-- Cards style benefits -->
        <div class="benefits-grid profile-benefits">

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--blue">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                        <rect x="9" y="3" width="6" height="4" rx="2" />
                        <path d="M9 12h6M9 16h4" />
                    </svg>
                </div>
                <h4>Programme personnalisé</h4>
                <p>Chaque programme est adapté à votre profil et vos objectifs de santé.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--green">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </div>
                <h4>Suivi de progression</h4>
                <p>Visualisez l'objectif de poids final et la durée de chaque programme.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--gold">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6" />
                        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" />
                    </svg>
                </div>
                <h4>Activité sportive</h4>
                <p>Chaque programme intègre des recommandations d'activité physique adaptées.</p>
            </div>

        </div>

        <div style="margin: 28px 0 24px; height: 1px; background: var(--border);"></div>

        <!-- Liste des programmes -->
        <?php if (empty($programmes)): ?>
            <div class="profile-form" style="text-align:center; padding: 40px 28px; color: var(--text-secondary);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    style="margin-bottom:16px; opacity:0.4;">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                    <rect x="9" y="3" width="6" height="4" rx="2" />
                </svg>
                <p style="font-size:1em; font-weight:600; margin-bottom:8px;">Aucun programme acheté</p>
                <p style="font-size:0.88em;">Rendez-vous dans la section Régimes pour souscrire à votre premier programme.</p>
            </div>
        <?php else: ?>
            <div class="programmes-cards-list">
                <?php foreach ($programmes as $idx => $programme): ?>
                    <?php
                    $duree = $programme['duree'] ?? $programme['duree_regime'] ?? null;

                    $poidsFinalDisplay = '--';
                    if (isset($programme['poids_final'])) {
                        $poidsFinalDisplay = number_format((float)$programme['poids_final'], 1, '.', '') . ' kg';
                    } elseif (isset($programme['poids_variation']) && isset($poids_actuel) && $poids_actuel !== null) {
                        $calc = (float)$poids_actuel + (float)$programme['poids_variation'];
                        $poidsFinalDisplay = number_format($calc, 1, '.', '') . ' kg';
                    }

                    $activiteAffiche = $programme['activite_nom'] ?? null;
                    if (empty($activiteAffiche) && $idx === $lastProgrammeId && !empty($lastProgrammeBought['sport'])) {
                        $activiteAffiche = $lastProgrammeBought['sport'];
                    }

                    $isLast = ($idx === $lastProgrammeId);
                    ?>

                    <div class="programme-detail-card<?= $isLast ? ' programme-detail-card--last' : '' ?>">

                        <!-- En-tête de la carte -->
                        <div class="programme-detail-header">
                            <div class="programme-detail-title-row">
                                <h3 class="programme-detail-name">
                                    <?= esc((string)($programme['regime_nom'] ?? 'Programme')) ?>
                                </h3>
                                <?php if ($isLast): ?>
                                    <span class="programme-last-badge">Dernier acheté</span>
                                <?php endif; ?>
                            </div>
                            <p class="programme-detail-date">
                                Acheté le <?= esc((string)($programme['date_decision'] ?? '--')) ?>
                            </p>
                        </div>

                        <!-- Statistiques principales -->
                        <div class="programme-stats-grid">
                            <div class="programme-stat-item">
                                <span class="programme-stat-label">Objectif final</span>
                                <span class="programme-stat-value"><?= esc($poidsFinalDisplay) ?></span>
                            </div>
                            <div class="programme-stat-item">
                                <span class="programme-stat-label">Durée</span>
                                <span class="programme-stat-value">
                                    <?= $duree !== null ? esc((string)$duree) . ' jours' : '--' ?>
                                </span>
                            </div>
                            <div class="programme-stat-item">
                                <span class="programme-stat-label">Activité sportive</span>
                                <span class="programme-stat-value">
                                    <?= esc((string)($activiteAffiche ?? 'Aucune')) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Répartition alimentaire -->
                        <div class="programme-alimentation">
                            <p class="programme-alimentation-title">Répartition alimentaire</p>
                            <div class="programme-alimentation-grid">
                                <div class="programme-alim-item">
                                    <div class="programme-alim-icon">
                                        <img src="<?= base_url('assets/viandes.png') ?>" alt="Viande" style="width:24px;height:24px;object-fit:contain;" />
                                    </div>
                                    <span class="programme-alim-label">Viande</span>
                                    <span class="programme-alim-value">
                                        <?= isset($programme['pourcent_viande']) ? esc((string)$programme['pourcent_viande']) . ' %' : '--' ?>
                                    </span>
                                </div>
                                <div class="programme-alim-item">
                                    <div class="programme-alim-icon">
                                        <img src="<?= base_url('assets/poisson.png') ?>" alt="Poisson" style="width:24px;height:24px;object-fit:contain;" />
                                    </div>
                                    <span class="programme-alim-label">Poisson</span>
                                    <span class="programme-alim-value">
                                        <?= isset($programme['pourcent_poisson']) ? esc((string)$programme['pourcent_poisson']) . ' %' : '--' ?>
                                    </span>
                                </div>
                                <div class="programme-alim-item">
                                    <div class="programme-alim-icon">
                                        <img src="<?= base_url('assets/volaille.png') ?>" alt="Volaille" style="width:24px;height:24px;object-fit:contain;" />
                                    </div>
                                    <span class="programme-alim-label">Volaille</span>
                                    <span class="programme-alim-value">
                                        <?= isset($programme['pourcent_volaille']) ? esc((string)$programme['pourcent_volaille']) . ' %' : '--' ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton export PDF -->
                        <div style="margin-top:22px;">
                            <a href="<?= base_url('client/programmes/export-pdf/' . $programme['id']) ?>" class="btn-primary" style="width:100%;margin-top:0;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;min-height:52px;padding:14px 22px;font-size:1rem;font-weight:700;line-height:1.2;">
                                <img src="<?= base_url('assets/telechargement.png') ?>" alt="Téléchargement" style="width:22px;height:22px;object-fit:contain;margin-right:8px;flex-shrink:0;" />
                                Exporter en PDF
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</div>