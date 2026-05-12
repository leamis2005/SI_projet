<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body class="theme-auth">
    <div class="page">
        <div class="container">
            <header class="site-header">
                <a class="brand" href="<?= site_url('/') ?>">
                    <span class="brand-mark">R</span>
                    Regime App
                </a>
                <nav class="nav">
                    <a href="<?= site_url('/') ?>">Accueil</a>
                    <a href="<?= site_url('/inscription') ?>">Inscription</a>
                </nav>
            </header>

            <div class="card form-card fade-up">
                <h1 class="card-title">Connexion</h1>
                <p class="card-subtitle">Accedez a votre espace en toute securite.</p>

                <?php if (! empty($message)) : ?>
                    <div class="alert"><?= esc($message) ?></div>
                <?php endif; ?>

                <?php if (! empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form class="form-grid" action="<?= site_url('/login') ?>" method="post">
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit">Se connecter</button>
                        <a class="btn btn-ghost" href="<?= site_url('/inscription') ?>">Creer un compte</a>
                    </div>
                </form>
            </div>

            <div class="footer">Besoin d'aide ? Contactez le support.</div>
        </div>
    </div>
</body>
</html>
