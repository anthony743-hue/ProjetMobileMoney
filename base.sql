-- =============================================================================
-- 0. NETTOYAGE : suppression des triggers puis des tables
-- =============================================================================
DROP TRIGGER IF EXISTS mise_a_jour_solde;

DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS regles_frais;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS prefixes_operateur;
DROP TABLE IF EXISTS operateurs;

-- =============================================================================
-- 1. CRÉATION DES TABLES
-- =============================================================================

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE,
    description TEXT,
    code_secret TEXT NOT NULL DEFAULT 'admin123',
    commission_inter_operateur REAL NOT NULL DEFAULT 0.0
);

CREATE TABLE prefixes_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER NOT NULL,
    prefixe TEXT NOT NULL UNIQUE,
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id) ON DELETE CASCADE
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    prenom TEXT,
    nom TEXT,
    solde REAL NOT NULL DEFAULT 0.0,
    date_creation TEXT DEFAULT (datetime('now'))
);

CREATE TABLE regles_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER NOT NULL,
    type_transaction TEXT NOT NULL CHECK (type_transaction IN ('depot','retrait','transfert')),
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    est_pourcentage INTEGER DEFAULT 0,
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id) ON DELETE CASCADE
);

CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT NOT NULL CHECK (type IN ('depot','retrait','transfert')),
    montant REAL NOT NULL,
    frais REAL NOT NULL,
    commission_externe REAL DEFAULT 0.0,
    emetteur_id INTEGER,
    recepteur_id INTEGER,
    operateur_id INTEGER NOT NULL,
    statut TEXT DEFAULT 'termine' CHECK (statut IN ('en_attente','termine','echoue')),
    date_transaction TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (emetteur_id) REFERENCES clients(id),
    FOREIGN KEY (recepteur_id) REFERENCES clients(id),
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id)
);

-- Index
CREATE INDEX IF NOT EXISTS idx_transactions_emetteur ON transactions(emetteur_id);
CREATE INDEX IF NOT EXISTS idx_transactions_recepteur ON transactions(recepteur_id);
CREATE INDEX IF NOT EXISTS idx_transactions_operateur ON transactions(operateur_id);
CREATE INDEX IF NOT EXISTS idx_regles_frais_operateur_type ON regles_frais(operateur_id, type_transaction);

-- =============================================================================
-- 2. TRIGGER DE MISE À JOUR DES SOLDES
-- =============================================================================
CREATE TRIGGER mise_a_jour_solde AFTER INSERT ON transactions
WHEN NEW.statut = 'termine'
BEGIN
    -- Dépôt : créditer le récepteur de (montant - frais)
    UPDATE clients SET solde = solde + (NEW.montant - NEW.frais)
    WHERE id = NEW.recepteur_id AND NEW.type = 'depot';

    -- Retrait : débiter l’émetteur de (montant + frais)
    UPDATE clients SET solde = solde - (NEW.montant + NEW.frais)
    WHERE id = NEW.emetteur_id AND NEW.type = 'retrait';

    -- Transfert : débiter l’émetteur du total, créditer le récepteur du montant seul
    UPDATE clients SET solde = solde - (NEW.montant + NEW.frais)
    WHERE id = NEW.emetteur_id AND NEW.type = 'transfert';
    UPDATE clients SET solde = solde + NEW.montant
    WHERE id = NEW.recepteur_id AND NEW.type = 'transfert';
END;

-- =============================================================================
-- 3. DONNÉES DE TEST
-- =============================================================================

-- Opérateurs
INSERT INTO operateurs (nom, description, code_secret, commission_inter_operateur) VALUES
('Orange Money', 'Votre opérateur principal', 'orange2024', 2.0),
('Airtel Money',  'Concurrent Airtel',          'airtel2024',  0.0),
('Telma Mobile',  'Concurrent Telma',           'telma2024',   0.0);

-- Préfixes
INSERT INTO prefixes_operateur (operateur_id, prefixe) VALUES
(1, '032'), (1, '037'),          -- Orange Money
(2, '031'), (2, '034'),          -- Airtel
(3, '033'), (3, '038');          -- Telma

-- Règles de frais pour Orange Money (opérateur 1)
INSERT INTO regles_frais (operateur_id, type_transaction, montant_min, montant_max, frais) VALUES
(1, 'depot',     100,  1000,  50),
(1, 'depot',    1001,  5000,  50),
(1, 'depot',    5001, 10000, 100),
(1, 'retrait',   100,  1000,  50),
(1, 'retrait',  1001,  5000,  75),
(1, 'retrait',  5001, 10000, 150),
(1, 'transfert', 100,  1000,  25),
(1, 'transfert',1001,  5000,  50),
(1, 'transfert',5001, 10000, 100);

-- Clients
INSERT INTO clients (telephone, prenom, nom, solde) VALUES
('0371234567', 'Alice', 'Diop',  50000),
('0321234567', 'Bob',   'Fall',  30000),
('0378888888', 'Jean',  'Razafy',  80000),
('0312233445', 'Airtel', 'Client',  15000),
('0339988776', 'Telma',  'Client',  20000);

-- Transactions de démonstration
INSERT INTO transactions (type, montant, frais, commission_externe, emetteur_id, recepteur_id, operateur_id, statut, date_transaction) VALUES
('depot', 5000, 50, 0, NULL, 1, 1, 'termine', '2026-07-18 08:30:00'),
('depot', 8000, 100,0, NULL, 2, 1, 'termine', '2026-07-18 10:15:00'),
('retrait', 2000, 75, 0, 1, NULL, 1, 'termine', '2026-07-19 09:00:00'),
('transfert', 3000, 50, 0, 1, 2, 1, 'termine', '2026-07-19 14:20:00'),
('transfert', 7000, 100,0, 3, 1, 1, 'termine', '2026-07-20 10:05:00'),
('transfert', 10000, 300, 200, 2, 4, 1, 'termine', '2026-07-20 11:45:00');