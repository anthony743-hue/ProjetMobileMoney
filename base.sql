-- 1. Opérateurs (permet d’en avoir plusieurs pour simuler la concurrence)
CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE,
    description TEXT
);

-- 2. Préfixes de numéros appartenant à un opérateur
CREATE TABLE prefixes_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER NOT NULL,
    prefixe TEXT NOT NULL UNIQUE,          -- ex: "77", "78", "769"
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id) ON DELETE CASCADE
);

-- 3. Clients (un client = un numéro de téléphone, compte mobile money)
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    prenom TEXT,
    nom TEXT,
    solde REAL NOT NULL DEFAULT 0.0,      -- solde courant (peut être calculé en direct)
    date_creation TEXT DEFAULT (datetime('now'))
);

-- 4. Règles de frais par opérateur, type d’opération et tranche de montant
CREATE TABLE regles_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER NOT NULL,
    type_transaction TEXT NOT NULL CHECK (type_transaction IN ('depot','retrait','transfert')),
    montant_min REAL NOT NULL,            -- borne inférieure inclusive
    montant_max REAL NOT NULL,            -- borne supérieure inclusive
    frais REAL NOT NULL,                  -- frais fixe pour cette tranche
    est_pourcentage INTEGER DEFAULT 0,    -- 0=frais fixe, 1=pourcentage (extensible)
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id) ON DELETE CASCADE
);

-- 5. Transactions (historique complet de toutes les opérations)
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT NOT NULL CHECK (type IN ('depot','retrait','transfert')),
    montant REAL NOT NULL,                -- montant de base de l’opération (M)
    frais REAL NOT NULL,                  -- frais réellement prélevés
    emetteur_id INTEGER,                  -- client qui débite (NULL pour dépôt)
    recepteur_id INTEGER,                 -- client qui crédite (NULL pour retrait)
    operateur_id INTEGER NOT NULL,
    statut TEXT DEFAULT 'termine' CHECK (statut IN ('en_attente','termine','echoue')),
    date_transaction TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (emetteur_id) REFERENCES clients(id),
    FOREIGN KEY (recepteur_id) REFERENCES clients(id),
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id)
);

-- Index pour accélérer les recherches courantes
CREATE INDEX idx_transactions_emetteur ON transactions(emetteur_id);
CREATE INDEX idx_transactions_recepteur ON transactions(recepteur_id);
CREATE INDEX idx_transactions_operateur ON transactions(operateur_id);
CREATE INDEX idx_regles_frais_operateur_type ON regles_frais(operateur_id, type_transaction);



CREATE TRIGGER mise_a_jour_solde AFTER INSERT ON transactions
WHEN NEW.statut = 'termine'
BEGIN
    -- Dépôt : créditer le récepteur de (montant - frais)
    UPDATE clients SET solde = solde + (NEW.montant - NEW.frais)
    WHERE id = NEW.recepteur_id AND NEW.type = 'depot';

    -- Retrait : débiter l’émetteur de (montant + frais)
    UPDATE clients SET solde = solde - (NEW.montant + NEW.frais)
    WHERE id = NEW.emetteur_id AND NEW.type = 'retrait';

    -- Transfert : débiter l’émetteur, créditer le récepteur
    UPDATE clients SET solde = solde - (NEW.montant + NEW.frais)
    WHERE id = NEW.emetteur_id AND NEW.type = 'transfert';
    UPDATE clients SET solde = solde + NEW.montant
    WHERE id = NEW.recepteur_id AND NEW.type = 'transfert';
END;



-- Ajout du champ code_secret
ALTER TABLE operateurs ADD COLUMN code_secret TEXT NOT NULL DEFAULT 'admin123';
-- Mise à jour de l'opérateur 1 (Orange Money) avec un code par défaut
UPDATE operateurs SET code_secret = 'admin123' WHERE id = 1;
-- Opérateur Orange Money
INSERT INTO operateurs (nom, description) VALUES ('Orange Money', 'Opérateur principal');

-- Préfixes
INSERT INTO prefixes_operateur (operateur_id, prefixe) VALUES (1, '032'), (1, '037');

-- Règles de frais (pour l’opérateur 1)
INSERT INTO regles_frais (operateur_id, type_transaction, montant_min, montant_max, frais) VALUES
(1, 'depot',     100, 1000, 50),
(1, 'depot',    1001, 5000, 50),
(1, 'depot',    5001, 10000, 100),
(1, 'retrait',   100, 1000, 50),
(1, 'retrait',  1001, 5000, 75),
(1, 'retrait',  5001, 10000, 150),
(1, 'transfert', 100, 1000, 25),
(1, 'transfert',1001, 5000, 50),
(1, 'transfert',5001, 10000, 100);

-- Clients
INSERT INTO clients (telephone, prenom, nom) VALUES
('0371234567', 'Alice', 'Diop'),
('0321234567', 'Bob', 'Fall');

