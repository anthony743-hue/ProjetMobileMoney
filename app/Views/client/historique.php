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
<!DOCTYPE html>
<html>
<head>
    <title>Historique des transactions - KazziPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .page-wrapper { max-width: 1000px; margin: 30px auto; padding: 0 15px; }
        .brand-mini { display: flex; align-items: center; gap: 10px; margin-bottom: 25px; }
        .brand-mini img { height: 40px; }
        .brand-mini span { font-size: 1.6rem; font-weight: bold; color: #2c3e50; }
        .card-historique { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
        .client-badge { background: #eef2ff; border-radius: 10px; padding: 10px 18px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
        .sens-plus { color: #198754; font-weight: 500; }
        .sens-moins { color: #dc3545; font-weight: 500; }
        .btn-retour { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 8px 18px; color: #2c3e50; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; }
        .btn-retour:hover { background: #e9ecef; }
        table th { background: #f8f9fa; font-weight: 600; }
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

        <!-- Formulaire de filtres -->
        <form method="get" class="row g-2 mb-4 p-3 bg-light rounded-3">
            <div class="col-md-3">
                <label for="type" class="form-label fw-semibold small">Type de transaction</label>
                <select name="type" id="type" class="form-select form-select-sm">
                    <option value="">Tous</option>
                    <option value="depot"     <?= ($filtres['type'] ?? '') == 'depot'     ? 'selected' : '' ?>>Dépôt</option>
                    <option value="retrait"   <?= ($filtres['type'] ?? '') == 'retrait'   ? 'selected' : '' ?>>Retrait</option>
                    <option value="transfert" <?= ($filtres['type'] ?? '') == 'transfert' ? 'selected' : '' ?>>Transfert</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_debut" class="form-label fw-semibold small">Du</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control form-control-sm" value="<?= esc($filtres['date_debut'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label fw-semibold small">Au</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control form-control-sm" value="<?= esc($filtres['date_fin'] ?? '') ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-funnel"></i> Filtrer
                </button>
            </div>
        </form>

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

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>