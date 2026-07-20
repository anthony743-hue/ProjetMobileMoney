<!DOCTYPE html>
<html>
<head>
    <title>Gestion des préfixes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?= view('operateur/navbar') ?>
    <div class="container">
        <h2>Gestion des préfixes opérateurs</h2>
        <hr>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <a href="/prefixes/ajouter" class="btn btn-primary mb-3">Ajouter un préfixe</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Préfixe</th>
                    <th>Opérateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prefixes as $p): ?>
                    <tr>
                        <td><?= esc($p['prefixe']) ?></td>
                        <td><?= esc($p['operateur_nom']) ?></td>
                        <td>
                            <a href="/prefixes/modifier/<?= $p['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="/prefixes/supprimer/<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($prefixes)): ?>
                    <tr><td colspan="3">Aucun préfixe défini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>