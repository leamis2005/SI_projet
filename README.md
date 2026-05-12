# SI_projet

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
