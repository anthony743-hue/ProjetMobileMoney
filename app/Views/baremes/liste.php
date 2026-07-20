<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barèmes de frais - KazziPay</title>
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
        .card-bareme {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
        }
        .card-bareme h4 {
            color: #2c3e50;
            font-weight: 700;
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
        .btn-login {
            background: #27ae60;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 6px;
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
        .btn-action {
            border-radius: 30px;
            padding: 5px 15px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        .form-select {
            padding: 10px 15px;
            border-radius: 12px;
            border-color: #e2e8f0;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .form-select:focus {
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }
        .form-label {
            font-weight: 700;
            color: #2c3e50;
            font-size: 14px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
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
    <div class="card-bareme">
        <h4><i class="bi bi-gear-wide-connected me-2"></i>Barèmes de frais</h4>
        <hr>

        <!-- Messages flash -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success flash-message d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger flash-message d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Sélecteur de type -->
        <form method="get" class="row g-3 align-items-center mb-4">
            <div class="col-auto">
                <label for="type" class="form-label"><i class="bi bi-funnel me-1"></i>Type de transaction</label>
            </div>
            <div class="col-auto">
                <select name="type" id="type" class="form-select" onchange="this.form.submit()">
                    <option value="depot"    <?= $typeTransaction == 'depot'    ? 'selected' : '' ?>>Dépôt</option>
                    <option value="retrait"  <?= $typeTransaction == 'retrait'  ? 'selected' : '' ?>>Retrait</option>
                    <option value="transfert"<?= $typeTransaction == 'transfert'? 'selected' : '' ?>>Transfert</option>
                </select>
            </div>
        </form>

        <!-- Tableau des barèmes -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Montant min</th>
                        <th>Montant max</th>
                        <th>Frais</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regles as $regle): ?>
                        <tr>
                            <td><?= number_format($regle['montant_min'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format($regle['montant_max'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format($regle['frais'], 2, ',', ' ') ?> Ar</td>
                            <td class="text-center">
                                <a href="/baremes/modifier/<?= $regle['id'] ?>?type=<?= $typeTransaction ?>" 
                                   class="btn btn-warning btn-action">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <a href="/baremes/supprimer/<?= $regle['id'] ?>" 
                                   class="btn btn-danger btn-action" 
                                   onclick="return confirm('Confirmer la suppression ?')">
                                    <i class="bi bi-trash3"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($regles)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                Aucun barème défini pour ce type.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Bouton Ajouter -->
        <div class="mt-3">
            <a href="/baremes/ajouter?operateur_id=<?= $operateurId ?>&type=<?= $typeTransaction ?>" 
               class="btn btn-login">
                <i class="bi bi-plus-circle"></i> Ajouter un barème
            </a>
        </div>
    </div>
</div>
</body>
</html>