<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
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
                <h1 class="card-title">Inscription</h1>
                <p class="card-subtitle">Creez votre compte pour acceder a l'espace personnel.</p>

                <?php if (! empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form class="form-grid" action="<?= site_url('/inscription') ?>" method="post">
                    <div class="field">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    </div>

                    <div class="field">
                        <label for="mot_de_passe_confirm">Confirmer le mot de passe</label>
                        <input type="password" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required>
                    </div>

                    <div class="field">
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">Choisir</option>
                            <option value="HOMME" <?= old('genre') === 'HOMME' ? 'selected' : '' ?>>Homme</option>
                            <option value="FEMME" <?= old('genre') === 'FEMME' ? 'selected' : '' ?>>Femme</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="date_naissance">Date de naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance" value="<?= esc(old('date_naissance')) ?>" required>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit">Continuer</button>
                        <a class="btn btn-ghost" href="<?= site_url('/login') ?>">Deja un compte</a>
                    </div>
                </form>
            </div>

            <div class="footer">Vos donnees sont protegees et securisees.</div>
        </div>
    </div>
</body>
</html>
