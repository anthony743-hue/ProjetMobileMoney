<!DOCTYPE html>
<html>
<head>
    <title>Situation des gains</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Situation des gains</h2>
        <hr>

        <?php
            // Libellés pour l'affichage
            $types = [
                'depot'     => 'DÉPÔT',
                'retrait'   => 'RETRAIT',
                'transfert' => 'TRANSFERT'
            ];

            foreach ($types as $key => $label):
                $stats = $gainsParType[$key];
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= $label ?></h5>
                <p class="mb-1">
                    Nombre opérations : <strong><?= number_format($stats['nb_operations'], 0, ',', ' ') ?></strong>
                </p>
                <p class="mb-1">
                    Montant traité    : <strong><?= number_format($stats['montant_total'], 0, ',', ' ') ?> Ar</strong>
                </p>
                <p class="mb-1">
                    Frais encaissés   : <strong><?= number_format($stats['frais_total'], 0, ',', ' ') ?> Ar</strong>
                </p>
            </div>
        </div>
        <hr class="my-2">
        <?php endforeach; ?>

        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">TOTAL DES GAINS</h5>
                <p class="card-text display-6">
                    <?= number_format($totalGains, 0, ',', ' ') ?> Ar
                </p>
            </div>
        </div>

        <div class="mt-3">
            <a href="/baremes" class="btn btn-secondary">Retour aux barèmes</a>
        </div>
    </div>
</body>
</html>