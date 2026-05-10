<?php

/**
 * @var mixed $utilisateur
 * @var mixed $objectifs
 */
?>

<!-- ══════════════════════════════════════════
     Section Hero — Régimes
══════════════════════════════════════════ -->
<section class="hero-section hero-section--regimes">
    <div class="hero-inner">
        <div class="hero-text">
            <span class="hero-badge">✦ Programmes &amp; Régimes</span>
            <h1 class="hero-title">Trouvez votre<br>programme <em>idéal</em>.</h1>
            <p class="hero-sub">
                Sélectionnez votre <strong>objectif</strong> et découvrez les régimes
                adaptés à votre profil IMC personnalisé.
            </p>
        </div>
        <div class="hero-visual">
            <div class="regimes-hero-icon">
                <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" width="130" height="130">
                    <circle cx="60" cy="60" r="54" fill="none" stroke="#e0eefc" stroke-width="8" />
                    <circle cx="60" cy="60" r="54" fill="none" stroke="url(#regimesGrad)" stroke-width="8"
                        stroke-dasharray="339" stroke-dashoffset="85" stroke-linecap="round"
                        transform="rotate(-90 60 60)" />
                    <defs>
                        <linearGradient id="regimesGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#4a90e2" />
                            <stop offset="50%" stop-color="#5cb85c" />
                            <stop offset="100%" stop-color="#f39c12" />
                        </linearGradient>
                    </defs>
                    <!-- Fourchette & couteau stylisés -->
                    <line x1="48" y1="38" x2="48" y2="82" stroke="#4a90e2" stroke-width="3" stroke-linecap="round" />
                    <path d="M44,38 Q48,50 52,38" fill="none" stroke="#4a90e2" stroke-width="2.5" stroke-linecap="round" />
                    <line x1="72" y1="38" x2="72" y2="82" stroke="#5cb85c" stroke-width="3" stroke-linecap="round" />
                    <path d="M68,38 L68,54 Q72,58 76,54 L76,38" fill="none" stroke="#5cb85c" stroke-width="2.5" stroke-linecap="round" />
                    <line x1="72" y1="58" x2="72" y2="82" stroke="#5cb85c" stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#ffffff" />
        </svg>
    </div>
</section>

<!-- ══════════════════════════════════════════
     Section Principale : Profil + Formulaire
