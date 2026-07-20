<!DOCTYPE html>
<html>
<head>
    <title>Reversements aux opérateurs</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?= view('operateur/navbar') ?>
    <div class="container">
        <h2>Reversements à effectuer</h2>
        <hr>

        <?php if (empty($reversements)): ?>
            <div class="alert alert-info">Aucun transfert externe pour le moment.</div>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Opérateur</th>
                        <th class="text-end">Total à reverser</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reversements as $r): ?>
                        <tr>
                            <td><?= esc($r['nom']) ?></td>
                            <td class="text-end"><?= number_format($r['total_montant'], 0, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="mt-3">
            <a href="/operateur/accueil" class="btn btn-secondary">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>