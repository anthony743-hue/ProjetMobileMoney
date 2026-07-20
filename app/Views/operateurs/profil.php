<!DOCTYPE html>
<html>
<head>
    <title>Paramètres de l'opérateur</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?= view('operateur/navbar') ?>
    <div class="container">
        <h2>Paramètres de l'opérateur</h2>
        <hr>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="commission_inter_operateur" class="form-label">
                    Commission inter‑opérateur (%)
                </label>
                <input type="number" step="0.01" name="commission_inter_operateur" id="commission_inter_operateur"
                       class="form-control" value="<?= old('commission_inter_operateur', $operateurData['commission_inter_operateur'] ?? 0) ?>" required>
                <div class="form-text">Pourcentage ajouté aux frais fixes lors d’un transfert vers un numéro d’un autre opérateur.</div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="/operateur/accueil" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>