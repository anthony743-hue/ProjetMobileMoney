<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion client - KazziPay</title>
    <!-- Bootstrap local -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts (pour une typo plus ronde) -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons (pour les icônes) -->
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
            max-width: 420px;
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
        .card-login {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 32px 28px;
            transition: transform 0.2s ease;
        }
        .card-login:hover {
            transform: translateY(-2px);
        }
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #34495e;
            margin-bottom: 6px;
        }
        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            font-weight: 600;
            color: #2c3e50;
        }
        .form-control {
            border-left: none;
            padding: 12px 16px;
            font-size: 16px;
            border-color: #e2e8f0;
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
            padding: 12px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }
        .btn-login:hover {
            background: #219a52;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(39, 174, 96, 0.4);
        }
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
        }
        .flash-message {
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .info-text {
            color: #7f8c8d;
            font-size: 13px;
        }
        .info-text i {
            margin-right: 4px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Logo + nom de l'app -->
        <div class="brand">
            <!-- Remplacez le src par votre propre logo -->
            <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="KazziPay Logo">
            <h1>KazziPay</h1>
            <p>Votre argent, partout, tout le temps</p>
        </div>

        <!-- Carte de connexion -->
        <div class="card-login">
            <h5 class="mb-3 fw-bold text-center" style="color: #2c3e50;">Connexion client</h5>
            <hr class="mb-4">

            <!-- Affichage des messages flash -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger flash-message d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success flash-message d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <form method="post">
                <div class="mb-3">
                    <label for="telephone" class="form-label">Numéro de téléphone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone"></i> +261</span>
                        <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="32 12 345 67" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-login w-100 mt-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>
            </form>

            <div class="mt-3 text-center info-text">
                <i class="bi bi-info-circle"></i> Pas de compte ? Il sera créé automatiquement.
            </div>
        </div>
    </div>
</body>
</html>