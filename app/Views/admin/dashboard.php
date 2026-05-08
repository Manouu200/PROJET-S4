<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin – NutriPlan</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <div class="container">
        <h1>Tableau de bord Admin</h1>
        <p>Bienvenue </p>
        <nav>
            <ul>
                <li><a href="<?= base_url('admin/gestion-regimes') ?>">Gestion des régimes</a></li>
                <li><a href="<?= base_url('logout') ?>">Se déconnecter</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
