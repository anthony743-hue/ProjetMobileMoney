<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi multiple - KazziPay</title>
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
            max-width: 600px;
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
            border-color: #8e44ad;
            box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.15);
        }
        .input-group-text {
            background: #f8fafc;
            border-right: none;
            border-radius: 12px 0 0 12px;
        }
        .btn-envoyer {
            background: #8e44ad;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(142, 68, 173, 0.3);
            color: white;
        }
        .btn-envoyer:hover {
            background: #7d3c98;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(142, 68, 173, 0.4);
            color: white;
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
        .btn-add {
            border-radius: 30px;
            padding: 6px 18px;
            font-weight: 600;
            font-size: 14px;
            background: transparent;
            border: 2px dashed #8e44ad;
            color: #8e44ad;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            background: #f9f0ff;
            border-color: #8e44ad;
            color: #8e44ad;
        }
        .btn-supprimer {
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #e74c3c;
            color: #e74c3c;
            transition: all 0.2s ease;
        }
        .btn-supprimer:hover {
            background: #e74c3c;
            color: white;
        }
        .destinataire-item {
            align-items: center;
        }
        .destinataire-item .col-10 {
            padding-right: 8px;
        }
        .destinataire-item .col-2 {
            padding-left: 0;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Logo + nom -->
        <div class="brand">
            <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="KazziPay Logo">
            <h1>KazziPay</h1>
            <p>Votre argent, partout, tout le temps</p>
        </div>

        <!-- Carte d'opération -->
        <div class="card-operation">
            <h2><i class="bi bi-people-fill me-2"></i>Envoi multiple</h2>
            <hr>

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

            <div class="info-badge">
                <i class="bi bi-phone"></i>
                <span><strong>Votre numéro :</strong> <?= esc($client['telephone']) ?></span>
            </div>
            <div class="solde-badge">
                <i class="bi bi-wallet2"></i>
                <span><strong>Solde disponible :</strong> <?= number_format($client['solde'], 0, ',', ' ') ?> Ar</span>
            </div>

            <form method="post" action="/client/transfert-multiple/traitement" id="formMultiple">
                <!-- Montant total -->
                <div class="mb-3">
                    <label for="montant_total" class="form-label">Montant total à répartir (Ar)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                        <input type="number" name="montant_total" id="montant_total" class="form-control" step="0.01" placeholder="0.00" required>
                    </div>
                </div>

                <!-- Destinataires dynamiques -->
                <div class="mb-2">
                    <label class="form-label">Destinataires</label>
                    <div id="destinataires-container">
                        <div class="row mb-2 destinataire-item">
                            <div class="col-10">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="numeros[]" class="form-control" placeholder="Ex: 0321234567" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-supprimer supprimer-destinataire" style="display:none;" title="Supprimer">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="ajouter-destinataire" class="btn btn-add mb-4">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un destinataire
                </button>

                <button type="submit" class="btn btn-envoyer w-100">
                    <i class="bi bi-send-check me-2"></i>Envoyer
                </button>
            </form>

            <div class="mt-3">
                <a href="/client/espace" class="btn-retour">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('destinataires-container');
        const addButton = document.getElementById('ajouter-destinataire');

        // Fonction pour ajouter un champ destinataire
        function addDestinataire() {
            const div = document.createElement('div');
            div.className = 'row mb-2 destinataire-item';
            div.innerHTML = `
                <div class="col-10">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="numeros[]" class="form-control" placeholder="Ex: 0321234567" required>
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-supprimer supprimer-destinataire" title="Supprimer">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
            updateDeleteButtons();
        }

        // Mettre à jour la visibilité des boutons de suppression
        function updateDeleteButtons() {
            const items = container.querySelectorAll('.destinataire-item');
            const deleteButtons = container.querySelectorAll('.supprimer-destinataire');
            if (items.length > 1) {
                deleteButtons.forEach(btn => { btn.style.display = 'flex'; });
            } else {
                deleteButtons.forEach(btn => { btn.style.display = 'none'; });
            }
        }

        addButton.addEventListener('click', addDestinataire);

        // Gérer la suppression
        container.addEventListener('click', function(e) {
            if (e.target.closest('.supprimer-destinataire')) {
                const item = e.target.closest('.destinataire-item');
                if (container.querySelectorAll('.destinataire-item').length > 1) {
                    item.remove();
                    updateDeleteButtons();
                }
            }
        });

        // Initialisation
        updateDeleteButtons();
    });
    </script>
</body>
</html>