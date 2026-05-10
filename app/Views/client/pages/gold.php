<h1>⭐ Passez à GOLD</h1>

<?php if (!$peut_acheter): ?>
    <p>Vous etes deja un membre GOLD !</p>

<?php else: ?>
    <p>Débloquez des programmes premium et des conseils exclusifs.</p>
    <div id="gold-error" style="display:none; color:red; margin:10px 0;"></div>
    <button id="paiement-gold-btn" data-prix="<?= $prixGold ?>">Devenir GOLD</button>
<?php endif; ?>

<div id="gold-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
  <div style="background:white; padding:20px; border-radius:10px; width:300px; text-align:center;">

    <h3>Confirmation GOLD</h3>
    <p id="gold-modal-text"></p>

    <button id="gold-confirm-btn">Confirmer</button>
    <button id="gold-cancel-btn">Annuler</button>

  </div>
</div>