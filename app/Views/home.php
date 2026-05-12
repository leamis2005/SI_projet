<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body class="theme-home">
    <div class="page">
        <div class="container">
            <header class="site-header">
                <a class="brand" href="<?= site_url('/') ?>">
                    <span class="brand-mark">R</span>
                    Regime App
                </a>
                <nav class="nav">
                    <a href="<?= site_url('/login') ?>">Connexion</a>
                    <a href="<?= site_url('/inscription') ?>">Inscription</a>
                </nav>
            </header>

            <section class="hero">
                <div class="hero-text fade-up">
                    <h1 class="hero-title">Bienvenue</h1>
                    <p class="hero-subtitle">Une interface claire et elegante pour acceder a votre espace et suivre vos operations en toute confiance.</p>
                    <div class="actions">
                        <a class="btn btn-primary" href="<?= site_url('/login') ?>">Connexion</a>
                        <a class="btn btn-secondary" href="<?= site_url('/inscription') ?>">Inscription</a>
                    </div>
                </div>
            </section>

            <div class="footer">&copy; <?= date('Y') ?> Tous droits reserves.</div>
        </div>
    </div>
</body>
</html>
