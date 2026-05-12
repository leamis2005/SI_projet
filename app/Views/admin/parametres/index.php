<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parametres</title>
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
                <div class="section-header">
                    <div>
                        <h1 class="card-title">Parametres</h1>
                        <p class="card-subtitle"><?= count($parametres) ?> parametre(s)</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-primary" href="<?= site_url('/admin/parametres/create') ?>">Ajouter</a>
                    </div>
                </div>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <table style="width: 100%; border-collapse: collapse; margin-top: 12px;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid rgba(15, 23, 42, 0.12);">
                            <th style="padding: 8px 6px;">Cle</th>
                            <th style="padding: 8px 6px;">Valeur</th>
                            <th style="padding: 8px 6px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parametres as $parametre) : ?>
                            <tr style="border-bottom: 1px solid rgba(15, 23, 42, 0.08);">
                                <td style="padding: 8px 6px;"><?= esc($parametre['cle'] ?? '-') ?></td>
                                <td style="padding: 8px 6px;"><?= esc($parametre['valeur'] ?? '-') ?></td>
                                <td style="padding: 8px 6px;">
                                    <a class="btn btn-ghost" href="<?= site_url('/admin/parametres/edit/' . $parametre['id_param']) ?>">Modifier</a>
                                    <form action="<?= site_url('/admin/parametres/delete/' . $parametre['id_param']) ?>" method="post" style="display:inline;">
                                        <button class="btn btn-ghost" type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="footer">Gestion des parametres.</div>
        </div>
    </div>
</body>
</html>
