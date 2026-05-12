<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Accueil</title>
	<link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
	<div class="page">
		<div class="container">
			<header class="site-header">
				<nav class="nav">
					<a href="<?= site_url('/') ?>">Accueil</a>
				</nav>
			</header>

			<section class="hero">
				<div class="fade-up">
					<h1 class="hero-title">Bienvenue</h1>
					<p class="hero-subtitle">Retrouvez vos informations et continuez vos operations en toute serenite.</p>
					<div class="actions">
						<a class="btn btn-primary" href="<?= site_url('/') ?>">Retour accueil</a>
					</div>
				</div>
				<div class="card form-card fade-up">
					<h2 class="card-title">Informations personnelles</h2>
					<p class="card-subtitle">Renseignez votre genre, taille et poids.</p>

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

					<form class="form-grid" action="<?= site_url('/profil-sante') ?>" method="post">
						<div class="field">
							<label for="genre">Genre</label>
							<?php $genreValue = old('genre') ?: ($user['genre'] ?? ''); ?>
							<select id="genre" name="genre" required>
								<option value="">Choisir</option>
								<option value="HOMME" <?= $genreValue === 'HOMME' ? 'selected' : '' ?>>Homme</option>
								<option value="FEMME" <?= $genreValue === 'FEMME' ? 'selected' : '' ?>>Femme</option>
							</select>
						</div>

						<div class="field">
							<label for="taille">Taille (m)</label>
							<input type="number" step="0.01" id="taille" name="taille" value="<?= esc(old('taille') ?: ($profil['taille'] ?? '')) ?>" required>
						</div>

						<div class="field">
							<label for="poids">Poids (kg)</label>
							<input type="number" step="0.01" id="poids" name="poids" value="<?= esc(old('poids') ?: ($profil['poids'] ?? '')) ?>" required>
						</div>

						<div class="actions">
							<button class="btn btn-primary" type="submit">Enregistrer</button>
						</div>
					</form>
				</div>
			</section>

			<div class="footer">Votre espace est a jour.</div>
		</div>
	</div>
</body>
</html>
