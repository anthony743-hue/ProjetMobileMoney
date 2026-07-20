<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation des comptes clients - KazziPay</title>
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
        .card-situation {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
        }
        .card-situation h4 {
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
        .totaux-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 24px;
        }
        .badge-total {
            background: #f0f9ff;
            border: 1px solid #d0e7ff;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 16px;
            color: #0c5460;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .badge-total i {
            font-size: 20px;
            color: #27ae60;
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
    <div class="card-situation">
        <h4><i class="bi bi-people-fill me-2"></i>Situation des comptes clients</h4>
        <hr>

        <!-- Tableau des clients -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Téléphone</th>
                        <th>Nom</th>
                        <th class="text-end">Solde</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= esc($client['telephone']) ?></td>
                            <td><?= esc(trim(($client['prenom'] ?? '') . ' ' . ($client['nom'] ?? ''))) ?></td>
                            <td class="text-end fw-bold"><?= number_format($client['solde'], 0, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($clients)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                Aucun client trouvé.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Totaux -->
        <div class="totaux-row">
            <div class="badge-total">
                <i class="bi bi-people"></i>
                <span><strong>Total clients :</strong> <?= number_format($totaux['total_clients'], 0, ',', ' ') ?></span>
            </div>
            <div class="badge-total">
                <i class="bi bi-cash-stack"></i>
                <span><strong>Total des soldes :</strong> <?= number_format($totaux['total_soldes'], 0, ',', ' ') ?> Ar</span>
            </div>
        </div>

        <!-- Bouton retour -->
        <div class="mt-4">
            <a href="/baremes" class="btn-retour">
                <i class="bi bi-arrow-left"></i> Retour aux barèmes
            </a>
        </div>
    </div>
</div>
</body>
</html>