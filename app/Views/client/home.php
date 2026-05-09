<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Style NutriPlan -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body data-base-url="<?= base_url() ?>">

    <!-- ── NAVBAR ───────────────────────────────── -->
    <nav class="navbar navbar-expand-lg navbar-light">

        <a class="navbar-brand nutriplan-brand" href="#">
            <img src="<?= base_url('assets/NutriPlan.png') ?>" alt="NutriPlan" class="brand-logo-img">
        </a>

        <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">

                <!-- HOME -->
                <li class="nav-item active">
                    <a class="nav-link menu-link" href="<?= base_url('client/page/accueil') ?>">
                        Accueil
                    </a>
                </li>

                <!-- REGIMES -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= base_url('client/page/regimes') ?>">
                        Régimes
                    </a>
                </li>

                <!-- DROPDOWN PROFIL -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownMenuLink"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <img src="<?= base_url('assets/profil.png') ?>" alt="Profil" class="nav-icon"> Profil
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item menu-link" href="<?= base_url('client/profil') ?>">
                            Informations personnelles
                        </a>
                        <a class="dropdown-item menu-link" href="<?= base_url('client/page/programme') ?>">
                            Programme
                        </a>
                        <a class="dropdown-item menu-link" href="<?= base_url('client/page/solde') ?>">
                            Solde
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item menu-link gold-link" href="<?= base_url('client/page/gold') ?>">
                            ⭐ Passez à GOLD
                        </a>
                        <a class="dropdown-item menu-link " href="<?= base_url('logout') ?>">
                            <img src="<?= base_url('assets/se-deconnecter.png') ?>" alt="Profil" class="nav-icon"> Se déconnecter
                        </a>
                    </div>
                </li>

            </ul>
        </div>

    </nav>

    <!-- ── MAIN ─────────────────────────────────── -->
    <div class="container-fluid main-wrapper">
        <div class="main-inner">
            <div id="main-content"></div>
        </div>
    </div>
    <!-- ══════════════════════════════════════════
     Section 5 : Footer
══════════════════════════════════════════ -->

    <footer class="fixed-bottom bg-light text-center p-3">
        © 2026 NutriPlan — Tous droits réservés · contact@nutriplan.fr
    </footer>
    <!-- ── JS ───────────────────────────────────── -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>

</body>

</html>