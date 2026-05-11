<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription - Sante</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <div class="page">
        <div class="container">
            <header class="site-header">
                <nav class="nav">
                    <a href="<?= site_url('/') ?>">Accueil</a>
                    <a href="<?= site_url('/login') ?>">Connexion</a>
                </nav>
            </header>

            <div class="card form-card fade-up">
                <h1 class="card-title">Informations de sante</h1>
                <p class="card-subtitle">Renseignez votre taille et votre poids.</p>

                <?php if (! empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form class="form-grid" action="<?= site_url('/inscription-sante') ?>" method="post">
                    <div class="field">
                        <label for="taille">Taille (m)</label>
                        <input type="number" step="0.01" id="taille" name="taille" value="<?= esc(old('taille')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="poids">Poids (kg)</label>
                        <input type="number" step="0.01" id="poids" name="poids" value="<?= esc(old('poids')) ?>" required>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit">Terminer l'inscription</button>
                        <a class="btn btn-ghost" href="<?= site_url('/inscription') ?>">Retour</a>
                    </div>
                </form>
            </div>

            <div class="footer">Vos donnees sont protegees et securisees.</div>
        </div>
    </div>
</body>
</html>
