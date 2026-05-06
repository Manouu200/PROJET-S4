<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 1</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>
    <div class="container">
        <div class="progress-info">
            Étape 1 sur 2
        </div>
        <progress value="50" max="100"></progress>

        <form action="<?= base_url('inscription/etape2') ?>" method="POST">
            <fieldset>
                <legend><strong>Votre identité</strong></legend>

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="ex: Dupont" value="<?= htmlspecialchars(session()->get('nom') ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" placeholder="ex: Jean" value="<?= htmlspecialchars(session()->get('prenom') ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars(session()->get('date_naissance') ?? '') ?>" required>
                </div>

                <div class="radio-group">
                    <p><strong>Genre</strong></p>
                    <div class="radio-option">
                        <input type="radio" id="m" name="genre" value="M" <?= (session()->get('genre') === 'M') ? 'checked' : '' ?> required>
                        <label for="m">Homme</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="f" name="genre" value="F" <?= (session()->get('genre') === 'F') ? 'checked' : '' ?> required>
                        <label for="f">Femme</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="autre" name="genre" value="AUTRE" <?= (session()->get('genre') === 'AUTRE') ? 'checked' : '' ?> required>
                        <label for="autre">Autre</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars(session()->get('email') ?? '') ?>" required>
                </div>

                <div class="form-group password-toggle">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?= htmlspecialchars(session()->get('mot_de_passe') ?? '') ?>" required>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('mot_de_passe')">👁️</span>
                    <small>Cliquez sur l'icône 👁️ pour vérifier votre saisie.</small>
                </div>

                <button type="submit" class="btn-primary">
                    <strong>Continuer vers ma santé</strong>
                </button>

                <div style="text-align: center; margin-top: 20px;">
                    <p style="color: #666;">
                        Vous avez déjà un compte?
                        <a href="<?= base_url('/') ?>" style="color: #007bff; text-decoration: none; font-weight: bold;">
                            Connectez vous :)
                        </a>
                    </p>
                </div>
            </fieldset>
        </form>
    </div>

    <script src="<?= base_url('script.js') ?>"></script>
</body>

</html>