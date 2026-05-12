<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs</title>
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

            <div class="card fade-up">
                <h1 class="card-title">Liste des utilisateurs</h1>
                <p class="card-subtitle"><?= count($users) ?> utilisateur(s)</p>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <table style="width: 100%; border-collapse: collapse; margin-top: 12px;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid rgba(15, 23, 42, 0.12);">
                            <th style="padding: 8px 6px;">Nom</th>
                            <th style="padding: 8px 6px;">Email</th>
                            <th style="padding: 8px 6px;">Inscription</th>
                            <th style="padding: 8px 6px;">Wallet</th>
                            <th style="padding: 8px 6px;">Gold</th>
                            <th style="padding: 8px 6px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr style="border-bottom: 1px solid rgba(15, 23, 42, 0.08);">
                                <td style="padding: 8px 6px;"><?= esc($user['nom'] ?? '-') ?></td>
                                <td style="padding: 8px 6px;"><?= esc($user['email'] ?? '-') ?></td>
                                <td style="padding: 8px 6px;"><?= esc($user['date_inscription'] ?? '-') ?></td>
                                <td style="padding: 8px 6px;"><?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?></td>
                                <td style="padding: 8px 6px;"><?= (int) ($user['gold'] ?? 0) === 1 ? 'Oui' : 'Non' ?></td>
                                <td style="padding: 8px 6px;">
                                    <a class="btn btn-ghost" href="<?= site_url('/admin/users/' . $user['id_user']) ?>">Voir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="footer">Gestion des utilisateurs.</div>
        </div>
    </div>
</body>
</html>
