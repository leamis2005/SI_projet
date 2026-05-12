<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #0b1220;
            margin: 24px;
        }
        h1 {
            font-size: 22px;
            margin: 0 0 8px;
        }
        h2 {
            font-size: 16px;
            margin: 24px 0 8px;
        }
        p {
            margin: 4px 0;
        }
        .meta {
            color: #526079;
            font-size: 12px;
        }
        .card {
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            border-radius: 8px;
            margin-top: 12px;
        }
        .stat {
            font-weight: 600;
        }
        ul {
            margin: 8px 0 0 18px;
        }
    </style>
</head>
<body>
    <h1>Profil utilisateur</h1>
    <div class="meta">Document genere le <?= esc($generatedAt) ?></div>

    <div class="card">
        <h2>Informations personnelles</h2>
        <p><span class="stat">Nom:</span> <?= esc($user['nom'] ?? '-') ?></p>
        <p><span class="stat">Email:</span> <?= esc($user['email'] ?? '-') ?></p>
        <p><span class="stat">Genre:</span> <?= esc($user['genre'] ?? '-') ?></p>
        <p><span class="stat">Date de naissance:</span> <?= esc($user['date_naissance'] ?? '-') ?></p>
        <p><span class="stat">Wallet:</span> <?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?></p>
        <p><span class="stat">Gold:</span> <?= (int) ($user['gold'] ?? 0) === 1 ? 'Actif' : 'Inactif' ?></p>
    </div>

    <div class="card">
        <h2>Profil sante</h2>
        <p><span class="stat">Taille:</span> <?= esc($profil['taille'] ?? '-') ?> m</p>
        <p><span class="stat">Poids:</span> <?= esc($profil['poids'] ?? '-') ?> kg</p>
        <p><span class="stat">IMC:</span> <?= esc($profil['imc'] ?? '-') ?></p>
    </div>

    <div class="card">
        <h2>Objectifs selectionnes</h2>
        <?php if (! empty($objectifs)) : ?>
            <ul>
                <?php foreach ($objectifs as $objectif) : ?>
                    <li><?= esc($objectif['libelle']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun objectif selectionne.</p>
        <?php endif; ?>
    </div>
</body>
</html>
