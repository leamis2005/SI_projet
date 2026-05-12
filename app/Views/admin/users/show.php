<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateur</title>
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

            <section class="hero">
                <div class="hero-text fade-up">
                    <h1 class="hero-title">Utilisateur</h1>
                    <p class="hero-subtitle">Fiche detaillee de l'utilisateur.</p>
                </div>
                <div class="card fade-up">
                    <h2 class="card-title">Informations personnelles</h2>
                    <div class="info-list">
                        <div class="info-item"><span>Nom</span><strong><?= esc($user['nom'] ?? '-') ?></strong></div>
                        <div class="info-item"><span>Email</span><strong><?= esc($user['email'] ?? '-') ?></strong></div>
                        <div class="info-item"><span>Genre</span><strong><?= esc($user['genre'] ?? '-') ?></strong></div>
                        <div class="info-item"><span>Date naissance</span><strong><?= esc($user['date_naissance'] ?? '-') ?></strong></div>
                        <div class="info-item"><span>Inscription</span><strong><?= esc($user['date_inscription'] ?? '-') ?></strong></div>
                        <div class="info-item"><span>Wallet</span><strong><?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?></strong></div>
                        <div class="info-item"><span>Gold</span><strong><?= (int) ($user['gold'] ?? 0) === 1 ? 'Actif' : 'Inactif' ?></strong></div>
                    </div>
                </div>
            </section>

            <section class="hero">
                <div class="card fade-up">
                    <h2 class="card-title">Profil sante</h2>
                    <div class="info-list">
                        <div class="info-item"><span>Taille</span><strong><?= esc($profil['taille'] ?? '-') ?> m</strong></div>
                        <div class="info-item"><span>Poids</span><strong><?= esc($profil['poids'] ?? '-') ?> kg</strong></div>
                        <div class="info-item"><span>IMC</span><strong><?= esc($profil['imc'] ?? '-') ?></strong></div>
                    </div>
                </div>
                <div class="card fade-up">
                    <h2 class="card-title">Objectifs</h2>
                    <?php if (! empty($objectifs)) : ?>
                        <ul>
                            <?php foreach ($objectifs as $objectif) : ?>
                                <li><?= esc($objectif['libelle']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <div class="alert">Aucun objectif selectionne.</div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="hero">
                <div class="card fade-up">
                    <h2 class="card-title">Regime choisi</h2>
                    <?php if (! empty($regime)) : ?>
                        <div class="info-list">
                            <div class="info-item"><span>Regime</span><strong><?= esc($regime['nom'] ?? '-') ?></strong></div>
                            <div class="info-item"><span>Duree</span><strong><?= esc($regime['duree'] ?? '-') ?> jours</strong></div>
                            <div class="info-item"><span>Variation poids</span><strong><?= esc($regime['variation_poids'] ?? '-') ?></strong></div>
                            <div class="info-item"><span>Prix total</span><strong><?= esc(number_format((float) ($regime['prix_base'] ?? 0), 2, ',', ' ')) ?></strong></div>
                            <div class="info-item"><span>Prix par jour</span><strong><?= esc(number_format((float) ($regime['prix_par_jour'] ?? 0), 2, ',', ' ')) ?></strong></div>
                            <div class="info-item"><span>% viande</span><strong><?= esc($regime['viande_percent'] ?? '-') ?>%</strong></div>
                            <div class="info-item"><span>% poisson</span><strong><?= esc($regime['poisson_percent'] ?? '-') ?>%</strong></div>
                            <div class="info-item"><span>% volaille</span><strong><?= esc($regime['volaille_percent'] ?? '-') ?>%</strong></div>
                            <div class="info-item"><span>Date debut</span><strong><?= esc($regime['date_debut'] ?? '-') ?></strong></div>
                            <div class="info-item"><span>Date fin</span><strong><?= esc($regime['date_fin'] ?? '-') ?></strong></div>
                        </div>
                    <?php else : ?>
                        <div class="alert">Aucun regime choisi.</div>
                    <?php endif; ?>
                </div>
                <div class="card fade-up">
                    <h2 class="card-title">Transactions</h2>
                    <?php if (! empty($transactions)) : ?>
                        <div class="table-responsive stack-sm">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>
                                        <tr>
                                            <td><?= esc($transaction['type'] ?? '-') ?></td>
                                            <td><?= esc(number_format((float) ($transaction['montant'] ?? 0), 2, ',', ' ')) ?></td>
                                            <td><?= esc($transaction['date_transaction'] ?? '-') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="alert">Aucune transaction enregistree.</div>
                    <?php endif; ?>
                </div>
            </section>

            <div class="footer">Fiche utilisateur.</div>
        </div>
    </div>
</body>
</html>
