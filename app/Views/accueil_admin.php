<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Accueil Admin</title>
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
					<h1 class="hero-title">Bienvenue, Administrateur</h1>
					<p class="hero-subtitle">Supervisez les operations, pilotez les acces et gardez la vision globale.</p>
					<div class="actions">
						<a class="btn btn-primary" href="<?= site_url('/') ?>">Retour accueil</a>
					</div>
				</div>
			</section>

			<div class="footer">Administration securisee.</div>
		</div>
	</div>
</body>
</html>
