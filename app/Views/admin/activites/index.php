<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activites sportives</title>
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

            <div class="card fade-up">
                <div class="actions">
                    <a class="btn btn-primary" href="<?= site_url('/admin/activites/create') ?>">Ajouter une activite</a>
                </div>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <div class="card stack-sm">
                    <h2 class="card-title">Liste des activites</h2>
                    <div class="card-subtitle"><?= count($activites) ?> element(s)</div>

                    <div class="table-responsive stack-sm">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Calories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activites as $activite) : ?>
                                    <tr>
                                        <td><?= esc($activite['nom']) ?></td>
                                        <td><?= esc($activite['calories_brulees']) ?></td>
                                        <td>
                                            <a class="btn btn-ghost" href="<?= site_url('/admin/activites/edit/' . $activite['id_activite']) ?>">Modifier</a>
                                            <form class="inline-form" action="<?= site_url('/admin/activites/delete/' . $activite['id_activite']) ?>" method="post">
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

            <div class="footer">Gestion des activites sportives.</div>
        </div>
    </div>
</body>
</html>
