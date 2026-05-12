<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $mode === 'edit' ? 'Modifier regime' : 'Ajouter regime' ?></title>
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

            <div class="card form-card fade-up">
                <h1 class="card-title"><?= $mode === 'edit' ? 'Modifier le regime' : 'Ajouter un regime' ?></h1>

                <?php if (! empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php $action = $mode === 'edit' ? site_url('/admin/regimes/update/' . $regime['id_regime']) : site_url('/admin/regimes/store'); ?>

                <form class="form-grid" action="<?= $action ?>" method="post">
                    <div class="field">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= esc(old('nom') ?: ($regime['nom'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="prix_base">Prix base</label>
                        <input type="number" step="0.01" id="prix_base" name="prix_base" value="<?= esc(old('prix_base') ?: ($regime['prix_base'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="duree">Duree (jours)</label>
                        <input type="number" id="duree" name="duree" value="<?= esc(old('duree') ?: ($regime['duree'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="viande_percent">% Viande</label>
                        <input type="number" id="viande_percent" name="viande_percent" value="<?= esc(old('viande_percent') ?: ($regime['viande_percent'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="poisson_percent">% Poisson</label>
                        <input type="number" id="poisson_percent" name="poisson_percent" value="<?= esc(old('poisson_percent') ?: ($regime['poisson_percent'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="volaille_percent">% Volaille</label>
                        <input type="number" id="volaille_percent" name="volaille_percent" value="<?= esc(old('volaille_percent') ?: ($regime['volaille_percent'] ?? '')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="variation_poids">Variation poids</label>
                        <input type="text" id="variation_poids" name="variation_poids" value="<?= esc(old('variation_poids') ?: ($regime['variation_poids'] ?? '')) ?>">
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit"><?= $mode === 'edit' ? 'Mettre a jour' : 'Ajouter' ?></button>
                        <a class="btn btn-ghost" href="<?= site_url('/admin/regimes') ?>">Annuler</a>
                    </div>
                </form>
            </div>

            <div class="footer">Gestion des regimes.</div>
        </div>
    </div>
</body>
</html>
