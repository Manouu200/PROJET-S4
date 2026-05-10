<div class="page-box">

    <!-- ── SECTION SOLDE ───────────────────────── -->
    <div class="imc-card">
        <div class="imc-header">
            <div>
                <span class="imc-badge">Portefeuille</span>
                <h2>Votre Solde</h2>
            </div>

            <div class="imc-value" id="solde-amount">
                $<?= esc((string)$solde) ?>
            </div>
        </div>

        <div class="imc-status">
            <span class="status-dot"></span>
            Recharger votre portefeuille pour accéder aux programmes
        </div>
    </div>

    <!-- ── RECHARGER SOLDE ───────────────────── -->
    <div class="profile-section">

        <div class="section-heading">
            <span class="section-badge">Paiement</span>
            <h1>Recharger mon solde</h1>
            <p>
                Utilisez un code de recharge pour créditer votre portefeuille
                et accéder à l'ensemble de nos programmes personnalisés.
            </p>
        </div>

        <!-- Cards style benefits -->
        <div class="benefits-grid profile-benefits">

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--blue">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="1" />
                        <path d="M12 1v6m0 6v6" />
                        <path d="M4.22 4.22l4.24 4.24m3.08 3.08l4.24 4.24" />
                        <path d="M1 12h6m6 0h6" />
                        <path d="M4.22 19.78l4.24-4.24m3.08-3.08l4.24-4.24" />
                    </svg>
                </div>

                <h4>Code valide</h4>

                <p>
                    Entrez un code de recharge valide reçu par email ou
                    fourni par notre équipe pour créditer votre compte.
                </p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--green">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1z" />
                        <polyline points="12 5 12 12 16 14" />
                    </svg>
                </div>

                <h4>Instantané</h4>

                <p>
                    Votre recharge est traitée instantanément. Accédez
                    immédiatement à vos programmes dès validation.
                </p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon benefit-icon--gold">
                    <svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>

                <h4>Support 24/7</h4>

                <p>
                    Une question sur votre recharge ? Contactez notre équipe
                    disponible à tout moment pour vous aider.
                </p>
            </div>

        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php $error = session()->getFlashdata('error');
                print_r($error); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php $success = session()->getFlashdata('success');
                print_r($success); ?>
            </div>
        <?php endif; ?>

        <div id="recharge-messages" class="mt-2"></div>

        <form id="recharge-form" action="<?= site_url('client/solde/recharger') ?>" method="post" class="profile-form">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="code_recharge">Code de recharge</label>
                <input
                    type="text"
                    id="code_recharge"
                    name="code_recharge"
                    required
                    minlength="4"
                    maxlength="32"
                    autocomplete="off"
                    placeholder="Entrez votre code">
            </div>

            <button type="submit" class="btn-primary">Recharger mon solde</button>
        </form>

    </div>

</div>