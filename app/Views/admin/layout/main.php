<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?> – NutriAdmin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="brand">
                <img src="<?= base_url('assets/NutriPlan.png') ?>" alt="Logo NutriPlan" class="brand-logo">
                <span style="text-transform: none;">Admin</span>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="<?= base_url('admin/dashboard') ?>" class="<?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
                            <i class="fa-solid fa-house-chimney"></i> Dashboard
                        </a>
                    </li>

                    <li class="has-submenu">
                        <a href="javascript:void(0)" class="submenu-toggle <?= (strpos(uri_string(), 'admin/regimes') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-leaf"></i>
                            <span>Régimes</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?= base_url('admin/regimes') ?>">
                                    <i class="fa-solid fa-list"></i> Liste des régimes
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/regimes/create') ?>">
                                    <i class="fa-solid fa-plus"></i> Ajouter un régime
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url('logout') ?>">
                            <i class="fa-solid fa-power-off"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>

</html>