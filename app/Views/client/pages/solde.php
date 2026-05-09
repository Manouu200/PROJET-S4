<h1>Votre Solde</h1>

<h2>$<span id="solde-amount"><?php echo(esc($solde)); ?></span></h2>
<?php if (session()->getFlashdata('error')): ?>
    <pre>
        <?php $error = session()->getFlashdata('error'); print_r($error); ?>
    </pre>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <pre>
        <?php $success = session()->getFlashdata('success'); print_r($success); ?>
    </pre>
<?php endif; ?>

<div id="recharge-messages"></div>

<form id="recharge-form" action="<?= site_url('client/solde/recharger') ?>" method="post">
    <?= csrf_field() ?>
    <label for="code_recharge">Code de recharge</label>
    <input
        type="text"
        id="code_recharge"
        name="code_recharge"
        required
        minlength="4"
        maxlength="32"
        autocomplete="off"
        placeholder="Entrez votre code"
    >
    <button type="submit">Recharger</button>
</form>