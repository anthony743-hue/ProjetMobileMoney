<!DOCTYPE html>
<html>
<head>
    <title>Espace client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Bienvenue, <?= esc($client['prenom'] ?: $client['telephone']) ?></h2>
            <a href="/logout" class="btn btn-danger">Déconnexion</a>
        </div>
        <hr>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Votre solde</h5>
                <p class="display-6"><?= number_format($client['solde'], 0, ',', ' ') ?> Ar</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-2">
                <a href="/client/depot" class="btn btn-success w-100">Effectuer un dépôt</a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="/client/retrait" class="btn btn-warning w-100">Effectuer un retrait</a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="/client/transfert" class="btn btn-info w-100">Transfert d'argent</a>
            </div>
        </div>

        <div class="mt-3">
            <a href="/client/historique" class="btn btn-outline-secondary">Historique des transactions</a>
        </div>
    </div>
</body>
</html>