<!DOCTYPE html>
<html>
<head>
    <title>Connexion client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container" style="max-width: 400px;">
        <h2>Connexion client</h2>
        <hr>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="telephone" class="form-label">Numéro de téléphone</label>
                <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Ex: 0321234567" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>

        <div class="mt-3 text-center">
            <small>Pas de compte ? Il sera créé automatiquement.</small>
        </div>
    </div>
</body>
</html>