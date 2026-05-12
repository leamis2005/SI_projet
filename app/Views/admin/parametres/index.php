<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parametres</title>
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
                    <a href="<?= site_url('/admin/regimes') ?>">Regimes</a>
                    <a href="<?= site_url('/admin/activites') ?>">Activites</a>
                    <a href="<?= site_url('/admin/parametres') ?>">Parametres</a>
                    <a href="<?= site_url('/logout') ?>">Deconnexion</a>
                </nav>
            </header>

            <div class="card fade-up">
                <div class="actions">
                    <a class="btn btn-primary" href="<?= site_url('/admin/parametres/create') ?>">Ajouter un parametre</a>
                </div>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <div class="card stack-sm">
                    <h2 class="card-title">Liste des parametres</h2>
                    <div class="card-subtitle"><?= count($parametres) ?> element(s)</div>

                    <div class="table-responsive stack-sm">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cle</th>
                                    <th>Valeur</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($parametres as $parametre) : ?>
                                    <tr>
                                        <td><?= esc($parametre['cle']) ?></td>
                                        <td><?= esc($parametre['valeur']) ?></td>
                                        <td>
                                            <a class="btn btn-ghost" href="<?= site_url('/admin/parametres/edit/' . $parametre['id_param']) ?>">Modifier</a>
                                            <form class="inline-form" action="<?= site_url('/admin/parametres/delete/' . $parametre['id_param']) ?>" method="post">
                                                <button class="btn btn-secondary" type="submit">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="footer">Gestion des parametres.</div>
        </div>
    </div>
</body>
</html>
