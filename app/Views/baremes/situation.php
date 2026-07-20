<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation des gains - KazziPay</title>
    <!-- Bootstrap local -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            font-family: 'Nunito', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 30px 20px;
        }
        .page-wrapper {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }
        .brand-mini {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .brand-mini img {
            width: 40px;
            height: 40px;
        }
        .brand-mini span {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.3px;
        }
        .card-gains {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
        }
        .card-gains h4 {
            color: #2c3e50;
            font-weight: 700;
        }
        hr {
            margin: 20px 0;
            color: #e2e8f0;
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }
        .stat-icon {
            font-size: 36px;
            color: #27ae60;
            margin-bottom: 8px;
        }
        .stat-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 16px;
        }
        .stat-detail {
            font-size: 15px;
            color: #555;
            margin-bottom: 6px;
        }
        .stat-detail strong {
            color: #2c3e50;
        }
        .total-card {
            background: #27ae60;
            border: none;
            border-radius: 16px;
            padding: 20px 24px;
            color: white;
            margin-top: 10px;
            box-shadow: 0 12px 24px rgba(39, 174, 96, 0.3);
        }
        .total-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .total-amount {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .btn-cancel {
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #ecf0f1;
            border: none;
            color: #2c3e50;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-cancel:hover {
            background: #dde4e6;
            color: #2c3e50;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <?= view('operateur/navbar') ?>
    <div class="container">
        <h2>Situation des gains</h2>
        <hr>

        <?php
        $types = ['depot' => 'DÉPÔT', 'retrait' => 'RETRAIT', 'transfert' => 'TRANSFERT'];
        $totalGainsInternes = 0;
        $totalGainsExternes = 0;
        ?>

        <?php foreach ($types as $key => $label): 
            $stats = $gainsParType[$key];
            $fraisFixes = $stats['frais_total'] - $stats['commission_totale'];  // ce qui reste à l'opérateur
            $commission = $stats['commission_totale'];                          // ce qui sera reversé
            $totalGainsInternes += $fraisFixes;
            $totalGainsExternes += $commission;
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= $label ?></h5>
                <div class="row">
                    <div class="col-md-4">
                        <p class="mb-1">Opérations : <strong><?= number_format($stats['nb_operations'], 0, ',', ' ') ?></strong></p>
                        <p class="mb-1">Montant traité : <strong><?= number_format($stats['montant_total'], 0, ',', ' ') ?> Ar</strong></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1">Gains internes (frais fixes) :</p>
                        <p class="fw-bold text-success"><?= number_format($fraisFixes, 0, ',', ' ') ?> Ar</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1">Gains externes (commissions) :</p>
                        <p class="fw-bold text-warning"><?= number_format($commission, 0, ',', ' ') ?> Ar</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <hr class="my-4">

        <!-- Récapitulatif global -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card text-bg-success">
                    <div class="card-body text-center">
                        <h5 class="card-title">TOTAL GAINS INTERNES</h5>
                        <p class="display-6"><?= number_format($totalGainsInternes, 0, ',', ' ') ?> Ar</p>
                        <small>Frais fixes conservés par l'opérateur</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-bg-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title">TOTAL COMMISSIONS COLLECTÉES</h5>
                        <p class="display-6"><?= number_format($totalGainsExternes, 0, ',', ' ') ?> Ar</p>
                        <small>Sommes à reverser aux autres opérateurs</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="/operateur/accueil" class="btn btn-secondary">Retour à l'accueil</a>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>