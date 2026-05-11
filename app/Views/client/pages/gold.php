<?php

/**
 * @var bool $peut_acheter
 * @var float|int|string|null $prixGold
 */
?>

<div class="page-box gold-page">

  <div class="imc-card">
    <div class="imc-header">
      <div>
        <span class="imc-badge">Abonnement</span>
        <h2><?= esc($peut_acheter ? 'Passez à GOLD' : 'Statut GOLD actif') ?></h2>
      </div>

      <div class="imc-value" style="display:flex; align-items:center; justify-content:center; text-align:center; min-width:120px; min-height:120px; padding:0 12px; line-height:1.1; font-size:1.35rem; font-weight:800;">
        <span style="display:block; width:100%; white-space:nowrap;">
          <?= $peut_acheter ? esc(number_format((float) $prixGold, 2, '.', '')) . ' £' : 'GOLD' ?>
        </span>
      </div>
    </div>

    <div class="imc-status">
      <span class="status-dot"></span>
      <?= esc($peut_acheter ? 'Débloquez des programmes premium et des conseils exclusifs.' : 'Vous êtes déjà membre GOLD. Tous les avantages sont actifs.') ?>
    </div>
  </div>

  <div class="profile-section">

    <div class="section-heading">
      <span class="section-badge">Premium</span>
      <h1>Expérience GOLD</h1>
      <p>
        Une présentation alignée sur vos autres pages client pour garder
        une navigation plus fluide entre profil, solde et abonnement.
      </p>
    </div>

    <div class="benefits-grid profile-benefits">

      <div class="benefit-card">
        <div class="benefit-icon benefit-icon--gold">
          <svg width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="white" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2l2.5 6.5L21 11l-6 4.2L16.5 22 12 18.5 7.5 22 9 15.2 3 11l6.5-2.5z" />
          </svg>
        </div>

        <h4>Programmes premium</h4>

        <p>
          Accédez à des contenus plus avancés et à des recommandations
          conçues pour accompagner vos objectifs.
        </p>
      </div>

      <div class="benefit-card">
        <div class="benefit-icon benefit-icon--green">
          <svg width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="white" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1z" />
            <polyline points="12 5 12 12 16 14" />
          </svg>
        </div>

        <h4>Activation instantanée</h4>

        <p>
          Le paiement est traité immédiatement pour que votre compte
          GOLD soit mis à jour sans rupture d'expérience.
        </p>
      </div>

      <div class="benefit-card">
        <div class="benefit-icon benefit-icon--blue">
          <svg width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="white" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
          </svg>
        </div>

        <h4>Support premium</h4>

        <p>
          Gardez le même confort d’utilisation que sur le reste de
          votre espace client, avec un accès plus exclusif.
        </p>
      </div>

    </div>

    <?php if ($peut_acheter): ?>
      <div id="gold-error" class="alert alert-danger" style="display:none; margin-top:20px;"></div>

      <div class="profile-summary" style="margin-top:20px;">
        <div>
          <span>Prix GOLD</span>
          <strong><?= esc(number_format((float) $prixGold, 2, '.', '')) ?> £</strong>
        </div>
        <div>
          <span>Statut</span>
          <strong>Prêt à être activé</strong>
        </div>
      </div>

      <form class="profile-form" action="#" onsubmit="return false;" style="margin-top:20px;">
        <button id="paiement-gold-btn" class="btn-primary" data-prix="<?= esc((string) $prixGold) ?>" type="button">
          Devenir GOLD
        </button>
      </form>
    <?php else: ?>
      <div class="profile-summary" style="margin-top:20px;">
        <div>
          <span>Statut</span>
          <strong>Membre GOLD</strong>
        </div>
        <div>
          <span>Accès</span>
          <strong>Débloqué</strong>
        </div>
      </div>
    <?php endif; ?>

  </div>

</div>

<div id="gold-modal" style="display:none; position:fixed; inset:0; background:rgba(12, 18, 33, 0.62); backdrop-filter:blur(8px); justify-content:center; align-items:center; padding:20px; z-index:1050;">
  <div class="imc-card" style="max-width:420px; width:100%; margin:0; text-align:center; box-shadow:0 24px 60px rgba(15, 23, 42, 0.24);">

    <div class="imc-header" style="align-items:center;">
      <div style="width:100%;">
        <span class="imc-badge">Confirmation</span>
        <h2 style="margin-bottom:0;">Confirmation GOLD</h2>
      </div>
    </div>

    <p id="gold-modal-text" style="margin:18px 0 24px; font-size:1rem; line-height:1.6;"></p>

    <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
      <button id="gold-confirm-btn" type="button" class="btn-primary">Confirmer</button>
      <button id="gold-cancel-btn" type="button" class="btn-secondary">Annuler</button>
    </div>

  </div>
</div>