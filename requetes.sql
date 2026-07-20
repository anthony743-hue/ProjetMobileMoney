--1. Gains totaux de l’opérateur (frais collectés)
SELECT o.nom AS operateur, SUM(t.frais) AS gains_totaux
FROM transactions t
JOIN operateurs o ON t.operateur_id = o.id
WHERE t.statut = 'termine'
GROUP BY o.id;

--2 situation des compte (compte actuel )
SELECT telephone, prenom, nom, solde
FROM clients
ORDER BY solde DESC;


--3 Historiques des transactions
SELECT t.id, t.type, t.montant, t.frais, t.date_transaction,
       CASE
           WHEN t.emetteur_id = 1 THEN - (t.montant + CASE WHEN t.type='transfert' THEN t.frais ELSE 0 END)
           WHEN t.recepteur_id = 1 THEN
               CASE WHEN t.type='depot' THEN t.montant - t.frais ELSE t.montant END
       END AS impact_solde
FROM transactions t
WHERE (emetteur_id = 1 OR recepteur_id = 1) AND statut = 'termine'
ORDER BY t.date_transaction DESC;




--4 Trouver les frais applicables pour un montant donné
SELECT type_transaction, montant_min, montant_max, frais
FROM regles_frais
WHERE operateur_id = 1
  AND type_transaction = 'transfert'
  AND 2000 BETWEEN montant_min AND montant_max;





  INSERT INTO clients (telephone, prenom, nom) VALUES
('0379876543', 'Claire', 'Rabe'),
('0329876543', 'David', 'Rakoto'),
('0375555555', 'Emma', 'Andri');



DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS regles_frais;
DROP TABLE IF EXISTS prefixes_operateur;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS operateurs;