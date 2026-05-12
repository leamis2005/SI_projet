<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Accueil</title>
	<link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body class="theme-user">
	<div class="page">
		<div class="container">
			<header class="site-header">
				<a class="brand" href="<?= site_url('/') ?>">
					<span class="brand-mark">R</span>
					Regime App
				</a>
				<nav class="nav">
					<a href="<?= site_url('/') ?>">Accueil</a>
					<a href="#profil">Profil</a>
					<a href="#objectifs">Objectifs</a>
					<a href="#wallet">Wallet</a>
					<a href="<?= site_url('/logout') ?>">Deconnexion</a>
				</nav>
			</header>

				<?php
					$objectifCount = is_array($selectedObjectifs ?? null) ? count($selectedObjectifs) : 0;
					$imcValue = $profil['imc'] ?? null;
					$goldActive = (int) ($user['gold'] ?? 0) === 1;
				?>

			<section class="hero">
				<div class="hero-text fade-up">
						<div class="eyebrow">Espace utilisateur</div>
						<h1 class="hero-title">Bienvenue<?= ! empty($user['nom']) ? ', ' . esc($user['nom']) : '' ?></h1>
						<p class="hero-subtitle">Un resume clair de vos donnees sante, objectifs et avantages Gold.</p>
					<div class="actions">
							<a class="btn btn-primary" href="#profil">Mettre a jour le profil</a>
							<a class="btn btn-secondary" href="<?= site_url('/export/pdf') ?>">Exporter le PDF</a>
					</div>
				</div>
					<div class="card fade-up">
						<h2 class="card-title">Apercu rapide</h2>
						<p class="card-subtitle">Vos indicateurs essentiels en un coup d'oeil.</p>
						<div class="stat-grid">
							<div class="stat">
								<div class="stat-label">IMC</div>
								<div class="stat-value"><?= $imcValue !== null ? esc($imcValue) : '-' ?></div>
							</div>
							<div class="stat">
								<div class="stat-label">Objectifs</div>
								<div class="stat-value"><?= esc($objectifCount) ?>/1</div>
							</div>
							<div class="stat">
								<div class="stat-label">Wallet</div>
								<div class="stat-value"><?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?></div>
							</div>
							<div class="stat">
								<div class="stat-label">Gold</div>
								<div class="stat-value"><?= $goldActive ? 'Actif' : 'Inactif' ?></div>
							</div>
						</div>
					</div>
			</section>

				<section id="profil" class="section">
					<div class="section-header">
						<div>
							<h2 class="section-title">Profil sante</h2>
							<p class="section-subtitle">Mettez a jour vos donnees pour garder un suivi fiable.</p>
						</div>
					</div>
					<div class="panel-grid">
						<div class="card form-card fade-up">
							<h3 class="card-title">Informations personnelles</h3>
							<p class="card-subtitle">Genre, taille et poids.</p>

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

						<div class="card fade-up">
							<h3 class="card-title">Synthese</h3>
							<p class="card-subtitle">Votre etat actuel.</p>
							<div class="info-list">
								<div class="info-item"><span>IMC actuel</span><strong><?= $imcValue !== null ? esc($imcValue) : '-' ?></strong></div>
								<div class="info-item"><span>Taille</span><strong><?= esc($profil['taille'] ?? '-') ?> m</strong></div>
								<div class="info-item"><span>Poids</span><strong><?= esc($profil['poids'] ?? '-') ?> kg</strong></div>
								<div class="info-item"><span>Statut Gold</span><strong><?= $goldActive ? 'Actif' : 'Inactif' ?></strong></div>
							</div>
							<div class="actions stack-sm">
								<span class="badge <?= $goldActive ? 'badge-gold' : 'badge-muted' ?>"><?= $goldActive ? 'Gold actif' : 'Gold inactif' ?></span>
							</div>
						</div>
					</div>
				</section>

				<section id="objectifs" class="section">
					<div class="section-header">
						<div>
							<h2 class="section-title">Objectifs</h2>
							<p class="section-subtitle">Choisissez 1 objectif parmi les 3 pour personnaliser vos regimes.</p>
						</div>
						<div class="badge badge-muted">Selectionnes: <?= esc($objectifCount) ?>/1</div>
					</div>
					<div class="card form-card fade-up">
						<?php if (! empty($errors['objectifs'])) : ?>
							<div class="alert"><?= esc($errors['objectifs']) ?></div>
						<?php endif; ?>

						<form class="form-grid" action="<?= site_url('/objectifs') ?>" method="post">
							<?php foreach ($objectifs as $objectif) : ?>
								<?php $checked = in_array($objectif['id_objectif'], $selectedObjectifs ?? [], false); ?>
								<label class="field">
									<input type="checkbox" name="objectifs[]" value="<?= esc($objectif['id_objectif']) ?>" <?= $checked ? 'checked' : '' ?>>
									<?= esc($objectif['libelle']) ?>
								</label>
							<?php endforeach; ?>

							<div class="actions">
								<button class="btn btn-primary" type="submit">Enregistrer</button>
							</div>
						</form>
					</div>

					<?php if (! empty($regimesForObjectif)) : ?>
						<div class="card form-card fade-up stack-sm">
							<h3 class="card-title">Choix du regime</h3>
							<p class="card-subtitle">Choisissez un regime adapte a votre objectif.</p>

							<?php if (! empty($errors['regime'])) : ?>
								<div class="alert"><?= esc($errors['regime']) ?></div>
							<?php endif; ?>

							<form class="form-grid" action="<?= site_url('/regimes/choose') ?>" method="post">
								<div class="field">
									<label for="regime_id">Regime</label>
									<select id="regime_id" name="regime_id" required>
										<option value="">Choisir</option>
										<?php foreach ($regimesForObjectif as $regimeOption) : ?>
											<?php $selected = (int) ($selectedRegimeId ?? 0) === (int) $regimeOption['id_regime']; ?>
											<option value="<?= esc($regimeOption['id_regime']) ?>" <?= $selected ? 'selected' : '' ?>>
												<?= esc($regimeOption['nom']) ?> - <?= esc($regimeOption['duree']) ?> jours
											</option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="actions">
									<button class="btn btn-primary" type="submit">Choisir ce regime</button>
								</div>
							</form>
						</div>
					<?php endif; ?>

					<?php if (! empty($suggestion)) : ?>
						<?php
							$regime = $suggestion['regime'] ?? [];
							$activite = $suggestion['activite'] ?? [];
							$prixBase = (float) ($regime['prix_base'] ?? 0);
							$prixParJour = (float) ($regime['prix_par_jour'] ?? 0);
							$remise = (float) ($goldDiscount ?? 0);
							$prixBaseRemise = $goldActive && $remise > 0 ? round($prixBase * (1 - $remise / 100), 2) : $prixBase;
							$prixParJourRemise = $goldActive && $remise > 0 ? round($prixParJour * (1 - $remise / 100), 2) : $prixParJour;
						?>
						<div class="card fade-up stack-sm">
							<h3 class="card-title">Suggestion automatique</h3>
							<p class="card-subtitle">Regime et activite proposes selon votre objectif.</p>
							<div class="info-list">
								<div class="info-item"><span>Regime</span><strong><?= esc($regime['nom'] ?? '-') ?></strong></div>
								<div class="info-item"><span>Duree</span><strong><?= esc($regime['duree'] ?? '-') ?> jours</strong></div>
								<div class="info-item"><span>Variation poids</span><strong><?= esc($regime['variation_poids'] ?? '-') ?></strong></div>
								<div class="info-item"><span>Prix total</span><strong><?= esc(number_format($prixBaseRemise, 2, ',', ' ')) ?></strong></div>
								<div class="info-item"><span>Prix par jour</span><strong><?= esc(number_format($prixParJourRemise, 2, ',', ' ')) ?></strong></div>
								<div class="info-item"><span>% viande</span><strong><?= esc($regime['viande_percent'] ?? '-') ?>%</strong></div>
								<div class="info-item"><span>% poisson</span><strong><?= esc($regime['poisson_percent'] ?? '-') ?>%</strong></div>
								<div class="info-item"><span>% volaille</span><strong><?= esc($regime['volaille_percent'] ?? '-') ?>%</strong></div>
								<div class="info-item"><span>Activite</span><strong><?= esc($activite['nom'] ?? '-') ?></strong></div>
								<div class="info-item"><span>Calories brulees</span><strong><?= esc($activite['calories_brulees'] ?? '-') ?> kcal</strong></div>
							</div>
						</div>
					<?php endif; ?>
				</section>

				<section id="wallet" class="section">
					<div class="section-header">
						<div>
							<h2 class="section-title">Wallet et option Gold</h2>
							<p class="section-subtitle">Rechargez votre solde et activez les avantages Gold.</p>
						</div>
					</div>
					<div class="panel-grid">
						<div class="card fade-up">
							<h3 class="card-title">Solde et avantages</h3>
							<p class="card-subtitle">Votre niveau et les tarifs associes.</p>

							<?php if (! empty($walletMessage)) : ?>
								<div class="alert"><?= esc($walletMessage) ?></div>
							<?php endif; ?>

							<?php if (! empty($walletErrors['code'])) : ?>
								<div class="alert"><?= esc($walletErrors['code']) ?></div>
							<?php endif; ?>

							<?php if (! empty($walletErrors['gold'])) : ?>
								<div class="alert"><?= esc($walletErrors['gold']) ?></div>
							<?php endif; ?>

							<div class="stat-grid">
								<div class="stat">
									<div class="stat-label">Solde wallet</div>
									<div class="stat-value"><?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?></div>
								</div>
								<div class="stat">
									<div class="stat-label">Statut Gold</div>
									<div class="stat-value"><?= $goldActive ? 'Actif' : 'Inactif' ?></div>
								</div>
								<div class="stat">
									<div class="stat-label">Prix Gold</div>
									<div class="stat-value"><?= esc(number_format((float) ($goldPrice ?? 0), 2, ',', ' ')) ?></div>
								</div>
								<div class="stat">
									<div class="stat-label">Remise Gold (%)</div>
									<div class="stat-value"><?= esc(number_format((float) ($goldDiscount ?? 0), 2, ',', ' ')) ?></div>
								</div>
							</div>
						</div>

						<div class="card form-card fade-up">
							<h3 class="card-title">Actions</h3>
							<p class="card-subtitle">Rechargez votre wallet ou activez Gold.</p>

							<form class="form-grid" action="<?= site_url('/wallet/recharge') ?>" method="post">
								<div class="field">
									<label for="code">Code de recharge</label>
									<input type="text" id="code" name="code" value="<?= esc(old('code')) ?>" required>
								</div>

								<div class="actions">
									<button class="btn btn-secondary" type="submit">Recharger</button>
								</div>
							</form>

							<form class="form-grid" action="<?= site_url('/wallet/gold') ?>" method="post">
								<div class="actions">
									<button class="btn btn-primary" type="submit" <?= $goldActive ? 'disabled' : '' ?>>Activer Gold</button>
								</div>
							</form>
						</div>
					</div>
				</section>

			<div class="footer">Votre espace est a jour.</div>
		</div>
	</div>
</body>
</html>