══════════════════════════════════════════ -->
<section class="regimes-main-section">
    <div class="regimes-layout">

        <!-- ── Colonne gauche : Profil ── -->
        <aside class="regimes-profile-aside">
            <div class="regimes-profile-card">
                <div class="regimes-profile-header">
                    <div class="benefit-icon benefit-icon--blue" style="margin-bottom:0;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <div>
                        <span class="section-badge">Mon profil</span>
                        <h3 class="regimes-profile-title">Votre bilan santé</h3>
                    </div>
                </div>

                <?php if (! empty($utilisateur)): ?>
                    <div class="regimes-profile-stats">
                        <div class="regimes-stat-item">
                            <span class="regimes-stat-label">Poids</span>
                            <strong class="regimes-stat-value"><?= esc((string) ($utilisateur['poids'] ?? '--')) ?> <small>kg</small></strong>
                        </div>
                        <div class="regimes-stat-item">
                            <span class="regimes-stat-label">Taille</span>
                            <strong class="regimes-stat-value"><?= esc((string) ($utilisateur['taille'] ?? '--')) ?> <small>cm</small></strong>
                        </div>
                        <div class="regimes-stat-item regimes-stat-item--imc">
                            <span class="regimes-stat-label">IMC</span>
                            <strong class="regimes-stat-value regimes-stat-imc">
                                <?= isset($utilisateur['imc']) && $utilisateur['imc'] !== null
                                    ? esc(number_format((float) $utilisateur['imc'], 1, '.', ''))
                                    : '--' ?>
                            </strong>
                        </div>
                        <div class="regimes-stat-item">
                            <span class="regimes-stat-label">Catégorie</span>
                            <strong class="regimes-stat-value regimes-stat-cat">
                                <?= (isset($utilisateur['imc']) && $utilisateur['imc'] !== null)
                                    ? esc(\App\Libraries\Utils::categorieIMC((float) $utilisateur['imc']))
                                    : '--' ?>
                            </strong>
                        </div>
                    </div>


                <?php else: ?>
                    <div class="regimes-no-data">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#dee2e6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <p>Complétez votre profil pour voir vos données.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Conseil rapide -->
            <div class="health-hint" style="margin-top:16px;">
                <span class="hint-icon">💡</span>
                <span>Votre programme est calculé selon les standards <strong>OMS</strong> et votre profil personnel.</span>
            </div>
        </aside>

        <!-- ── Colonne droite : Formulaire + Résultats ── -->
        <div class="regimes-content">

            <!-- Formulaire objectif -->
            <div class="regimes-form-card">
                <div class="regimes-form-header">
                    <div class="step-shape step-shape--rounded" style="width:44px;height:44px;flex-shrink:0;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </div>
                    <div>
                        <span class="section-badge">Étape 1</span>
                        <h2 class="regimes-form-title">Choisissez votre objectif</h2>
                    </div>
                </div>

                <form id="regimes-form" method="post" action="">

                    <?php if (! empty($objectifs) && is_array($objectifs)): ?>
                        <?php
                        $objectifMetas = [
                            1 => [
                                'icon' => 'assets/perdre-du-poids.png',
                                'color' => 'green',
                                'desc' => 'Saisissez le poids que vous voulez perdre.',
                            ],
                            2 => [
                                'icon' => 'assets/prendre-du-poids.png',
                                'color' => 'orange',
                                'desc' => 'Saisissez le poids que vous voulez prendre.',
                            ],
                            3 => [
                                'icon' => 'assets/IMC-ideal.png',
                                'color' => 'blue',
                                'desc' => 'Votre poids idéal cible selon votre IMC.',
                            ],
                        ];
                        ?>

                        <div class="regimes-objectifs-layout">
                            <div class="regimes-objectifs-grid" id="regimes-objectifs-grid">
                                <?php foreach ($objectifs as $obj):
                                    $objectifId = (int) ($obj['id'] ?? 0);
                                    $meta = $objectifMetas[$objectifId] ?? $objectifMetas[3];
                                    $metaColor = (string) ($meta['color'] ?? 'blue');
                                    $metaDesc = (string) ($meta['desc'] ?? '');
                                ?>
                                    <label class="regimes-objectif-card regimes-objectif-card--<?= esc($metaColor) ?>" data-objectif-id="<?= esc((string) $objectifId) ?>" for="objectif-<?= esc((string) $objectifId) ?>">
                                        <input type="radio"
                                            name="objectif"
                                            id="objectif-<?= esc((string) $objectifId) ?>"
                                            value="<?= esc((string) $objectifId) ?>"
                                            <?= old('objectif') == $objectifId ? 'checked' : '' ?>>
                                        <img src="<?= base_url($meta['icon']) ?>" alt="Objectif" class="regimes-objectif-icon" style="width:32px;height:32px;object-fit:contain;">
                                        <span class="regimes-objectif-name"><?= esc((string) ($obj['nom_objectif'] ?? '')) ?></span>
                                        <span class="regimes-objectif-desc"><?= esc($metaDesc) ?></span>
                                        <span class="regimes-objectif-check">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="regimes-objectif-panel" id="regimes-objectif-panel" hidden
                                data-poids-actuel="<?= esc((string) ($poids_actuel ?? '')) ?>"
                                data-poids-ideal="<?= esc((string) ($poids_ideal ?? '')) ?>">
                                <div class="regimes-objectif-panel-head">
                                    <span class="section-badge" id="regimes-objectif-panel-badge">Calcul objectif</span>
                                    <h3 class="regimes-objectif-panel-title" id="regimes-objectif-panel-title">Cliquez sur un objectif</h3>
                                    <p class="regimes-objectif-panel-subtitle" id="regimes-objectif-panel-subtitle">Le calcul s'affichera ici.</p>
                                </div>

                                <div class="regimes-objectif-field" id="regimes-objectif-field" hidden>
                                    <label class="regimes-objectif-field-label" for="regimes-objectif-input" id="regimes-objectif-field-label">Poids à perdre</label>
                                    <div class="regimes-objectif-input-row">
                                        <input type="number" id="regimes-objectif-input" min="0" step="0.1" inputmode="decimal" placeholder="0">
                                        <span class="regimes-objectif-unit">kg</span>
                                    </div>
                                </div>

                                <div class="regimes-objectif-summary" aria-live="polite">
                                    <span class="regimes-objectif-summary-label" id="regimes-objectif-summary-label">Objectif</span>
                                    <strong class="regimes-objectif-summary-value" id="regimes-objectif-summary-value">-- kg</strong>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p style="color:var(--text-secondary);font-size:0.9em;">Aucun objectif disponible pour le moment.</p>
                    <?php endif; ?>

                    <div style="margin-top:22px;">
                        <button type="button" class="btn-primary" id="regimes-submit-btn" style="width:100%;margin-top:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:6px;">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            Voir les programmes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Résultats -->
            <div class="regimes-results-section" id="regimes-results">
                <div class="regimes-results-header">
                    <div class="step-shape step-shape--hex" style="width:44px;height:44px;flex-shrink:0;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                        </svg>
                    </div>
                    <div>
                        <span class="section-badge" style="background:#eaf7ea;color:var(--green-dark);">Étape 2</span>
                        <h2 class="regimes-form-title">Régimes recommandés</h2>
                    </div>
                </div>

                <div class="regimes-cards-grid">

                    <!-- Carte régime Keto -->
                    <div class="regime-card regime-card--blue">
                        <div class="regime-card-top">

                            <span class="regime-card-badge">Populaire</span>
                        </div>
                        <h4 class="regime-card-title">Régime Keto</h4>
                        <p class="regime-card-objectif">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:4px;">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 8 12 12 14 14" />
                            </svg>
                            Perte de poids
                        </p>
                        <div class="regime-card-stats">
                            <div class="regime-stat">
                                <span class="regime-stat-val">1 500</span>
                                <span class="regime-stat-unit">kcal/jour</span>
                            </div>
                            <div class="regime-stat">
                                <span class="regime-stat-val">8–12</span>
                                <span class="regime-stat-unit">semaines</span>
                            </div>
                        </div>
                        <div class="regime-card-tags">
                            <span class="badge-pill badge-pill--blue">Faible glucides</span>
                            <span class="badge-pill badge-pill--orange">Protéines</span>
                        </div>
                        <button type="button" class="regime-card-btn btn-primary" style="margin-top:14px;">
                            Choisir ce régime
                        </button>
                    </div>

                    <!-- Carte régime Sportif -->
                    <div class="regime-card regime-card--green">
                        <div class="regime-card-top">

                            <span class="regime-card-badge regime-card-badge--green">Recommandé</span>
                        </div>
                        <h4 class="regime-card-title">Régime Sportif</h4>
                        <p class="regime-card-objectif">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:4px;">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 8 12 12 14 14" />
                            </svg>
                            Prise de masse
                        </p>
                        <div class="regime-card-stats">
                            <div class="regime-stat">
                                <span class="regime-stat-val">2 800</span>
                                <span class="regime-stat-unit">kcal/jour</span>
                            </div>
                            <div class="regime-stat">
                                <span class="regime-stat-val">12–16</span>
                                <span class="regime-stat-unit">semaines</span>
                            </div>
                        </div>
                        <div class="regime-card-tags">
                            <span class="badge-pill badge-pill--green">Protéines élevées</span>
                            <span class="badge-pill badge-pill--blue">Glucides</span>
                        </div>
                        <button type="button" class="regime-card-btn btn-success" style="margin-top:14px;">
                            Choisir ce régime
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>