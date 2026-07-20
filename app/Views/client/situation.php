<!DOCTYPE html>
<html>
<head>
    <title>Situation des comptes clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Situation des comptes clients</h2>
        <hr>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Téléphone</th>
                    <th>Nom</th>
                    <th>Solde</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= esc($client['telephone']) ?></td>
                        <td><?= esc(trim(($client['prenom'] ?? '') . ' ' . ($client['nom'] ?? ''))) ?></td>
                        <td class="text-end"><?= number_format($client['solde'], 0, ',', ' ') ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($clients)): ?>
                    <tr><td colspan="3">Aucun client trouvé.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Total clients :</strong> <?= number_format($totaux['total_clients'], 0, ',', ' ') ?></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Total des soldes :</strong> <?= number_format($totaux['total_soldes'], 0, ',', ' ') ?> Ar</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="/baremes" class="btn btn-secondary">Retour aux barèmes</a>
        </div>
    </div>
</body>
</html>