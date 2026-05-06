<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 2</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>
    <div class="container">
        <div class="progress-info">
            Étape 2 sur 2
        </div>
        <progress value="100" max="100"></progress>

        <form action="<?= base_url('inscription/finaliser') ?>" method="POST">
            <fieldset>
                <legend><strong>Vos informations de santé</strong></legend>

                <input type="hidden" name="nom" value="<?= htmlspecialchars(session()->get('nom') ?? '') ?>">
                <input type="hidden" name="prenom" value="<?= htmlspecialchars(session()->get('prenom') ?? '') ?>">
                <input type="hidden" name="date_naissance" value="<?= htmlspecialchars(session()->get('date_naissance') ?? '') ?>">
                <input type="hidden" name="genre" value="<?= htmlspecialchars(session()->get('genre') ?? '') ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars(session()->get('email') ?? '') ?>">
                <input type="hidden" name="mot_de_passe" value="<?= htmlspecialchars(session()->get('mot_de_passe') ?? '') ?>">

                <div class="form-group">
                    <label for="taille">Votre taille (en cm)</label>
                    <input type="text" id="taille" name="taille" placeholder="Ex: 175" required>
                    <small style="color: #666;">Entre 50 cm et 250 cm</small>
                </div>

                <div class="form-group">
                    <label for="poids">Votre poids (en kg)</label>
                    <input type="text" id="poids" name="poids" placeholder="Ex: 75" required>
                    <small style="color: #666;">Entre 20 kg et 300 kg</small>
                </div>

                <button type="submit" class="btn-success">
                    <strong>Finaliser l'inscription</strong>
                </button>

                <div class="back-link">
                    <a href="<?= base_url('inscription') ?>">Retour à l'étape précédente</a>
                </div>
            </fieldset>
        </form>
    </div>

    <script src="<?= base_url('script.js') ?>"></script>
</body>

</html>