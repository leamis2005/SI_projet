<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $mode === 'edit' ? 'Modifier parametre' : 'Ajouter parametre' ?></title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <div class="page">
        <div class="container">
            <header class="site-header">
                <nav class="nav">
                    <a href="<?= site_url('/admin/users') ?>">Utilisateurs</a>
                    <a href="<?= site_url('/admin/regimes') ?>">Regimes</a>
                    <a href="<?= site_url('/admin/activites') ?>">Activites</a>
                    <a href="<?= site_url('/admin/parametres') ?>">Parametres</a>
                    <a href="<?= site_url('/logout') ?>">Deconnexion</a>
                </nav>
            </header>

            <div class="card form-card fade-up">
                <h1 class="card-title"><?= $mode === 'edit' ? 'Modifier le parametre' : 'Ajouter un parametre' ?></h1>

                <?php if (! empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php $action = $mode === 'edit' ? site_url('/admin/parametres/update/' . $parametre['id_param']) : site_url('/admin/parametres/store'); ?>

                <form class="form-grid" action="<?= $action ?>" method="post">
                    <div class="field">
                        <label for="cle">Cle</label>
                        <input type="text" id="cle" name="cle" value="<?= esc(old('cle') ?: ($parametre['cle'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="valeur">Valeur</label>
                        <input type="text" id="valeur" name="valeur" value="<?= esc(old('valeur') ?: ($parametre['valeur'] ?? '')) ?>" required>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit"><?= $mode === 'edit' ? 'Mettre a jour' : 'Ajouter' ?></button>
                        <a class="btn btn-ghost" href="<?= site_url('/admin/parametres') ?>">Annuler</a>
                    </div>
                </form>
            </div>

            <div class="footer">Gestion des parametres.</div>
        </div>
    </div>
</body>
</html>
