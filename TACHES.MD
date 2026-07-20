.V1:
    -Creer les tables :
        -operateur(id, nom)
        -prefixe(id, libelle, operateur_id)
        -type_operation(id, lib)
        -tranche_frais(id, type_operation_id, montant_min, montant_max, frais)
        -transaction(id, date, numero, montant, frais, type_operation_id, operateur_id)
        -client(id, nom, prenom, telelphone)
        -compte(id, numero, solde, client_id, operateur_id)
        
