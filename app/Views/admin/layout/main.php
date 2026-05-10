<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> – NutriAdmin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="brand">
                <img src="<?= base_url('assets/NutriPlan.png') ?>" alt="Logo NutriPlan" class="brand-logo">
                <span style="text-transform: none; font-weight: 700; color: #2d3436;">Admin</span>
            </div>
            
            <nav>
                <ul>
                    <li>
                        <a href="<?= base_url('admin/dashboard') ?>" class="<?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
                            <i class="fa-solid fa-house-chimney"></i> Dashboard
                        </a>
                    </li>

                    <li class="has-submenu <?= (strpos(uri_string(), 'admin/regimes') !== false) ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="submenu-toggle <?= (strpos(uri_string(), 'admin/regimes') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-leaf"></i>
                            <span>Régimes</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?= base_url('admin/regimes') ?>" class="<?= (uri_string() == 'admin/regimes') ? 'sub-active' : '' ?>">
                                    <i class="fa-solid fa-list"></i> Liste des régimes
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/regimes/create') ?>" class="<?= (uri_string() == 'admin/regimes/create') ? 'sub-active' : '' ?>">
                                    <i class="fa-solid fa-plus"></i> Ajouter un régime
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-submenu <?= (strpos(uri_string(), 'admin/sports') !== false) ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="submenu-toggle <?= (strpos(uri_string(), 'admin/sports') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-dumbbell"></i>
                            <span>Activités Sportives</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?= base_url('admin/sports') ?>" class="<?= (uri_string() == 'admin/sports') ? 'sub-active' : '' ?>">
                                    <i class="fa-solid fa-person-running"></i> Liste activités
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/sports/create') ?>" class="<?= (uri_string() == 'admin/sports/create') ? 'sub-active' : '' ?>">
                                    <i class="fa-solid fa-plus"></i> Ajouter activité
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-submenu <?= (strpos(uri_string(), 'admin/codes') !== false) ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="submenu-toggle <?= (strpos(uri_string(), 'admin/codes') !== false) ? 'active' : '' ?>">
                            <i class="fa-solid fa-ticket"></i>
                            <span>Codes Recharges</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?= base_url('admin/codes') ?>" class="<?= (uri_string() == 'admin/codes') ? 'sub-active' : '' ?>">
                                    <i class="fa-solid fa-list-check"></i> État des codes
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/codes/create') ?>" class="<?= (uri_string() == 'admin/codes/create') ? 'sub-active' : '' ?>">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i> Générer codes
                                </a>
                            </li>
                        </ul>
                    </li>

                    <hr class="nav-separator">

                    <li>
                        <a href="<?= base_url('logout') ?>" class="logout-link">
                            <i class="fa-solid fa-power-off"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success animate-fade-in">
                    <i class="fa-solid fa-circle-check"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error animate-fade-in">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script>
        document.querySelectorAll('.submenu-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const parent = button.parentElement;
                parent.classList.toggle('open');
            });
        });
    </script>
</body>

</html>