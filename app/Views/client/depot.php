<!DOCTYPE html>
<html>
<head>
    <title>Effectuer un dépôt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container" style="max-width: 500px;">
        <h2>Effectuer un dépôt</h2>
        <hr>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <p><strong>Votre numéro :</strong> <?= esc($client['telephone']) ?></p>

        <form method="post" action="/client/depot/traitement">
            <div class="mb-3">
                <label for="montant" class="form-label">Montant à déposer (Ar)</label>
                <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Déposer</button>
        </form>

        <div class="mt-3">
            <a href="/client/espace" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>