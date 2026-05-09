<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription – Étape 2 – NutriPlan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>
    <div class="container compact-form">

        <div class="app-brand">
            <div class="brand-icon"><img src="<?= base_url('assets/NutriPlan.png') ?>" alt="NutriPlan" class="brand-logo"></div>
            <p>Créez votre profil </p>
        </div>

        <div class="progress-info">Étape 2 sur 2</div>
        <div class="progress-wrap">
            <div class="progress-fill" style="width: 100%;"></div>
        </div>

        <div class="steps-row">
            <div class="step-dot done">✓</div>
            <div class="step-line done"></div>
            <div class="step-dot active">2</div>
        </div>

        <div class="health-hint">
            <span class="hint-icon">💡</span>
            <span>Ces informations nous permettent de calculer votre <strong>IMC</strong> et de vous proposer un régime alimentaire parfaitement adapté à vos objectifs.</span>
        </div>

        <form action="<?= base_url('inscription/finaliser') ?>" method="POST">
            <fieldset>
                <legend>
                    <span class="legend-icon"> </span>
                    <strong>Vos informations de santé</strong>
                </legend>

                <!-- Hidden fields from step 1 -->
                <input type="hidden" name="nom" value="<?= htmlspecialchars(session()->get('nom') ?? '') ?>">
                <input type="hidden" name="prenom" value="<?= htmlspecialchars(session()->get('prenom') ?? '') ?>">
                <input type="hidden" name="date_naissance" value="<?= htmlspecialchars(session()->get('date_naissance') ?? '') ?>">
                <input type="hidden" name="genre" value="<?= htmlspecialchars(session()->get('genre') ?? '') ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars(session()->get('email') ?? '') ?>">
                <input type="hidden" name="mot_de_passe" value="<?= htmlspecialchars(session()->get('mot_de_passe') ?? '') ?>">

                <div class="form-group">
                    <label for="taille">Votre taille</label>
                    <div class="input-unit-wrap">
                        <input type="text" id="taille" name="taille" placeholder="175" required>
                        <span class="input-unit">cm</span>
                    </div>
                    <small>Entre 50 cm et 250 cm</small>
                </div>

                <div class="form-group">
                    <label for="poids">Votre poids</label>
                    <div class="input-unit-wrap">
                        <input type="text" id="poids" name="poids" placeholder="75" required>
                        <span class="input-unit">kg</span>
                    </div>
                    <small>Entre 20 kg et 300 kg</small>
                </div>

                <button type="submit" class="btn-success">
                    Finaliser mon inscription
                </button>

            </fieldset>
        </form>

        <div class="back-link">
            <a href="<?= base_url('inscription/etape1') ?>">← Retour à l'étape précédente</a>
        </div>

    </div>
    <script>
        window.baseUrl = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>