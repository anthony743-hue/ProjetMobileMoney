<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Opérateur - KazziPay</title>
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
            padding: 0;
        }
        .page-wrapper {
            padding: 30px 20px;
        }
        .container-custom {
            max-width: 1000px;
            margin: 0 auto;
        }
        .welcome-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        }
        .welcome-card h2 {
            font-weight: 700;
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 0;
        }
        .welcome-card hr {
            margin: 16px 0 4px;
            color: #e2e8f0;
        }
        .action-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            padding: 24px 20px;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.1);
        }
        .action-card .card-icon {
            font-size: 36px;
            color: #27ae60;
            margin-bottom: 10px;
        }
        .action-card h5 {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .action-card p {
            color: #5a6a7a;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .btn-action-outline {
            border-radius: 30px;
            padding: 6px 18px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s;
        }
        .btn-action-outline:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        .btn-outline-primary-custom {
            color: #27ae60;
            border-color: #27ae60;
            background: transparent;
        }
        .btn-outline-primary-custom:hover {
            background: #27ae60;
            color: white;
        }
        .btn-outline-success-custom {
            color: #27ae60;
            border-color: #27ae60;
            background: transparent;
        }
        .btn-outline-success-custom:hover {
            background: #27ae60;
            color: white;
        }
        .btn-outline-info-custom {
            color: #3498db;
            border-color: #3498db;
            background: transparent;
        }
        .btn-outline-info-custom:hover {
            background: #3498db;
            color: white;
        }
        .row-cards {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation (incluse depuis la vue operateur/navbar) -->
    <?= view('operateur/navbar') ?>

    <div class="page-wrapper">
        <div class="container-custom">
            <!-- Carte de bienvenue -->
            <div class="welcome-card">
                <h2><i class="bi bi-person-workspace me-2"></i>Espace Opérateur : <?= esc($operateur['nom']) ?></h2>
                <hr>
            </div>

            <!-- Cartes d'actions -->
            <div class="row row-cards g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="action-card text-center">
                        <div class="card-icon"><i class="bi bi-sliders"></i></div>
                        <h5>Barèmes de frais</h5>
                        <p>Gérez les règles de frais par type de transaction.</p>
                        <a href="/baremes" class="btn btn-outline-primary-custom btn-action-outline me-1">
                            <i class="bi bi-list-ul me-1"></i>Voir la liste
                        </a>
                        <a href="/baremes/ajouter?type=depot" class="btn btn-outline-success-custom btn-action-outline ms-1">
                            <i class="bi bi-plus-circle me-1"></i>Ajouter
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="action-card text-center">
                        <div class="card-icon"><i class="bi bi-graph-up"></i></div>
                        <h5>Situation des gains</h5>
                        <p>Consultez les statistiques de transactions et les gains par type.</p>
                        <a href="/baremes/situation" class="btn btn-outline-info-custom btn-action-outline">
                            <i class="bi bi-bar-chart-fill me-1"></i>Voir les gains
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="action-card text-center">
                        <div class="card-icon"><i class="bi bi-people-fill"></i></div>
                        <h5>Situation des clients</h5>
                        <p>Liste des clients, soldes et nombre total de comptes.</p>
                        <a href="/clients/situation" class="btn btn-outline-info-custom btn-action-outline">
                            <i class="bi bi-person-lines-fill me-1"></i>Voir les clients
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pour activer le dropdown de la navbar (si besoin) -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>