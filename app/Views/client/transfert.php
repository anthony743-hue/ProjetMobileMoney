<!DOCTYPE html>
<html>
<head>
    <title>Transfert d'argent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container" style="max-width: 500px;">
        <h2>Transfert d'argent</h2>
        <hr>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <p><strong>Votre numéro :</strong> <?= esc($client['telephone']) ?></p>
        <p><strong>Solde disponible :</strong> <?= number_format($client['solde'], 0, ',', ' ') ?> Ar</p>

        <form method="post" action="/client/transfert/traitement">
            <div class="mb-3">
                <label for="telephone" class="form-label">Numéro du bénéficiaire</label>
                <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Ex: 0321234567" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant à transférer (Ar)</label>
                <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-info w-100">Transférer</button>
        </form>

        <div class="mt-3">
            <a href="/client/espace" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>