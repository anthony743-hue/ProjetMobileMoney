<!DOCTYPE html>
<html>
<head>
    <title>Envoi multiple</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container" style="max-width: 600px;">
    <h2>Envoi multiple</h2>
    <hr>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <p><strong>Votre numéro :</strong> <?= esc($client['telephone']) ?></p>
    <p><strong>Solde disponible :</strong> <?= number_format($client['solde'], 0, ',', ' ') ?> Ar</p>

    <form method="post" action="/client/transfert-multiple/traitement" id="formMultiple">
        <div class="mb-3">
            <label for="montant_total" class="form-label">Montant total à répartir (Ar)</label>
            <input type="number" name="montant_total" id="montant_total" class="form-control" step="0.01" required>
        </div>

        <div id="destinataires-container">
            <div class="row mb-2 destinataire-item">
                <div class="col-10">
                    <input type="text" name="numeros[]" class="form-control" placeholder="Ex: 0321234567" required>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger btn-sm supprimer-destinataire" style="display:none;">&times;</button>
                </div>
            </div>
        </div>

        <button type="button" id="ajouter-destinataire" class="btn btn-outline-primary btn-sm mb-3">+ Ajouter un destinataire</button>

        <button type="submit" class="btn btn-success w-100">Envoyer</button>
    </form>

    <div class="mt-3">
        <a href="/client/espace" class="btn btn-secondary">Retour</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('destinataires-container');
    const addButton = document.getElementById('ajouter-destinataire');

    // Fonction pour ajouter un champ destinataire
    function addDestinataire() {
        const div = document.createElement('div');
        div.className = 'row mb-2 destinataire-item';
        div.innerHTML = `
            <div class="col-10">
                <input type="text" name="numeros[]" class="form-control" placeholder="Ex: 0321234567" required>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger btn-sm supprimer-destinataire">&times;</button>
            </div>
        `;
        container.appendChild(div);
    }

    // Ajouter un champ au clic
    addButton.addEventListener('click', addDestinataire);

    // Gérer la suppression d'un champ
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('supprimer-destinataire')) {
            const item = e.target.closest('.destinataire-item');
            // Vérifier qu'il y a plus d'un champ pour éviter de tout supprimer
            if (container.querySelectorAll('.destinataire-item').length > 1) {
                item.remove();
            }
        }
    });

    // Afficher le bouton de suppression sur le premier champ s'il y en a plusieurs
    container.addEventListener('input', function() {
        const items = container.querySelectorAll('.destinataire-item');
        if (items.length > 1) {
            items.forEach(item => {
                const btn = item.querySelector('.supprimer-destinataire');
                if (btn) btn.style.display = '';
            });
        } else {
            const btn = container.querySelector('.supprimer-destinataire');
            if (btn) btn.style.display = 'none';
        }
    });
});
</script>
</body>
</html>