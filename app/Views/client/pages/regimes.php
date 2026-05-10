<?= $this->extend('client/home') ?>

<?= $this->section('content') ?>
<div class="container py-5"> <div class="card shadow-lg border-0 mb-5 overflow-hidden rounded-lg">
        <div class="card-header bg-white py-4 px-4 border-bottom-0">
            <h3 class="mb-0 font-weight-bold text-dark text-center">
                <i class="fa-solid fa-wand-magic-sparkles text-primary mr-2"></i> 
                Trouvez votre programme idéal
            </h3>
        </div>
        
        <div class="card-body p-0"> <form action="<?= base_url('client/regimes/filtrer') ?>" method="GET" id="filterForm">
                <div class="row no-gutters">
                    
                    <div class="col-lg-4 bg-light p-5 border-right">
                        <p class="text-uppercase small font-weight-bold text-muted mb-4 tracking-wider">Votre profil actuel</p>
                        <div class="row no-gutters align-items-center text-center">
                            <div class="col-4">
                                <span class="d-block h3 font-weight-bold mb-0"><?= $utilisateur['poids'] ?></span>
                                <small class="text-muted text-uppercase">kg</small>
                            </div>
                            <div class="col-4 border-left border-right">
                                <span class="d-block h3 font-weight-bold mb-0"><?= $utilisateur['taille'] ?></span>
                                <small class="text-muted text-uppercase">cm</small>
                            </div>
                            <div class="col-4">
                                <span class="d-block h3 font-weight-bold mb-0 text-primary">
                                    <?= number_format($utilisateur['imc'], 1) ?>
                                </span>
                                <small class="text-muted text-uppercase">IMC</small>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-white rounded-pill text-center shadow-sm border">
                            <small class="text-info font-weight-bold">
                                <i class="fa-solid fa-circle-info mr-1"></i> Catégorie : <?= App\Libraries\Utils::categorieIMC($utilisateur['imc']) ?>
                            </small>
                        </div>
                    </div>

                    <div class="col-lg-4 p-5 border-right bg-white">
                        <p class="text-uppercase small font-weight-bold text-muted mb-4 tracking-wider">Choisissez votre Objectif</p>
                        <div class="goal-options">
                            <?php foreach($objectifs as $obj): ?>
                                <label class="goal-item mb-3">
                                    <input type="radio" name="id_objectif" 
                                           value="<?= $obj['id'] ?>" 
                                           data-nom="<?= strtolower($obj['nom_objectif']) ?>"
                                           required onchange="updateUI(this)"> 
                                    <div class="goal-content p-3 border rounded">
                                        <span class="font-weight-bold text-dark"><?= esc($obj['nom_objectif']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                            
                            <label class="goal-item mb-3">
                                <input type="radio" name="id_objectif" value="imc_ideal" data-nom="imc_ideal" onchange="updateUI(this)">
                                <div class="goal-content p-3 border rounded bg-light-blue">
                                    <span class="font-weight-bold">✨ Atteindre l'IMC Idéal</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-4 p-5 bg-white">
                        <div id="poidsIntervalle" class="transition-fade">
                            <p class="text-uppercase small font-weight-bold text-muted mb-4 tracking-wider" id="labelPoids">Poids Cible (kg)</p>
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <input type="number" class="form-control form-control-lg text-center shadow-sm" name="poids_min" placeholder="Min" min="30">
                                </div>
                                <div class="px-3 font-weight-bold text-muted">à</div>
                                <div class="flex-grow-1">
                                    <input type="number" class="form-control form-control-lg text-center shadow-sm" name="poids_max" placeholder="Max" min="30">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block btn-xl font-weight-bold shadow-lg py-3 rounded-pill">
                            <i class="fa-solid fa-rocket mr-2"></i> Voir les programmes
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="section-title mb-4">
        <h3 class="font-weight-bold text-dark border-left border-primary pl-3 border-width-4">Régimes recommandés</h3>
    </div>
    
    <div class="row" id="results-container">
        </div>
</div>

<style>
    /* ── ESPACEMENT ET TYPO ───────────────── */
    .tracking-wider { letter-spacing: 0.05em; }
    .btn-xl { font-size: 1.1rem; transition: all 0.3s ease; }
    .btn-xl:hover { transform: scale(1.02); box-shadow: 0 10px 20px rgba(108, 92, 231, 0.2) !important; }
    .border-width-4 { border-left-width: 5px !important; }

    /* ── BOUTONS RADIOS PERSONNALISÉS ─────── */
    .goal-options input[type="radio"] { display: none; }
    .goal-item { cursor: pointer; width: 100%; display: block; }
    .goal-content { 
        transition: all 0.2s ease-in-out; 
        background: #fdfdfd; 
        border: 2px solid #edf2f7 !important;
    }
    .goal-item:hover .goal-content { background: #f8fafc; border-color: #cbd5e0 !important; }
    
    /* État coché */
    .goal-options input[type="radio"]:checked + .goal-content {
        background: #6c5ce7;
        border-color: #6c5ce7 !important;
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);
    }
    .goal-options input[type="radio"]:checked + .goal-content span {
        color: white !important;
    }

    /* ── ANIMATIONS ───────────────────────── */
    .transition-fade { transition: opacity 0.4s ease; }
    .bg-light-blue { background: #f0f7ff; border-color: #d1e9ff !important; }
    
    .form-control-lg {
        border-radius: 12px;
        border: 2px solid #edf2f7;
    }
    .form-control-lg:focus {
        border-color: #6c5ce7;
        box-shadow: none;
    }
</style>

<script>
    function updateUI(inputElement) {
        const nom = inputElement.getAttribute('data-nom');
        const intervalleDiv = document.getElementById('poidsIntervalle');
        const label = document.getElementById('labelPoids');

        if (nom === 'imc_ideal') {
            intervalleDiv.style.opacity = '0.1';
            intervalleDiv.style.pointerEvents = 'none';
            label.innerText = "Automatique (IMC)";
        } else {
            intervalleDiv.style.opacity = '1';
            intervalleDiv.style.pointerEvents = 'auto';
            label.innerText = nom.includes('augmenter') ? "Objectif de prise (kg)" : "Objectif de perte (kg)";
        }
    }
</script>
<?= $this->endSection() ?>