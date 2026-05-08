<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion – NutriPlan</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>
    <div class="container">

        <div class="app-brand">
            <div class="brand-icon"><img src="<?= base_url('assets/NutriPlan.png') ?>" alt="NutriPlan" class="brand-logo"></div>
            <p>Votre guide nutritionnel personnalisé</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <span>⚠️</span>
                <?= htmlspecialchars(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/authenticate') ?>" method="POST">
            <fieldset>
                <legend>
                    <span class="legend-icon"> </span>
                    <strong>Connectez-vous</strong>
                </legend>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email"
                        placeholder="exemple@gmail.com" required>
                    <small id="email-error" style="color: #E74C3C; display: none;" data-ajax="false"></small>
                </div>

                <div class="form-group password-toggle">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('mot_de_passe')"><img src="<?= base_url('assets/oeil_ouvert.png') ?>" alt="Afficher" class="eye-icon"></span>
                </div>

                <button type="submit" class="btn-primary">
                    <strong>Se connecter</strong>
                </button>
            </fieldset>
        </form>

        <div class="form-footer">
            <p>Vous n'avez pas encore de compte ?
                <a href="<?= base_url('inscription/nouvelle') ?>">Inscrivez-vous :)</a>
            </p>
        </div>

    </div>
    <script>
        window.baseUrl = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('script.js') ?>"></script>
</body>

</html>