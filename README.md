# Projet_S4

## Prerequis
- PHP 8.2+ avec extensions `intl`, `mbstring` et `dom`
- Composer

## Installation
1) Installer les dependances :

```bash
composer install
```

2) Creer le fichier d'environnement :

```bash
cp env .env
```

3) Editer `.env` et renseigner au minimum :
- `CI_ENVIRONMENT = development`
- `app.baseURL`

4) Renseigner la base dans la config PHP :
- Modifier les valeurs de `database.default.*` dans [app/Config/Database.php](app/Config/Database.php)

## Lancer le projet
Utiliser le serveur integre PHP en pointant sur `public/` :

```bash
php -S localhost:8080 -t public
```

Élevé — inscription en 2 pages non respectée. L’inscription est une seule page et mélange les infos utilisateur (nom/email/genre/date) sans étape séparée “santé”. inscription.php:31-64 et le contrôleur ne traite pas taille/poids. Auth.php:55-80
Élevé — IMC calculé mais jamais affiché. Le calcul est fait et stocké, mais aucune vue ne l’affiche à l’utilisateur. Home.php:62-79 et accueil_user.php:26-66
Élevé — objectifs utilisateur (3 choix) non implémentés. Aucune route/écran pour sélectionner des objectifs; seules routes présentes sont login/inscription/accueil/profil-sante. Routes.php:8-15 alors que la base prévoit objectifs/user_objectif. baseRegime.sql:16-35
Moyen — CRUD régimes / activités / paramètres absent. Aucun contrôleur, modèle ou route CRUD visible; seules routes de base sont définies. Routes.php:8-15
*Moyen — wallet (codes) + option Gold non implémentés. Tables prévues mais aucune logique ni routes d’activation/validation; aucune gestion du prix Gold/remise. baseRegime.sql:59-104 et Routes.php:8-15
Moyen — export PDF, dashboard stats/graphes non implémentés. Pas de routes ni vues dédiées. Routes.php:8-15
Faible — “page d’authentification au démarrage” non forcée. Le démarrage est sur Home::index et non un redirect login. Routes.php:8-9 et Home.php:13-16
Ce qui est déjà aligné

Authentification (login/inscription) en place. Auth.php:12-92
Saisie des infos santé (genre, taille, poids) après login et sauvegarde du profil santé + IMC stocké. accueil_user.php:26-66 et Home.php:42-87
Questions / hypothèses

Tu veux bien que la page d’accueil “/” redirige directement vers /login ?
Pour l’inscription en 2 étapes, tu préfères un flow “étape 1 -> étape 2” avant création du compte, ou création du compte puis complétion santé ?
Si tu veux, je te propose un plan d’implémentation par étapes (2 pages d’inscription → IMC affiché → objectifs → suggestions régimes/activités → wallet+Gold → PDF).

