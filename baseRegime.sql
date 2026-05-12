    DROP DATABASE IF EXISTS regime_app;
    CREATE DATABASE IF NOT EXISTS regime_app;
    USE regime_app;

    CREATE TABLE users (
        id_user INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        genre ENUM('HOMME', 'FEMME') NOT NULL,
        date_naissance DATE NOT NULL,
        role ENUM('USER', 'ADMIN') DEFAULT 'USER',
        wallet DECIMAL(10,2) DEFAULT 0,
        gold TINYINT(1) DEFAULT 0,
        date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE profil_sante (
        id_profil INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        taille DECIMAL(5,2) NOT NULL, -- en mètres
        poids DECIMAL(5,2) NOT NULL,  -- en kg
        imc DECIMAL(5,2),
        FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
    );

    CREATE TABLE objectifs (
        id_objectif INT AUTO_INCREMENT PRIMARY KEY,
        libelle VARCHAR(100) NOT NULL
    );

    CREATE TABLE user_objectif (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        id_objectif INT NOT NULL,
        FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
        FOREIGN KEY (id_objectif) REFERENCES objectifs(id_objectif) ON DELETE CASCADE
    );

    CREATE TABLE regimes (
        id_regime INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prix_base DECIMAL(10,2) NOT NULL,
        duree INT NOT NULL, -- en jours

        viande_percent INT DEFAULT 0,
        poisson_percent INT DEFAULT 0,
        volaille_percent INT DEFAULT 0,

        variation_poids VARCHAR(50), -- ex: +3kg / -5kg
        prix_par_jour DECIMAL(10,2) DEFAULT 0
    );

    CREATE TABLE user_regime (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        id_regime INT NOT NULL,
        date_debut DATE,
        date_fin DATE,

        FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
        FOREIGN KEY (id_regime) REFERENCES regimes(id_regime) ON DELETE CASCADE
    );

    CREATE TABLE activites_sportives (
        id_activite INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        calories_brulees INT NOT NULL,
        description TEXT
    );

    CREATE TABLE regime_activite (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_regime INT NOT NULL,
        id_activite INT NOT NULL,

        FOREIGN KEY (id_regime) REFERENCES regimes(id_regime) ON DELETE CASCADE,
        FOREIGN KEY (id_activite) REFERENCES activites_sportives(id_activite) ON DELETE CASCADE
    );

    CREATE TABLE codes_recharge (
        id_code INT AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(50) NOT NULL UNIQUE,
        montant DECIMAL(10,2) NOT NULL,
        statut ENUM('NON_UTILISE', 'UTILISE') DEFAULT 'NON_UTILISE'
    );

    CREATE TABLE transactions (
        id_transaction INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        montant DECIMAL(10,2) NOT NULL,
        type ENUM('AJOUT', 'ACHAT_REGIME', 'GOLD') NOT NULL,
        date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
    );

    CREATE TABLE parametres (
        id_param INT AUTO_INCREMENT PRIMARY KEY,
        cle VARCHAR(50) NOT NULL UNIQUE,
        valeur VARCHAR(255) NOT NULL
    );

    INSERT INTO objectifs (libelle) VALUES
    ('Augmenter son poids'),
    ('Réduire son poids'),
    ('Atteindre IMC idéal');

    INSERT INTO regimes (nom, prix_base, duree, viande_percent, poisson_percent, volaille_percent, variation_poids, prix_par_jour)
    VALUES
    ('Régime prise de masse', 50000, 30, 40, 30, 30, '+5kg', 1666.67),
    ('Régime minceur', 45000, 30, 20, 50, 30, '-5kg', 1500.00),
    ('Régime équilibré', 40000, 30, 33, 33, 34, 'stable', 1333.33),
    ('Régime sportif', 60000, 45, 45, 25, 30, '+3kg muscle', 1333.33),
    ('Régime detox', 35000, 15, 10, 60, 30, '-3kg', 2333.33);

    INSERT INTO activites_sportives (nom, calories_brulees, description)
    VALUES
    ('Course à pied', 500, 'Course 30-45 minutes'),
    ('Musculation', 400, 'Renforcement musculaire'),
    ('Natation', 600, 'Sport complet'),
    ('Cyclisme', 450, 'Endurance vélo'),
    ('Fitness', 350, 'Exercices cardio');

    INSERT INTO codes_recharge (code, montant) VALUES
    ('CODE001', 10000),
    ('CODE002', 15000),
    ('CODE003', 20000),
    ('CODE004', 25000),
    ('CODE005', 30000),
    ('CODE006', 12000),
    ('CODE007', 18000),
    ('CODE008', 22000),
    ('CODE009', 27000),
    ('CODE010', 5000),
    ('CODE011', 8000),
    ('CODE012', 11000),
    ('CODE013', 14000),
    ('CODE014', 16000),
    ('CODE015', 50000);

    INSERT INTO parametres (cle, valeur) VALUES
    ('prix_gold', '50000'),
    ('remise_gold', '15'),
    ('imc_ideal_min', '18.5'),
    ('imc_ideal_max', '24.9');

    INSERT INTO users (nom, email, mot_de_passe, genre, date_naissance, wallet, gold) VALUES
    ('Alice Dupont', 'alice@gmail.com', '$2y$10$hashedpassword1', 'FEMME', '1990-05-15', 50000, 1),
    ('Bob Martin', 'bob@gmail.com', '$2y$10$hashedpassword2', 'HOMME', '1985-03-20', 0, 0);

    -- Admin account (email: admin@example.com, password: admin123)
    INSERT INTO users (nom, email, mot_de_passe, genre, date_naissance, role, wallet, gold) VALUES
    ('Admin', 'admin@gmail.com', '$2y$10$8oDAeD5RRk72dcGGwrrtMuDQhfKvzqdAEFzjlJg7nloZ9EDaK8bb6', 'HOMME', '1990-01-01', 'ADMIN', 0, 0);

    INSERT INTO profil_sante (id_user, taille, poids, imc) VALUES
    (1, 1.65, 60.0, 22.04),
    (2, 1.80, 75.0, 23.15);

    INSERT INTO user_objectif (id_user, id_objectif) VALUES
    (1, 1), (1, 3),  -- Alice : augmenter et atteindre IMC idéal
    (2, 2);          -- Bob : réduire poids
