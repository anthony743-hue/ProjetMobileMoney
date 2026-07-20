-- ============================================================
-- ACTIVATION DES CLÉS ÉTRANGÈRES (bonne pratique)
-- ============================================================
PRAGMA foreign_keys = ON;

-- ============================================================
-- SUPPRESSION DES ANCIENNES TABLES (pour repartir de zéro)
-- ============================================================
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS regles_frais;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS prefixes_operateur;
DROP TABLE IF EXISTS operateurs;

-- ============================================================
-- 1. TABLE DES OPÉRATEURS (V1 + V2)
-- ============================================================
CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE,
    description TEXT,
    code_secret TEXT NOT NULL DEFAULT 'admin123',              -- V1 : authentification admin
    commission_inter_operateur REAL NOT NULL DEFAULT 0.0     -- V2 : % reversé aux concurrents (ex: 2.0)
);

-- ============================================================
-- 2. PRÉFIXES DE NUMÉROS (V1)
-- ============================================================
CREATE TABLE prefixes_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER NOT NULL,
    prefixe TEXT NOT NULL UNIQUE,                              -- ex: "032", "031"
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id) ON DELETE CASCADE
);

-- ============================================================
-- 3. CLIENTS (comptes mobile money)
-- ============================================================
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    prenom TEXT,
    nom TEXT,
    solde REAL NOT NULL DEFAULT 0.0,
    date_creation TEXT DEFAULT (datetime('now'))
);

-- ============================================================
-- 4. RÈGLES DE FRAIS (V1) avec DÉPÔT GRATUIT (V2)
-- ============================================================
CREATE TABLE regles_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER NOT NULL,
    type_transaction TEXT NOT NULL CHECK (type_transaction IN ('depot','retrait','transfert')),
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    est_pourcentage INTEGER DEFAULT 0,                         -- extensible pour futur
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id) ON DELETE CASCADE
);

-- ============================================================
-- 5. TRANSACTIONS (V1 + V2)
-- ============================================================
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT NOT NULL CHECK (type IN ('depot','retrait','transfert')),
    montant REAL NOT NULL,                                     -- montant de base
    frais REAL NOT NULL,                                       -- frais internes (pour vous)
    commission_externe REAL DEFAULT 0.0,                      -- V2 : commission pour l'autre opérateur
    emetteur_id INTEGER,                                       -- NULL pour un dépôt
    recepteur_id INTEGER,                                      -- NULL pour un retrait
    operateur_id INTEGER NOT NULL,                             -- votre opérateur (celui qui traite la transaction)
    statut TEXT DEFAULT 'termine' CHECK (statut IN ('en_attente','termine','echoue')),
    date_transaction TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (emetteur_id) REFERENCES clients(id),
    FOREIGN KEY (recepteur_id) REFERENCES clients(id),
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id)
);

-- Index (optimisation)
CREATE INDEX idx_transactions_emetteur ON transactions(emetteur_id);
CREATE INDEX idx_transactions_recepteur ON transactions(recepteur_id);
CREATE INDEX idx_transactions_operateur ON transactions(operateur_id);
CREATE INDEX idx_regles_frais_operateur_type ON regles_frais(operateur_id, type_transaction);

-- ============================================================
-- 6. TRIGGER DE MISE À JOUR DES SOLDE (V2 mis à jour)
-- ============================================================
DROP TRIGGER IF EXISTS mise_a_jour_solde;
CREATE TRIGGER mise_a_jour_solde AFTER INSERT ON transactions
WHEN NEW.statut = 'termine'
BEGIN
    -- Dépôt : créditer le récepteur (montant - frais). Ici frais=0 donc crédit intégral
    UPDATE clients SET solde = solde + (NEW.montant - NEW.frais)
    WHERE id = NEW.recepteur_id AND NEW.type = 'depot';

    -- Retrait : débiter l'émetteur (montant + frais)
    UPDATE clients SET solde = solde - (NEW.montant + NEW.frais)
    WHERE id = NEW.emetteur_id AND NEW.type = 'retrait';

    -- Transfert : débiter l'émetteur (montant + frais + commission_externe)
    UPDATE clients SET solde = solde - (NEW.montant + NEW.frais + NEW.commission_externe)
    WHERE id = NEW.emetteur_id AND NEW.type = 'transfert';
    
    -- Transfert : créditer le récepteur du montant (seulement s'il existe localement)
    UPDATE clients SET solde = solde + NEW.montant
    WHERE id = NEW.recepteur_id AND NEW.type = 'transfert';
END;

-- ============================================================
-- 7. DONNÉES INITIALES (V1 + V2)
-- ============================================================

-- 7.1 Opérateur principal (Orange Money)
INSERT INTO operateurs (id, nom, description, code_secret, commission_inter_operateur) 
VALUES (1, 'Orange Money', 'Opérateur principal (simulé)', 'admin123', 2.0);   -- 2% pour V2

-- 7.2 Opérateur concurrent (Airtel) pour la V2
INSERT INTO operateurs (id, nom, description, code_secret, commission_inter_operateur) 
VALUES (2, 'Airtel Money', 'Opérateur concurrent', 'admin123', 0.0);           -- lui n'applique pas de commission

-- 7.3 Préfixes : Orange (032, 037) et Airtel (031)
INSERT INTO prefixes_operateur (operateur_id, prefixe) VALUES
(1, '032'),
(1, '037'),
(2, '031');

-- 7.4 Règles de frais pour Orange (opérateur 1)
-- DÉPÔTS : GRATUITS (frais = 0 partout)
INSERT INTO regles_frais (operateur_id, type_transaction, montant_min, montant_max, frais) VALUES
(1, 'depot', 0, 10000000, 0);   -- Une seule règle : tous les dépôts sont gratuits

-- RETRAITS : barème avec frais
INSERT INTO regles_frais (operateur_id, type_transaction, montant_min, montant_max, frais) VALUES
(1, 'retrait', 100, 1000, 50),
(1, 'retrait', 1001, 5000, 75),
(1, 'retrait', 5001, 10000, 150),
(1, 'retrait', 10001, 50000, 400);   -- extension pour exemples

-- TRANSFERTS : barème avec frais (pour vos clients internes)
INSERT INTO regles_frais (operateur_id, type_transaction, montant_min, montant_max, frais) VALUES
(1, 'transfert', 100, 1000, 25),
(1, 'transfert', 1001, 5000, 50),
(1, 'transfert', 5001, 10000, 100),
(1, 'transfert', 10001, 50000, 200);

-- 7.5 Clients (avec un compte externe pour tester la V2)
INSERT INTO clients (telephone, prenom, nom, solde) VALUES
('0371234567', 'Alice', 'Diop', 50000),   -- Client Orange (interne)
('0321234567', 'Bob',   'Fall', 30000),   -- Client Orange (interne)
('0319876543', 'Charlie', 'Martin', 10000); -- Client Airtel (externe, pour tester l'envoi)

-- ============================================================
-- FIN : Votre base est prête pour la V2 !
-- ============================================================