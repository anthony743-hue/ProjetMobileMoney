<!DOCTYPE html>
<html>
<head>
    <title>Barèmes de frais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Barèmes de frais</h2>
        <hr>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="get" class="row g-2 mb-3">
            <div class="col-auto">
                <label for="type" class="form-label">Type :</label>
            </div>
            <div class="col-auto">
                <select name="type" id="type" class="form-select" onchange="this.form.submit()">
                    <option value="depot"    <?= $typeTransaction == 'depot'    ? 'selected' : '' ?>>Dépôt</option>
                    <option value="retrait"  <?= $typeTransaction == 'retrait'  ? 'selected' : '' ?>>Retrait</option>
                    <option value="transfert"<?= $typeTransaction == 'transfert'? 'selected' : '' ?>>Transfert</option>
                </select>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Montant min</th>
                    <th>Montant max</th>
                    <th>Frais</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($regles as $regle): ?>
                    <tr>
                        <td><?= $regle['montant_min'] ?></td>
                        <td><?= $regle['montant_max'] ?></td>
                        <td><?= $regle['frais'] ?></td>
                        <td>
                            <a href="/baremes/modifier/<?= $regle['id'] ?>?type=<?= $typeTransaction ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="/baremes/supprimer/<?= $regle['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($regles)): ?>
                    <tr><td colspan="4">Aucun barème défini pour ce type.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <a href="/baremes/ajouter?operateur_id=<?= $operateurId ?>&type=<?= $typeTransaction ?>" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
</body>
</html>