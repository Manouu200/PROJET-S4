<?php

/** @var float|null $imc */
?>

<!-- ══════════════════════════════════════════
     Section 1 : Hero — La Promesse
══════════════════════════════════════════ -->
<section class="hero-section">
    <div class="hero-inner">
        <div class="hero-text">
            <span class="hero-badge">✦ Nutrition &amp; Sport</span>
            <h1 class="hero-title">Votre santé mérite<br>un plan <em>sur-mesure</em>.</h1>
            <p class="hero-sub">
                Découvrez comment <strong>NutriPlan</strong> équilibre votre IMC
                grâce à la science et au sport.
            </p>
        </div>
        <div class="hero-visual">
            <div class="imc-ring" data-imc="<?= esc($imc !== null ? number_format((float)$imc, 1, '.', '') : '') ?>">
                <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="52" fill="none" stroke="#e0eefc" stroke-width="10" />
                    <circle id="ringProgress" cx="60" cy="60" r="52" fill="none" stroke="url(#ringGrad)" stroke-width="10"
                        stroke-dasharray="220" stroke-dashoffset="220" stroke-linecap="round" transform="rotate(-90 60 60)" />
                    <defs>
                        <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#4a90e2" />
                            <stop offset="20%" stop-color="#4a90e2" />
                            <stop offset="20%" stop-color="#5cb85c" />
                            <stop offset="55%" stop-color="#5cb85c" />
                            <stop offset="55%" stop-color="#f39c12" />
                            <stop offset="75%" stop-color="#f39c12" />
                            <stop offset="75%" stop-color="#e74c3c" />
                            <stop offset="100%" stop-color="#e74c3c" />
                        </linearGradient>
                    </defs>
                    <text id="ringImcText" x="60" y="55" text-anchor="middle" font-family="Playfair Display,serif"
                        font-size="18" fill="#2c3e50" font-weight="700"><?= esc($imc !== null ? number_format((float)$imc, 1, '.', '') : '--') ?></text>
                    <text x="60" y="72" text-anchor="middle" font-family="Nunito,sans-serif"
                        font-size="9" fill="#6c757d" font-weight="600">VOTRE IMC</text>
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
     Section 2 : Le Concept en 3 Étapes
══════════════════════════════════════════ -->
<section class="steps-section">
    <h2 class="section-title">Comment ça marche ?</h2>
    <p class="section-sub">Trois étapes simples vers votre équilibre.</p>

    <div class="steps-grid">

        <div class="step-card step-card--blue">
            <div class="step-shape step-shape--circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <span class="step-num">01</span>
            <h3>Le Bilan</h3>
            <p>Nous analysons vos données de santé : taille, poids et genre pour calculer votre IMC précis.</p>
        </div>

        <div class="step-card step-card--green">
            <div class="step-shape step-shape--rounded">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
            </div>
            <span class="step-num">02</span>
            <h3>L'Objectif</h3>
            <p>Vous choisissez votre but : perdre, gagner ou stabiliser votre poids selon vos besoins.</p>
        </div>

        <div class="step-card step-card--orange">
            <div class="step-shape step-shape--hex">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
            </div>
            <span class="step-num">03</span>
            <h3>Le Plan</h3>
            <p>Recevez votre programme PDF personnalisé incluant régimes alimentaires et activités sportives.</p>
        </div>

    </div>
</section>

<!-- ══════════════════════════════════════════
     Section 3 : Pourquoi nous choisir ?
══════════════════════════════════════════ -->
<section class="benefits-section">
    <h2 class="section-title">Pourquoi NutriPlan ?</h2>

    <div class="benefits-grid">

        <div class="benefit-card">
            <div class="benefit-icon benefit-icon--blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
            </div>
            <h4>Science</h4>
            <p>Notre algorithme calcule votre IMC selon les standards de l'OMS pour un diagnostic fiable et personnalisé.</p>
        </div>

        <div class="benefit-card">
            <div class="benefit-icon benefit-icon--gold">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
            </div>
            <h4>Option Gold</h4>
            <p>Passez à l'offre Gold et bénéficiez de <strong>-15% de remise</strong> sur l'ensemble de vos régimes et programmes.</p>
        </div>

        <div class="benefit-card">
            <div class="benefit-icon benefit-icon--green">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
            </div>
            <h4>Liberté PDF</h4>
            <p>Exportez votre programme en PDF et emportez votre régime partout, même sans connexion internet.</p>
        </div>

    </div>
