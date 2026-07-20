<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Effectuer un retrait - KazziPay</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .login-wrapper {
            width: 100%;
            max-width: 460px;
        }
        .brand {
            text-align: center;
            margin-bottom: 24px;
        }
        .brand img {
            width: 70px;
            height: 70px;
            margin-bottom: 8px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        .brand h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }
        .brand p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }
        .card-operation {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
            transition: transform 0.2s ease;
        }
        .card-operation:hover {
            transform: translateY(-2px);
        }
        .card-operation h2 {
            font-weight: 700;
            color: #2c3e50;
            font-size: 24px;
        }
        hr {
            margin: 20px 0;
            color: #e2e8f0;
        }
        .flash-message {
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .info-badge {
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
            margin-bottom: 12px;
        }
        .solde-badge {
            background: #eafff2;
            border: 1px solid #b7ebc5;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            color: #155724;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #34495e;
            margin-bottom: 6px;
        }
        .form-control {
            padding: 12px 16px;
            font-size: 16px;
            border-color: #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #f39c12;
            box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.15);
        }
        .btn-retrait {
            background: #f39c12;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
            color: white;
        }
        .btn-retrait:hover {
            background: #e67e22;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(243, 156, 18, 0.4);
            color: white;
        }
        .btn-retrait:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(243, 156, 18, 0.3);
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
        }
    </style>
</head>

<body class="p-4">
    <div class="container" style="max-width: 500px;">
        <h2>Effectuer un retrait</h2>
        <hr>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <p><strong>Votre numéro :</strong> <?= esc($client['telephone']) ?></p>
        <p><strong>Solde disponible :</strong> <?= number_format($client['solde'], 0, ',', ' ') ?> Ar</p>

        <form method="post" action="/client/retrait/traitement">
            <div class="mb-3">
                <label for="montant" class="form-label">Montant à retirer (Ar)</label>
                <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
            </div>

            <!-- Case à cocher pour frais inclus -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="frais_inclus" id="frais_inclus" class="form-check-input" value="1">
                <label class="form-check-label" for="frais_inclus">
                    Inclure les frais dans le montant saisi
                </label>
                <div class="form-text">
                    Si coché, le montant saisi correspond au <strong>total</strong> que vous souhaitez débiter (montant retiré + frais).
                </div>
            </div>

            <button type="submit" class="btn btn-warning w-100">Retirer</button>
        </form>

        <div class="mt-3">
            <a href="/client/espace" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>