<?php
/**
 * @var array $programmes
 */
?>

<h1>Vos programmes achetes</h1>

<?php if (empty($programmes)): ?>
    <p>Vous n'avez pas encore achete de programme.</p>
<?php else: ?>
    <div class="programmes-list" style="display:grid;gap:16px;">
        <?php foreach ($programmes as $programme): ?>
            <article class="programme-card" style="padding:16px;border:1px solid #e6e6e6;border-radius:12px;background:#fff;">
                <h3 style="margin:0 0 8px;">
                    <?= esc((string) ($programme['regime_nom'] ?? 'Programme')) ?>
                </h3>
                <p style="margin:0 0 6px;">
                    <strong>Date:</strong>
                    <?= esc((string) ($programme['date_decision'] ?? '--')) ?>
                </p>
                <p style="margin:0 0 6px;">
                    <strong>Activite:</strong>
                    <?= esc((string) ($programme['activite_nom'] ?? 'Aucune')) ?>
                </p>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>