</section>

<!-- ══════════════════════════════════════════
     Section 4 : Statistiques / Suivi
══════════════════════════════════════════ -->
<section class="stats-section">
    <div class="stats-inner">

        <div class="stats-text">
            <span class="stats-label">Tableau de bord</span>
            <h2>Un suivi rigoureux pour des résultats durables.</h2>
            <p>NutriPlan enregistre vos progrès semaine après semaine pour ajuster votre programme en temps réel.</p>
            <div class="stats-badges">
                <span class="badge-pill badge-pill--blue">Suivi IMC</span>
                <span class="badge-pill badge-pill--green">Régimes</span>
                <span class="badge-pill badge-pill--orange">Activités</span>
            </div>
        </div>

        <div class="stats-chart">
            <svg viewBox="0 0 280 170" xmlns="http://www.w3.org/2000/svg" class="chart-svg">
                <line x1="30" y1="10" x2="30" y2="130" stroke="#dee2e6" stroke-width="1" />
                <line x1="30" y1="130" x2="270" y2="130" stroke="#dee2e6" stroke-width="1" />
                <line x1="30" y1="90" x2="270" y2="90" stroke="#dee2e6" stroke-width="0.5" stroke-dasharray="4" />
                <line x1="30" y1="50" x2="270" y2="50" stroke="#dee2e6" stroke-width="0.5" stroke-dasharray="4" />
                <rect x="45" y="100" width="22" height="30" rx="4" fill="#ebf4ff" class="bar" />
                <rect x="83" y="80" width="22" height="50" rx="4" fill="#4a90e2" class="bar" />
                <rect x="121" y="60" width="22" height="70" rx="4" fill="#4a90e2" class="bar" />
                <rect x="159" y="50" width="22" height="80" rx="4" fill="#5cb85c" class="bar" />
                <rect x="197" y="40" width="22" height="90" rx="4" fill="#5cb85c" class="bar" />
                <rect x="235" y="30" width="22" height="100" rx="4" fill="#5cb85c" class="bar" />
                <text x="56" y="145" text-anchor="middle" font-size="8" fill="#6c757d" font-family="Nunito,sans-serif">S1</text>
                <text x="94" y="145" text-anchor="middle" font-size="8" fill="#6c757d" font-family="Nunito,sans-serif">S2</text>
                <text x="132" y="145" text-anchor="middle" font-size="8" fill="#6c757d" font-family="Nunito,sans-serif">S3</text>
                <text x="170" y="145" text-anchor="middle" font-size="8" fill="#6c757d" font-family="Nunito,sans-serif">S4</text>
                <text x="208" y="145" text-anchor="middle" font-size="8" fill="#6c757d" font-family="Nunito,sans-serif">S5</text>
                <text x="246" y="145" text-anchor="middle" font-size="8" fill="#6c757d" font-family="Nunito,sans-serif">S6</text>
                <polyline points="56,105 94,85 132,65 170,55 208,45 246,35"
                    fill="none" stroke="#f39c12" stroke-width="2" stroke-dasharray="5 3" stroke-linecap="round" />
                <circle cx="40" cy="160" r="4" fill="#4a90e2" />
                <text x="48" y="163" font-size="7.5" fill="#6c757d" font-family="Nunito,sans-serif">Poids</text>
                <circle cx="80" cy="160" r="4" fill="#5cb85c" />
                <text x="88" y="163" font-size="7.5" fill="#6c757d" font-family="Nunito,sans-serif">Objectif atteint</text>
                <line x1="130" y1="160" x2="148" y2="160" stroke="#f39c12" stroke-width="2" stroke-dasharray="3 2" />
                <text x="152" y="163" font-size="7.5" fill="#6c757d" font-family="Nunito,sans-serif">Tendance</text>
            </svg>
        </div>

    </div>
</section>