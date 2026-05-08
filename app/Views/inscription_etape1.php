<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription – Étape 1 – NutriPlan</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>
    <div class="container compact-form">

        <div class="app-brand">
            <div class="brand-icon"><img src="<?= base_url('assets/NutriPlan.png') ?>" alt="NutriPlan" class="brand-logo"></div>
            <p>Créez votre profil nutritionnel</p>
        </div>

        <div class="progress-info">Étape 1 sur 2</div>
        <div class="progress-wrap">
            <div class="progress-fill" style="width: 50%;"></div>
        </div>

        <div class="steps-row">
            <div class="step-dot active">1</div>
            <div class="step-line"></div>
            <div class="step-dot">2</div>
        </div>

        <form action="<?= base_url('inscription/etape2') ?>" method="POST">
            <fieldset>
                <legend>
                    <span class="legend-icon"> </span>
                    <strong>Votre identité</strong>
                </legend>

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom"
                        placeholder="ex : Dupont"
                        value="<?= htmlspecialchars(session()->get('nom') ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom"
                        placeholder="ex : Jean"
                        value="<?= htmlspecialchars(session()->get('prenom') ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance"
                        value="<?= htmlspecialchars(session()->get('date_naissance') ?? '') ?>"
                        required>
                </div>

                <div class="radio-group">
                    <p>Genre</p>
                    <div class="radio-options">
                        <label class="radio-option">
                            <input type="radio" name="genre" value="M"
                                <?= (session()->get('genre') === 'M') ? 'checked' : '' ?> required>
                            <span>♂ Homme</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="genre" value="F"
                                <?= (session()->get('genre') === 'F') ? 'checked' : '' ?>>
                            <span>♀ Femme</span>
                        </label>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email"
                        placeholder="exemple@gmail.com"
                        value="<?= htmlspecialchars(session()->get('email') ?? '') ?>"
                        required>
                    <small id="email-error" style="color: #E74C3C; display: none;" data-ajax="true">
                        Cet email est déjà utilisé
                    </small>
                </div>

                <div class="form-group password-toggle">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe"
                        value="<?= htmlspecialchars(session()->get('mot_de_passe') ?? '') ?>"
                        required>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('mot_de_passe')"><img src="<?= base_url('assets/oeil_ouvert.png') ?>" alt="Afficher" class="eye-icon"></span>
                    <small>Cliquez sur l'icône pour vérifier votre saisie.</small>
                </div>

                <button type="submit" class="btn-primary">
                    Continuer → Mes informations de santé
                </button>
            </fieldset>
        </form>

        <div class="form-footer">
            <p>Vous avez déjà un compte ?
                <a href="<?= base_url('/') ?>">Connectez-vous :)</a>
            </p>
        </div>

    </div>
    <script>
        window.baseUrl = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('script.js') ?>"></script>
</body>

</html>