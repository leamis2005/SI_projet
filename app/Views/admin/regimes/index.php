<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Regimes</title>
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
                    <a class="btn btn-primary" href="<?= site_url('/admin/regimes/create') ?>">Ajouter un regime</a>
                </div>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <div class="card stack-sm">
                    <h2 class="card-title">Liste des regimes</h2>
                    <div class="card-subtitle"><?= count($regimes) ?> element(s)</div>

                    <div class="table-responsive stack-sm">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Duree</th>
                                    <th>Prix base</th>
                                    <th>Variation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($regimes as $regime) : ?>
                                    <tr>
                                        <td><?= esc($regime['nom']) ?></td>
                                        <td><?= esc($regime['duree']) ?> jours</td>
                                        <td><?= esc($regime['prix_base']) ?></td>
                                        <td><?= esc($regime['variation_poids']) ?></td>
                                        <td>
                                            <a class="btn btn-ghost" href="<?= site_url('/admin/regimes/edit/' . $regime['id_regime']) ?>">Modifier</a>
                                            <form class="inline-form" action="<?= site_url('/admin/regimes/delete/' . $regime['id_regime']) ?>" method="post">
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

            <div class="footer">Gestion des regimes.</div>
        </div>
    </div>
</body>
</html>
