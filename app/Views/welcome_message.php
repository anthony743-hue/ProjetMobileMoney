<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KazziPay - Accueil</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .accueil-wrapper {
            text-align: center;
            max-width: 450px;
            width: 100%;
        }
        .brand {
            margin-bottom: 30px;
        }
        .brand img {
            width: 80px;
            margin-bottom: 10px;
        }
        .brand h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .brand p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
        .card-choix {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .btn-choix {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 18px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            color: white;
            transition: all 0.3s;
        }
        .btn-client {
            background: #27ae60;
            box-shadow: 0 8px 20px rgba(39,174,96,0.3);
        }
        .btn-client:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(39,174,96,0.4);
        }
        .btn-operateur {
            background: #8e44ad;
            box-shadow: 0 8px 20px rgba(142,68,173,0.3);
        }
        .btn-operateur:hover {
            background: #7d3c98;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(142,68,173,0.4);
        }
        .separateur {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #bdc3c7;
        }
        .separateur::before,
        .separateur::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ecf0f1;
        }
        .separateur span {
            margin: 0 15px;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="accueil-wrapper">
    <div class="brand">
        <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="KazziPay Logo">
        <h1>KazziPay</h1>
        <p>Votre argent, partout, tout le temps</p>
    </div>

    <div class="card-choix">
        <h5 class="mb-3 fw-bold text-secondary">Choisissez votre espace</h5>
        <a href="/login" class="btn-choix btn-client">
            <i class="bi bi-people-fill me-2"></i>Espace Client
        </a>
        <div class="separateur">
            <span>OU</span>
        </div>
        <a href="/operateur/login" class="btn-choix btn-operateur">
            <i class="bi bi-shield-lock-fill me-2"></i>Espace Opérateur
        </a>
    </div>
</div>
</body>
</html>