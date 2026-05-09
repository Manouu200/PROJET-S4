<?php

/**
 * @var float|null $imc
 * @var string|null $imc_categorie
 * @var string $user_nom
 * @var string $user_prenom
 * @var string $user_date_naissance
 * @var string $user_genre
 * @var string $user_email
 * @var string $user_password
 * @var array<string, mixed>|null $derniere_mesure
 * @var string $poidsDerniereMesure
 * @var string $tailleDerniereMesure
 */
?>
<div class="page-box">

    <!-- ── SECTION IMC ───────────────────────── -->
    <div class="imc-card">
        <div class="imc-header">
            <div>
                <span class="imc-badge">Santé</span>
                <h2>Votre IMC</h2>
            </div>

            <div class="imc-value">
                <?= esc($imc !== null ? number_format((float) $imc, 1, '.', '') : '--') ?>
            </div>
        </div>

        <div class="imc-status">
            <span class="status-dot"></span>
            <?= esc($imc_categorie ?? 'Aucune mesure disponible') ?>
        </div>

        <div class="imc-graph">
            <div class="imc-scale">
                <div class="imc-zone zone-blue"></div>
                <div class="imc-zone zone-green"></div>
                <div class="imc-zone zone-orange"></div>
                <div class="imc-zone zone-red"></div>

                <div class="imc-indicator" style="left: 48%;">
                    <div class="imc-indicator-line"></div>
                    <div class="imc-indicator-dot"></div>
                </div>
            </div>

            <div class="imc-labels">
                <span>16</span>
                <span>18.5</span>
                <span>25</span>
                <span>30</span>
                <span>40</span>
            </div>

            <div class="imc-legend">
                <div><span class="legend-color zone-blue"></span> Maigreur</div>
                <div><span class="legend-color zone-green"></span> Normal</div>
                <div><span class="legend-color zone-orange"></span> Surpoids</div>
                <div><span class="legend-color zone-red"></span> Obésité</div>
            </div>
        </div>
    </div>

    <!-- ── MODIFIER MES INFOS ───────────────── -->
    <div class="profile-section">

        <div class="section-heading">
            <span class="section-badge">Profil</span>
            <h1>Modifier mes informations</h1>
            <p>
                Gérez vos informations personnelles et gardez un suivi précis
                de votre évolution santé.
            </p>
        </div>

        <!-- Cards style benefits -->
        <div class="benefits-grid profile-benefits">

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--blue">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21V19A4 4 0 0 0 16 15H8A4 4 0 0 0 4 19V21" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>

                <h4>Profil personnel</h4>

                <p>
                    Modifiez votre nom, email et vos données physiques pour
                    personnaliser votre expérience NutriPlan.
                </p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--green">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </div>

                <h4>Suivi IMC</h4>

                <p>
                    Votre IMC est automatiquement analysé afin de suivre
                    l'évolution de votre santé au fil du temps.
                </p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--gold">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M12 4h9" />
                        <path d="M4 9h16" />
                        <path d="M4 15h16" />
                    </svg>
                </div>

                <h4>Données sécurisées</h4>

                <p>
                    Vos informations sont enregistrées de manière sécurisée
                    pour garantir confidentialité et fiabilité.
                </p>
            </div>

        </div>

        <?= $flashHtml ?? '' ?>

        <form class="profile-form profile-wizard" id="profile-wizard-form" method="post" action="<?= base_url('client/profil/update') ?>" data-profile-wizard="true" data-start-step="<?= esc((string) ($wizard_step ?? 1)) ?>">

            <input type="hidden" name="user_id" value="<?= esc((string) ($user_id ?? '')) ?>">

            <div class="wizard-page" data-wizard-page="1">
                <div class="wizard-page-head">
                    <span class="section-badge">Page 1 / 2</span>
                    <h3>Informations personnelles</h3>
                    <p>Modifiez votre identité et vos accès.</p>
                </div>

                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?= esc(old('nom', $user_nom ?? '')) ?>" placeholder="Votre nom" required>
                </div>

                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?= esc(old('prenom', $user_prenom ?? '')) ?>" placeholder="Votre prénom" required>
                </div>

                <div class="form-group">
                    <label>Date de naissance</label>
                    <input type="date" name="date_naissance" value="<?= esc(old('date_naissance', $user_date_naissance ?? '')) ?>" required>
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <select name="genre" required>
                        <option value="">Choisir</option>
                        <option value="M" <?= old('genre', $user_genre ?? '') === 'M' ? 'selected' : '' ?>>Homme</option>
                        <option value="F" <?= old('genre', $user_genre ?? '') === 'F' ? 'selected' : '' ?>>Femme</option>
                        <option value="AUTRE" <?= old('genre', $user_genre ?? '') === 'AUTRE' ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Adresse e-mail</label>
                    <input type="email" name="email" value="<?= esc(old('email', $user_email ?? '')) ?>" placeholder="Votre email" required>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" value="<?= esc(old('mot_de_passe', $user_password ?? '')) ?>" placeholder="Laisser vide pour conserver le mot de passe actuel">
                </div>
            </div>

            <div class="wizard-page" data-wizard-page="2" hidden>
                <div class="wizard-page-head">
                    <span class="section-badge">Page 2 / 2</span>
                    <h3>Données santé</h3>
                    <p>Enregistre ton poids et ta taille pour actualiser l'IMC.</p>
                </div>

                <div class="form-group">
                    <label>Poids</label>
                    <div class="input-unit-wrap">
                        <input type="number" name="poids" step="0.01" min="20" max="300" value="<?= esc(old('poids', $poidsDerniereMesure ?? '')) ?>" placeholder="Votre poids" required>
                        <span class="input-unit">kg</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Taille</label>
                    <div class="input-unit-wrap">
                        <input type="number" name="taille" step="0.01" min="50" max="250" value="<?= esc(old('taille', $tailleDerniereMesure ?? '')) ?>" placeholder="Votre taille en cm" required>
                        <span class="input-unit">cm</span>
                    </div>
                </div>

                <div class="profile-summary">
                    <div>
                        <span>IMC actuel</span>
                        <strong><?= esc($imc !== null ? number_format((float) $imc, 1, '.', '') : '--') ?></strong>
                    </div>
                    <div>
                        <span>Statut</span>
                        <strong><?= esc($imc_categorie ?? 'Aucune mesure disponible') ?></strong>
                    </div>
                </div>
            </div>

            <div class="wizard-pagination">
                <button type="button" class="wizard-nav wizard-prev" data-wizard-prev>Précédent</button>

                <div class="wizard-dots" aria-label="Pagination du formulaire">
                    <span class="wizard-dot is-active" data-wizard-dot="1">1</span>
                    <span class="wizard-dot" data-wizard-dot="2">2</span>
                </div>

                <button type="button" class="wizard-nav wizard-next" data-wizard-next>Suivant</button>
                <button type="submit" class="wizard-nav wizard-save" data-wizard-save>Enregistrer</button>
            </div>

        </form>

    </div>

</div>