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
<div class="page-wrapper">
    <!-- Mini entête de marque -->
    <div class="brand-mini">
        <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="KazziPay Logo">
        <span>KazziPay</span>
    </div>

    <!-- Carte principale -->
    <div class="card-gains">
        <h4><i class="bi bi-graph-up me-2"></i>Situation des gains</h4>
        <hr>

        <?php
            // Libellés et icônes pour chaque type
            $types = [
                'depot'     => ['label' => 'DÉPÔT',    'icon' => 'bi-box-arrow-in-down'],
                'retrait'   => ['label' => 'RETRAIT',   'icon' => 'bi-box-arrow-up'],
                'transfert' => ['label' => 'TRANSFERT', 'icon' => 'bi-arrow-left-right']
            ];

            foreach ($types as $key => $infos):
                $stats = $gainsParType[$key];
        ?>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi <?= $infos['icon'] ?>"></i>
                </div>
                <div class="stat-title"><?= $infos['label'] ?></div>
                <p class="stat-detail">
                    Nombre opérations : <strong><?= number_format($stats['nb_operations'], 0, ',', ' ') ?></strong>
                </p>
                <p class="stat-detail">
                    Montant traité : <strong><?= number_format($stats['montant_total'], 0, ',', ' ') ?> Ar</strong>
                </p>
                <p class="stat-detail">
                    Frais encaissés : <strong><?= number_format($stats['frais_total'], 0, ',', ' ') ?> Ar</strong>
                </p>
            </div>
        <?php endforeach; ?>

        <!-- Total des gains -->
        <div class="total-card">
            <div class="total-title">
                <i class="bi bi-cash-stack"></i> TOTAL DES GAINS
            </div>
            <div class="total-amount">
                <?= number_format($totalGains, 0, ',', ' ') ?> Ar
            </div>
        </div>

        <!-- Bouton retour -->
        <div class="mt-4">
            <a href="/baremes" class="btn-cancel">
                <i class="bi bi-arrow-left"></i> Retour aux barèmes
            </a>
        </div>
    </div>
</div>
</body>
</html>