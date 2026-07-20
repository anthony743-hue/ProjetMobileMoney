<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($regle) ? 'Modifier' : 'Ajouter' ?> un barème - KazziPay</title>
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
            max-width: 600px;
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
        .card-bareme {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
            transition: transform 0.2s ease;
        }
        .card-bareme:hover {
            transform: translateY(-2px);
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
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }
        .btn-login {
            background: #27ae60;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
            color: white;
        }
        .btn-login:hover {
            background: #219a52;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(39, 174, 96, 0.4);
            color: white;
        }
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
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
        }
        .btn-cancel:hover {
            background: #dde4e6;
            color: #2c3e50;
        }
        .flash-message {
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        hr {
            margin: 20px 0;
            color: #e2e8f0;
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

        <!-- Carte du formulaire -->
        <div class="card-bareme">
            <h4 class="fw-bold mb-1" style="color: #2c3e50;">
                <i class="bi bi-sliders me-2"></i><?= isset($regle) ? 'Modifier' : 'Ajouter' ?> un barème
            </h4>
            <hr>

            <!-- Messages flash -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger flash-message d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success flash-message d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= isset($regle) ? '/baremes/modifier/'.$regle['id'] : '/baremes/ajouter' ?>">
                <input type="hidden" name="operateur_id" value="<?= $operateurId ?>">
                <input type="hidden" name="type_transaction" value="<?= esc($type) ?>">

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-arrow-left-right me-1"></i>Type de transaction</label>
                    <input type="text" class="form-control" value="<?= esc($type) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="montant_min" class="form-label">Montant minimum</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#f8fafc; border-right:none;"><i class="bi bi-cash"></i></span>
                        <input type="number" name="montant_min" id="montant_min" class="form-control" value="<?= old('montant_min', $regle['montant_min'] ?? '') ?>" step="0.01" placeholder="0.00" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="montant_max" class="form-label">Montant maximum</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#f8fafc; border-right:none;"><i class="bi bi-cash"></i></span>
                        <input type="number" name="montant_max" id="montant_max" class="form-control" value="<?= old('montant_max', $regle['montant_max'] ?? '') ?>" step="0.01" placeholder="0.00" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="frais" class="form-label">Frais</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#f8fafc; border-right:none;"><i class="bi bi-percent"></i></span>
                        <input type="number" name="frais" id="frais" class="form-control" value="<?= old('frais', $regle['frais'] ?? '') ?>" step="0.01" placeholder="0.00" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-<?= isset($regle) ? 'pencil-square' : 'plus-circle' ?> me-2"></i><?= isset($regle) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                    <a href="/baremes?type=<?= $type ?>" class="btn btn-cancel">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>