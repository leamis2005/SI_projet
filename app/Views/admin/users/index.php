<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs</title>
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
                <h1 class="card-title">Liste des utilisateurs</h1>
                <p class="card-subtitle"><?= count($users) ?> utilisateur(s)</p>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <div class="table-responsive stack-sm">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Inscription</th>
                                <th>Wallet</th>
                                <th>Gold</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= esc($user['nom'] ?? '-') ?></td>
                                    <td><?= esc($user['email'] ?? '-') ?></td>
                                    <td><?= esc($user['date_inscription'] ?? '-') ?></td>
                                    <td><?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?></td>
                                    <td><?= (int) ($user['gold'] ?? 0) === 1 ? 'Oui' : 'Non' ?></td>
                                    <td>
                                        <a class="btn btn-ghost" href="<?= site_url('/admin/users/' . $user['id_user']) ?>">Voir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="footer">Gestion des utilisateurs.</div>
        </div>
    </div>
</body>
</html>
