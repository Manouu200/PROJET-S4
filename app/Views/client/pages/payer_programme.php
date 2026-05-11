<!-- app/Views/client/pages/payer_programme.php -->
<section class="payer-programme-section" style="max-width:600px;margin:40px auto;padding:32px;background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;">
    <h2>Validation du paiement</h2>
    <div id="programme-recap" style="margin:24px 0;"></div>
    <form id="form-payer-programme">
        <button type="submit" class="btn-primary" style="width:100%;font-size:1.2em;">Valider et payer</button>
    </form>
    <div id="paiement-message" style="margin-top:20px;"></div>
</section>
<script>
// Recuperer les infos du programme choisi depuis sessionStorage
const recapDiv = document.getElementById('programme-recap');
const programme = JSON.parse(sessionStorage.getItem('programmeChoisi') || '{}');
if (!programme || !programme.regime) {
    recapDiv.innerHTML = '<div style="color:red">Aucune information de programme trouvee.</div>';
} else {
    recapDiv.innerHTML = `
        <div style="padding:16px 0;">
            <strong>Programme :</strong> ${programme.regime}<br>
            <strong>Objectif final :</strong> ${programme.poids_final} kg<br>
            <strong>Duree :</strong> ${programme.duree} jours<br>
            <strong>Prix :</strong> <span style="color:#2d8c2d;font-weight:bold;">${Number(programme.prix).toFixed(2)} €</span><br>
            <strong>Type :</strong> ${programme.type}<br>
            ${programme.sport ? '<strong>Sport inclus</strong>' : ''}
        </div>
    `;
}

// Gestion du paiement
const form = document.getElementById('form-payer-programme');
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const msgDiv = document.getElementById('paiement-message');
    msgDiv.textContent = 'Traitement en cours...';
    try {
        const response = await fetch('/client/programmes/valider-paiement', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(programme)
        });
        const data = await response.json();
        if (response.ok && data.success) {
            msgDiv.innerHTML = '<span style="color:green">Paiement valide !</span>';
            sessionStorage.removeItem('programmeChoisi');
        } else {
            msgDiv.innerHTML = '<span style="color:red">' + (data.message || 'Erreur lors du paiement') + '</span>';
        }
    } catch (err) {
        msgDiv.innerHTML = '<span style="color:red">Erreur reseau ou serveur.</span>';
    }
});
</script>
