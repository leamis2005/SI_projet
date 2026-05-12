<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Accueil Admin</title>
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
					<a href="<?= site_url('/admin/regimes') ?>">Regimes</a>
					<a href="<?= site_url('/admin/activites') ?>">Activites</a>
					<a href="<?= site_url('/admin/parametres') ?>">Parametres</a>
					<a href="<?= site_url('/logout') ?>">Deconnexion</a>
				</nav>
			</header>

			<section class="hero">
				<div class="hero-text fade-up">
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
