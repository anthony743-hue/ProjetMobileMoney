<!DOCTYPE html>
<html>
<head>
    <title><?= isset($regle) ? 'Modifier' : 'Ajouter' ?> un barème</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2><?= isset($regle) ? 'Modifier' : 'Ajouter' ?> un barème</h2>
        <hr>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= isset($regle) ? '/baremes/modifier/'.$regle['id'] : '/baremes/ajouter' ?>">
            <input type="hidden" name="operateur_id" value="<?= $operateurId ?>">
            <input type="hidden" name="type_transaction" value="<?= esc($type) ?>">

            <div class="mb-3">
                <label class="form-label">Type : <?= esc($type) ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label">Montant minimum</label>
                <input type="number" name="montant_min" class="form-control" value="<?= old('montant_min', $regle['montant_min'] ?? '') ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Montant maximum</label>
                <input type="number" name="montant_max" class="form-control" value="<?= old('montant_max', $regle['montant_max'] ?? '') ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Frais</label>
                <input type="number" name="frais" class="form-control" value="<?= old('frais', $regle['frais'] ?? '') ?>" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success"><?= isset($regle) ? 'Modifier' : 'Ajouter' ?></button>
            <a href="/baremes?type=<?= $type ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>