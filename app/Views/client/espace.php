<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace client - KazziPay</title>
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
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }
        .page-wrapper {
            width: 100%;
            max-width: 650px;
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
        .card-espace {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
        }
        .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .welcome-text {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }
        .btn-logout {
            background: #e74c3c;
            border: none;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }
        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(231, 76, 60, 0.4);
            color: white;
        }
        .solde-card {
            background: #27ae60;
            border-radius: 16px;
            padding: 20px 24px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 12px 24px rgba(39, 174, 96, 0.3);
        }
        .solde-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .solde-amount {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .btn-action {
            flex: 1;
            min-width: 140px;
            border: none;
            border-radius: 12px;
            padding: 14px 10px;
            font-weight: 700;
            font-size: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            color: white;
        }
        .btn-action i {
            font-size: 28px;
        }
        .btn-depot {
            background: #27ae60;
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }
        .btn-depot:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(39, 174, 96, 0.4);
            color: white;
        }
        .btn-retrait {
            background: #f39c12;
            box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
        }
        .btn-retrait:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(243, 156, 18, 0.4);
            color: white;
        }
        .btn-transfert {
            background: #3498db;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }
        .btn-transfert:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(52, 152, 219, 0.4);
            color: white;
        }
        .btn-historique {
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            background: #ecf0f1;
            border: none;
            color: #2c3e50;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-historique:hover {
            background: #dde4e6;
            color: #2c3e50;
            transform: translateY(-1px);
        }
        hr {
            margin: 20px 0;
            color: #e2e8f0;
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <!-- Mini en-tête de marque -->
    <div class="brand-mini">
        <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="KazziPay Logo">
        <span>KazziPay</span>
    </div>

    <!-- Carte espace client -->
    <div class="card-espace">
        <!-- En-tête : bienvenue + déconnexion -->
        <div class="welcome-header">
            <div class="welcome-text">
                <i class="bi bi-person-circle me-2"></i><?= esc($client['prenom'] ?: $client['telephone']) ?>
            </div>
            <a href="/logout" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </a>
        </div>
        <hr>

        <!-- Solde -->
        <div class="solde-card">
            <div class="solde-title">
                <i class="bi bi-wallet2"></i> Votre solde
            </div>
            <div class="solde-amount">
                <?= number_format($client['solde'], 0, ',', ' ') ?> Ar
            </div>
        </div>

        <!-- Boutons d'actions -->
        <div class="action-buttons">
            <a href="/client/depot" class="btn-action btn-depot">
                <i class="bi bi-box-arrow-in-down"></i>
                Dépôt
            </a>
            <a href="/client/retrait" class="btn-action btn-retrait">
                <i class="bi bi-box-arrow-up"></i>
                Retrait
            </a>
            <a href="/client/transfert" class="btn-action btn-transfert">
                <i class="bi bi-arrow-left-right"></i>
                Transfert
            </a>
        </div>

        <!-- Historique -->
        <a href="/client/historique" class="btn-historique">
            <i class="bi bi-clock-history"></i> Historique des transactions
        </a>
    </div>
</div>
</body>
</html>