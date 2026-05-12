<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $mode === 'edit' ? 'Modifier' : 'Ajouter' ?> une activite</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body class="theme-admin">
    <div class="page">
        <div class="container">
            <header class="site-header">
                <a class="brand" href="<?= site_url('/') ?>">
                    <span class="brand-mark">R</span>
                    Regime App
                </a>
                <nav class="nav">
                    <a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a>
                    <a href="<?= site_url('/admin/users') ?>">Utilisateurs</a>
                    <a href="<?= site_url('/admin/activites') ?>">Activites</a>
                    <a href="<?= site_url('/admin/regimes') ?>">Regimes</a>
                    <a href="<?= site_url('/admin/parametres') ?>">Parametres</a>
                    <a href="<?= site_url('/logout') ?>">Deconnexion</a>
                </nav>
            </header>

            <div class="card form-card fade-up">
                <h1 class="card-title"><?= $mode === 'edit' ? 'Modifier une activite' : 'Ajouter une activite' ?></h1>

                <?php if (! empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form class="form-grid" action="<?= $mode === 'edit' ? site_url('/admin/activites/update/' . $activite['id_activite']) : site_url('/admin/activites/store') ?>" method="post">
                    <div class="field">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= esc(old('nom') ?: ($activite['nom'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="calories_brulees">Calories brulees</label>
                        <input type="number" id="calories_brulees" name="calories_brulees" value="<?= esc(old('calories_brulees') ?: ($activite['calories_brulees'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" value="<?= esc(old('description') ?: ($activite['description'] ?? '')) ?>">
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                        <a class="btn btn-ghost" href="<?= site_url('/admin/activites') ?>">Retour</a>
                    </div>
                </form>
            </div>

            <div class="footer">Gestion des activites sportives.</div>
        </div>
    </div>
</body>
</html>
