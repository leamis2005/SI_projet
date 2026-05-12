<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
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
                    <a href="<?= site_url('/') ?>">Accueil</a>
                    <a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a>
                    <a href="<?= site_url('/admin/users') ?>">Utilisateurs</a>
                    <a href="<?= site_url('/admin/regimes') ?>">Regimes</a>
                    <a href="<?= site_url('/admin/activites') ?>">Activites</a>
                    <a href="<?= site_url('/admin/parametres') ?>">Parametres</a>
                    <a href="<?= site_url('/logout') ?>">Deconnexion</a>
                </nav>
            </header>

            <section class="hero">
                <div class="hero-text fade-up">
                    <h1 class="hero-title">Dashboard</h1>
                    <p class="hero-subtitle">Vue d'ensemble de l'activite et des tendances.</p>
                </div>
                <div class="card fade-up">
                    <h2 class="card-title">Chiffres cles</h2>
                    <div class="stat-grid">
                        <div class="stat">
                            <div class="stat-label">Utilisateurs</div>
                            <div class="stat-value"><?= esc($totalUsers) ?></div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Gold actifs</div>
                            <div class="stat-value"><?= esc($goldUsers) ?></div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Wallet total</div>
                            <div class="stat-value"><?= esc(number_format((float) $walletTotal, 2, ',', ' ')) ?></div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Transactions</div>
                            <div class="stat-value"><?= esc($transactionsCount) ?></div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Regimes</div>
                            <div class="stat-value"><?= esc($regimesCount) ?></div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Activites</div>
                            <div class="stat-value"><?= esc($activitesCount) ?></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="hero">
                <div class="card fade-up">
                    <h2 class="card-title">Derniers utilisateurs</h2>
                    <p class="card-subtitle">Cliquez sur un utilisateur pour voir ses informations.</p>

                    <?php if (! empty($users)) : ?>
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
                    <?php else : ?>
                        <div class="alert">Aucun utilisateur enregistre.</div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="hero">
                <div class="card fade-up">
                    <h2 class="card-title">Objectifs les plus selectionnes</h2>
                    <p class="card-subtitle">Repartition des objectifs choisis par les utilisateurs.</p>
                    <div class="chart">
                        <?php if (! empty($objectifs)) : ?>
                            <?php foreach ($objectifs as $objectif) : ?>
                                <?php $percent = $objectifMax > 0 ? (int) round(((int) $objectif['total'] / $objectifMax) * 100) : 0; ?>
                                <div class="chart-row">
                                    <div class="chart-label"><?= esc($objectif['libelle']) ?></div>
                                    <div class="chart-bar"><span style="width: <?= $percent ?>%"></span></div>
                                    <div class="chart-value"><?= esc((int) $objectif['total']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="alert">Aucun objectif enregistre.</div>
                        <?php endif; ?>
                    </div>

                    <?php if (! empty($objectifs)) : ?>
                        <div class="table-responsive stack-sm">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Objectif</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($objectifs as $objectif) : ?>
                                        <tr>
                                            <td><?= esc($objectif['libelle']) ?></td>
                                            <td><?= esc((int) $objectif['total']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card fade-up">
                    <h2 class="card-title">Transactions par type</h2>
                    <p class="card-subtitle">Volume et montant total par categorie.</p>
                    <div class="chart">
                        <?php if (! empty($transactionsByType)) : ?>
                            <?php foreach ($transactionsByType as $transaction) : ?>
                                <?php $percent = $transactionMax > 0 ? (int) round(((int) $transaction['total'] / $transactionMax) * 100) : 0; ?>
                                <div class="chart-row">
                                    <div class="chart-label"><?= esc($transaction['type']) ?></div>
                                    <div class="chart-bar"><span style="width: <?= $percent ?>%"></span></div>
                                    <div class="chart-value"><?= esc((int) $transaction['total']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="alert">Aucune transaction enregistree.</div>
                        <?php endif; ?>
                    </div>

                    <?php if (! empty($transactionsByType)) : ?>
                        <div class="table-responsive stack-sm">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Total</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactionsByType as $transaction) : ?>
                                        <tr>
                                            <td><?= esc($transaction['type']) ?></td>
                                            <td><?= esc((int) $transaction['total']) ?></td>
                                            <td><?= esc(number_format((float) $transaction['montant_total'], 2, ',', ' ')) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <div class="footer">Dashboard mis a jour.</div>
        </div>
    </div>
</body>
</html>
