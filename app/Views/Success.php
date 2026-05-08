<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription réussie</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>
    <div class="container">
        <div style="text-align: center; padding: 40px 0;">
            <h1 style="color: #28a745; font-size: 2em; margin-bottom: 20px;">✓ Inscription réussie !</h1>
            <p style="font-size: 1.1em; color: #666; margin-bottom: 30px;">
                Bienvenue, <strong><?= htmlspecialchars(session()->get('email')) ?></strong>
            </p>
            <p style="color: #666; margin-bottom: 30px;">
                Vos informations ont été enregistrées avec succès. Vous pouvez maintenant vous connecter à votre compte.
            </p>
            <a href="<?= base_url('inscription/reset') ?>" style="display: inline-block; background-color: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 4px; font-weight: bold;">
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>

</html>