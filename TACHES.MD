.V1:
    ETU003919 ETU004275

    .CREATION DE LA BASE OK 
        -Creer les tables : 
            -operateur(id, nom)
            -prefixe(id, libelle, operateur_id)
            -type_operation(id, lib)
            -tranche_frais(id, type_operation_id, montant_min, montant_max, frais)
            -transaction(id, date, numero, montant, frais, type_operation_id, operateur_id)
            -client(id, nom, prenom, telelphone)
            -compte(id, numero, solde, client_id, operateur_id)

        -Creation des requetes 
            -Historiques, depot , solde actuel 

    -ETU004275:
        -Dashboard(gain(frais), solde total des clients)