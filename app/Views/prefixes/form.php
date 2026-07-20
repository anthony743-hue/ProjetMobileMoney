<!DOCTYPE html>
<html>
<head>
    <title><?= isset($prefixe) ? 'Modifier' : 'Ajouter' ?> un préfixe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?= view('operateur/navbar') ?>
    <div class="container">
        <h2><?= isset($prefixe) ? 'Modifier' : 'Ajouter' ?> un préfixe</h2>
        <hr>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= isset($prefixe) ? '/prefixes/modifier/'.$prefixe['id'] : '/prefixes/ajouter' ?>">
            <div class="mb-3">
                <label for="operateur_id" class="form-label">Opérateur</label>
                <select name="operateur_id" id="operateur_id" class="form-select" required>
                    <?php foreach ($operateurs as $op): ?>
                        <option value="<?= $op['id'] ?>"
                            <?= old('operateur_id', $prefixe['operateur_id'] ?? '') == $op['id'] ? 'selected' : '' ?>>
                            <?= esc($op['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="prefixe" class="form-label">Préfixe</label>
                <input type="text" name="prefixe" id="prefixe" class="form-control" value="<?= old('prefixe', $prefixe['prefixe'] ?? '') ?>" placeholder="Ex : 031" required>
            </div>
            <button type="submit" class="btn btn-success"><?= isset($prefixe) ? 'Modifier' : 'Ajouter' ?></button>
            <a href="/prefixes" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>