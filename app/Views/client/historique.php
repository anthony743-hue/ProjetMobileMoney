<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions - KazziPay</title>
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
            max-width: 900px;
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
        .card-historique {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
        }
        .card-historique h4 {
            color: #2c3e50;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        hr {
            margin: 20px 0;
            color: #e2e8f0;
        }
        .client-badge {
            background: #f0f9ff;
            border: 1px solid #d0e7ff;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            color: #0c5460;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .client-badge i {
            font-size: 20px;
            color: #27ae60;
        }
        .flash-message {
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .table thead th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 700;
            color: #2c3e50;
            padding: 12px 16px;
            font-size: 14px;
            letter-spacing: 0.2px;
        }
        .table tbody td {
            padding: 12px 16px;
            font-size: 15px;
            color: #34495e;
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        .table tbody tr:hover td {
            background-color: #fafcfc;
        }
        .sens-plus {
            color: #27ae60;
            font-weight: 700;
        }
        .sens-moins {
            color: #e74c3c;
            font-weight: 700;
        }
        .btn-retour {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ecf0f1;
            border: none;
            color: #2c3e50;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-retour:hover {
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
    <div class="card-historique">
        <h4><i class="bi bi-clock-history me-2"></i>Historique des transactions</h4>
        <hr>

        <!-- Infos client -->
        <div class="client-badge">
            <i class="bi bi-person-badge"></i>
            <span>
                <strong><?= esc($client['telephone']) ?></strong>
                <?php $nomComplet = trim(($client['prenom'] ?? '') . ' ' . ($client['nom'] ?? ''));
                if (!empty($nomComplet)): ?>
                    (<?= esc($nomComplet) ?>)
                <?php endif; ?>
            </span>
        </div>

        <?php if (empty($transactions)): ?>
            <div class="alert alert-info flash-message d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                Aucune transaction trouvée.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th class="text-end">Montant (Ar)</th>
                            <th class="text-end">Frais (Ar)</th>
                            <th>Détail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $t): 
                            $typeLabel = '';
                            $detail = '';
                            $sens = '';
                            
                            // Déterminer le sens et le détail selon que le client est émetteur ou récepteur
                            if ($t['emetteur_id'] == $client['id']) {
                                if ($t['type'] == 'retrait') {
                                    $typeLabel = 'Retrait';
                                    $detail = 'Retrait espèces';
                                    $sens = '-';
                                } elseif ($t['type'] == 'transfert') {
                                    $typeLabel = 'Transfert émis';
                                    $detail = 'Vers ' . esc($t['recepteur_telephone']);
                                    $sens = '-';
                                }
                            } elseif ($t['recepteur_id'] == $client['id']) {
                                if ($t['type'] == 'depot') {
                                    $typeLabel = 'Dépôt';
                                    $detail = 'Dépôt espèces';
                                    $sens = '+';
                                } elseif ($t['type'] == 'transfert') {
                                    $typeLabel = 'Transfert reçu';
                                    $detail = 'De ' . esc($t['emetteur_telephone']);
                                    $sens = '+';
                                }
                            }
                            
                            $montantAffiche = $t['montant'];
                            $fraisAffiche = $t['frais'];
                        ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($t['date_transaction'])) ?></td>
                            <td><?= $typeLabel ?></td>
                            <td class="text-end <?= $sens == '+' ? 'sens-plus' : 'sens-moins' ?>">
                                <?= $sens . ' ' . number_format($montantAffiche, 0, ',', ' ') ?>
                            </td>
                            <td class="text-end">
                                <?= $fraisAffiche > 0 ? number_format($fraisAffiche, 0, ',', ' ') : '-' ?>
                            </td>
                            <td><?= $detail ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="/client/espace" class="btn-retour">
                <i class="bi bi-arrow-left"></i> Retour à l'espace client
            </a>
        </div>
    </div>
</div>
</body>
</html>