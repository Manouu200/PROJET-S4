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
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>

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
                    <a class="nav-link menu-link" href="pages/accueil.php">
                        Accueil
                    </a>
                </li>

                <!-- REGIMES -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="pages/regimes.php">
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
                        <a class="dropdown-item menu-link" href="pages/edit.php">
                            Informations personnelles
                        </a>
                        <a class="dropdown-item menu-link" href="pages/another.php">
                            Programme
                        </a>
                        <a class="dropdown-item menu-link" href="pages/solde.php">
                            Solde
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item menu-link gold-link" href="pages/gold.php">
                            ⭐ Passez à GOLD
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

    <!-- ── JS ───────────────────────────────────── -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Charger une page dans le main
        function chargerPage(page) {
            fetch(page)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("main-content").innerHTML = data;
                    // Ré-attacher les liens après chargement dynamique
                    attachMenuLinks();
                });
        }

        // Attacher les clics sur tous les .menu-link présents dans la page
        function attachMenuLinks() {
            document.querySelectorAll(".menu-link").forEach(link => {
                link.addEventListener("click", function(e) {
                    // Vérifier que ce n'est pas un dropdown toggle
                    if (!this.classList.contains("dropdown-toggle")) {
                        e.preventDefault();
                        chargerPage(this.getAttribute("href"));
                    }
                });
            });
        }

        // Page par défaut
        chargerPage("pages/accueil.php");

        // Liens du menu fixe
        attachMenuLinks();

        // Gérer le dropdown manuellement
        document.querySelector('.dropdown-toggle')?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const menu = this.nextElementSibling;
            menu.classList.toggle('show');
        });

        // Fermer le dropdown quand on clique ailleurs
        document.addEventListener('click', function(e) {
            const menu = document.querySelector('.dropdown-menu');
            const toggle = document.querySelector('.dropdown-toggle');
            if (!e.target.closest('.dropdown') && menu) {
                menu.classList.remove('show');
            }
        });
    </script>

</body>

</html>