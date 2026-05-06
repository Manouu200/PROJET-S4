<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #333; font-size: 1.8em;">Connexion</h1>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; text-align: center;">
                <strong>⚠️ <?= htmlspecialchars(session()->getFlashdata('error')) ?></strong>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/authenticate') ?>" method="POST">
            <fieldset>
                <legend><strong>Connectez-vous</strong></legend>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" placeholder="exemple@gmail.com" required>
                    <small id="email-error" style="color: #dc3545; display: none;" data-ajax="false"></small>
                </div>

                <div class="form-group password-toggle">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('mot_de_passe')">👁️</span>
                </div>

                <button type="submit" class="btn-primary">
                    <strong>Se connecter</strong>
                </button>
            </fieldset>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <p style="color: #666;">
                Vous n'avez pas encore de compte?
                <a href="<?= base_url('inscription/nouvelle') ?>" style="color: #007bff; text-decoration: none; font-weight: bold;">
                    Inscrivez-vous :)
                </a>
            </p>
        </div>
    </div>

    <script src="<?= base_url('script.js') ?>"></script>
</body>

</html>