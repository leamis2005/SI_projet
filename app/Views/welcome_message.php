<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bienvenue</title>
    <meta name="description" content="Le petit framework aux grandes capacites">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <div class="page">
        <div class="container">
            <header class="site-header">
                <div class="brand">
                    <span class="brand-mark">CI</span>
                    <span>CodeIgniter</span>
                </div>
                <nav class="nav">
                    <a href="https://codeigniter.com/user_guide/" target="_blank">Docs</a>
                    <a href="https://forum.codeigniter.com/" target="_blank">Communaute</a>
                    <a href="https://codeigniter.com/contribute" target="_blank">Contribuer</a>
                </nav>
            </header>

            <section class="hero">
                <div class="fade-up">
                    <h1 class="hero-title">Bienvenue sur CodeIgniter <?= CodeIgniter\CodeIgniter::CI_VERSION ?></h1>
                    <p class="hero-subtitle">Le petit framework aux grandes capacites. Cette page est generee dynamiquement.</p>
                    <div class="actions">
                        <a class="btn btn-primary" href="https://codeigniter.com/user_guide/" target="_blank">Voir la doc</a>
                        <a class="btn btn-ghost" href="<?= site_url('/') ?>">Retour accueil</a>
                    </div>
                </div>
                <div class="card fade-up">
                    <h2 class="card-title">Où modifier cette page ?</h2>
                    <p class="card-subtitle">Les fichiers suivants pilotent cette vue.</p>
                    <div class="stat-grid">
                        <div class="stat">
                            <div class="stat-label">Vue</div>
                            <div class="stat-value">app/Views/welcome_message.php</div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Controleur</div>
                            <div class="stat-value">app/Controllers/Home.php</div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Environnement</div>
                            <div class="stat-value"><?= ENVIRONMENT ?></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="hero" style="margin-top: 32px;">
                <div class="card stagger">
                    <h2 class="card-title">Aller plus loin</h2>
                    <p class="card-subtitle">Ressources utiles pour continuer votre parcours.</p>
                    <div class="actions">
                        <a class="btn btn-secondary" href="https://codeigniter.com/user_guide/" target="_blank">Guide utilisateur</a>
                        <a class="btn btn-secondary" href="https://forum.codeigniter.com/" target="_blank">Forum</a>
                        <a class="btn btn-secondary" href="https://join.slack.com/t/codeigniterchat/shared_invite/zt-rl30zw00-obL1Hr1q1ATvkzVkFp8S0Q" target="_blank">Slack</a>
                    </div>
                </div>
                <div class="card stagger">
                    <h2 class="card-title">Statut</h2>
                    <p class="card-subtitle">Page rendue en {elapsed_time} s avec {memory_usage} MB.</p>
                    <div class="actions">
                        <a class="btn btn-ghost" href="https://codeigniter.com/contribute" target="_blank">Contribuer</a>
                    </div>
                </div>
            </section>

            <div class="footer">&copy; <?= date('Y') ?> CodeIgniter Foundation. Licence MIT.</div>
        </div>
    </div>
</body>
</html>
