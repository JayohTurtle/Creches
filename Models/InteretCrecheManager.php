<?php

include_once('AbstractEntityManager.php');
class InteretCrecheManager extends AbstractEntityManager {

    // Insère les interets avec les id identifiant et contact
    
    public function insertInteretCreche(InteretCreche $interetCreche) {
        // Vérifier si le niveau est vide ou null
        $niveau = $interetCreche->getNiveau();
        if ($niveau === "" || $niveau === null) {
            return;
        }
        
        // Récupérer les valeurs à partir de l'objet InteretCreche
        $idContact = $interetCreche->getIdContact();
        $idLocalisation = $interetCreche->getIdLocalisation();

        // Requête SQL pour insertion ou mise à jour
        $sql = 'INSERT INTO interetcreche (idContact, niveau, idLocalisation) 
                VALUES (:idContact, :niveau, :idLocalisation)
                ON DUPLICATE KEY UPDATE 
                    niveau = VALUES(niveau), 
                    date_colonne = IF(date_colonne IS NOT NULL, NOW(), date_colonne)';

        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau,
            'idLocalisation' => $idLocalisation
        ]);

        return $result;
    }

    //Fonction qui récupère tous les interets creches
    public function getInteretsCrecheData(){
        $sql = "SELECT idContact, niveau, idLocalisation, date_colonne FROM interetCreche";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // Récupère les données sous forme de tableau associatif
    }

    //Fonction qui récupère les interets creches par idContact
    public function getInteretsCrechesByIdContact($idContact) {

        $sql = "SELECT i.niveau, i.idLocalisation, i.date_colonne, i.idInteretCreche,
                l.idLocalisation, l.idGroupe, l.identifiant,l.idVille, l.idDepartement, l.taille, l.adresse,
                v.ville, v.codePostal,
                d.departement, d.idRegion,
                r.region,
                g.nom,
                c.idContact, c.nom, c.email, c.telephone, c.contact
                FROM interetCreche i
                JOIN localisations l ON i.idLocalisation = l.idLocalisation
                JOIN villes v ON l.idVille = v.idVille
                JOIN departements d ON l.idDepartement = d.idDepartement
                JOIN regions r ON d.idRegion = r.idRegion
                JOIN groupes g ON l.idGroupe = g.idGroupe
                JOIN contacts c ON i.idContact = c.idContact
                WHERE i.idContact = :idContact";

        $result = $this->db->query($sql, ['idContact' => $idContact]);

        $interetsCreche = [];
        $niveauCounts = [
            'Achat réalisé' => 0,
            'Dossier envoyé' => 0,
            'NDA envoyé' => 0,
            'Intéressé' => 0,
            'Sous-offre'=> 0
        ];
        
        while ($row = $result->fetch()) {
            // Compter les niveaux
            if (isset($niveauCounts[$row['niveau']])) {
                $niveauCounts[$row['niveau']]++;
            }
        
            // Clé unique basée sur l'ID de localisation
            $key = $row['idLocalisation'];
        
            // Vérifier si on a déjà créé un objet pour cette localisation
            if (!isset($interetsCreche[$key])) {
                $interetsCreche[$key] = new InteretCreche([
                    'idInteretCreche' => $row['idInteretCreche'],
                    'idLocalisation' => $row['idLocalisation'],
                    'dateColonne' => $row['date_colonne'],
                    'niveau' => $row['niveau'],
                    'localisation' => new Localisation([
                        'adresse' => $row['identifiant'], // Pas d'adresse dans la requête, j'utilise `identifiant`
                        'identifiant' => $row['identifiant'],
                        'idGroupe' => $row['idGroupe'],
                        'taille' => $row['taille'],
                        'idVille' => $row['idVille'],
                        'idDepartement' => $row['idDepartement'],
                    ]),
                    'ville' => new Ville([
                        'ville' => $row['ville'],
                        'codePostal' => $row['codePostal']
                    ]),
                    'departement' => new Departement([
                        'departement' => $row['departement'],
                        'idRegion' => $row['idRegion'],
                    ]),
                    'region' => new Region([
                        'region' => $row['region']
                    ])
                ]);
            }
        
            // Ajouter un contact avec le niveau
            $interetsCreche[$key]->ajouterContact(new Contact([
                'idContact' => $idContact,
                'contact' => $row['contact'],
                'nom' => $row['nom'],
                'niveau' => $row['niveau'],
            ]));
        }
        
        // Résultat final : les données complètes + les comptages
        return [
            'interetsCreche' => array_values($interetsCreche), // Pour avoir un tableau indexé propre
            'niveauCounts' => $niveauCounts
        ];
    }

    public function getInteretsCrecheByIdLocalisations(array $idLocalisations) {
        if (empty($idLocalisations)) {
            return []; // Retourner un tableau vide si aucun ID n'est fourni
        }
    
        // Création de placeholders sécurisés (:id1, :id2, etc.)
        $placeholders = implode(',', array_map(fn($key) => ":id$key", array_keys($idLocalisations)));
    
        $sql = "SELECT 
                ic.*, 
                l.idLocalisation AS idLocalisation, l.idGroupe, l.identifiant, l.adresse , l.idVille, l.idDepartement, l.taille,
                v.ville, v.codePostal,
                d.departement, d.idRegion,
                r.region,
                c.idContact, c.nom, c.email, c.telephone, c.contact
            FROM interetCreche ic
            JOIN localisations l ON ic.idLocalisation = l.idLocalisation
            JOIN villes v ON l.idVille = v.idVille
            JOIN departements d ON l.idDepartement = d.idDepartement
            JOIN regions r ON d.idRegion = r.idRegion
            JOIN contacts c ON ic.idContact = c.idContact
            WHERE ic.idLocalisation IN ($placeholders);
        ";
    
        // Associer chaque valeur aux placeholders
        $params = [];
        foreach ($idLocalisations as $key => $id) {
            $params[":id$key"] = (int) $id; // Sécurisation en entier
        }
        
        // Exécuter la requête
        $result = $this->db->query($sql, $params);

        $interetsCreche = [];
        $niveauCounts = [
            'Achat réalisé' => 0,
            'Dossier envoyé' => 0,
            'NDA envoyé' => 0,
            'Intéressé' => 0,
            'Sous-offre'=> 0
        ];

        while ($row = $result->fetch()) {
            // Clé unique basée sur l'ID de localisation
            $key = $row['idLocalisation'];

            // Vérifier si on a déjà créé un objet pour cette localisation
            if (!isset($interetsCreche[$key])) {
                $interetsCreche[$key] = new InteretCreche([
                    'idInteretCreche'=> $row['idInteretCreche'],
                    'idContact'=> $row['idContact'],
                    'idLocalisation'=> $row['idLocalisation'],
                    'dateColonne'=> $row['date_colonne'],
                    'niveau'=> $row['niveau'],
                    'localisation'=> new Localisation([
                        'adresse'=> $row['adresse'],
                        'identifiant'=> $row['identifiant'],
                        'idGroupe'=> $row['idGroupe'],
                        'taille'=> $row['taille'],
                        'idVille'=> $row['idVille'],
                        'idDepartement'=> $row['idDepartement'],
                    ]),
                    'ville' => new Ville([
                        'ville' => $row['ville'],
                        'codePostal' => $row['codePostal']
                    ]),
                    'departement' => new Departement([
                        'departement' => $row['departement'],
                        'idRegion' => $row['idRegion'],
                    ]),
                    'region' => new Region([
                        'region' => $row['region']
                    ])
                ]);
            }
            
            // Ajouter le contact à l'objet existant avec le niveau d'intérêt
            $interetsCreche[$key]->ajouterContact(new Contact([
                'idContact' => $row['idContact'],
                'contact'   => $row['contact'],
                'nom'       => $row['nom'],
                'niveau'    => $row['niveau'], // Associer le niveau à chaque contact
            ]));

             // Mise à jour des statistiques de niveaux
            if (isset($niveauCounts[$row['niveau']])) {
            $niveauCounts[$row['niveau']]++;
            }
        }

        // Retourner un tableau contenant uniquement les objets InteretCreche
        
        return [
            'interetsCreche' => array_values($interetsCreche), // Pour avoir un tableau indexé propre
            'niveauCounts' => $niveauCounts
        ];
    }

        //Fonction qui récupère les contacts par niveau d'intérêt
    public function getContactsByNiveau($niveau)
{

    $niveauMapping = [
        'interesses' => 'Intéressé',
        'nda_envoyes' => 'NDA envoyé',
        'dossiers_envoyes' => 'Dossier envoyé',
        'sous_offres' => 'Sous-offre',
        'achat_realise' => 'Achat réalisé'
    ];
    
    // Vérifier si la clé existe dans le mapping
    $niveauEnBase = $niveauMapping[$niveau] ?? null;

    if ($niveauEnBase === null) {
        throw new Exception("Le niveau fourni est invalide : " . $niveau);
    }

    $sql = "SELECT ic.idContact, ic.idLocalisation, ic.date_colonne, ic.niveau,
    c.contact, c.nom, c.email, c.telephone,
    l.idDepartement, l.taille, l.identifiant,
    d.departement, d.idRegion,
    r.region
    FROM interetCreche ic
    JOIN contacts c ON ic.idContact = c.idContact
    JOIN localisations l ON ic.idLocalisation = l.idLocalisation
    JOIN departements d ON l.idDepartement = d.idDepartement
    JOIN regions r ON d.idRegion = r.idRegion
    WHERE ic.niveau = :niveau";

    $query = $this->db->query($sql, ['niveau' => $niveauEnBase]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $contacts = [];

    foreach ($result as $row) {
        $idContact = $row['idContact'];

        // Vérifier si l'objet Contact existe déjà dans le tableau
        if (!isset($contacts[$idContact])) {
            $contacts[$idContact] = new Contact([
                'idContact'=> $row['idContact'],
                'contact'=> $row['contact'],
                'nom'=> $row['nom'],
                'email'=> $row['email'],
                'telephone'=> $row['telephone']
            ]);
        }

        // Créer une nouvelle Localisation
        $localisation = new Localisation([
            'idLocalisation'=> $row['idLocalisation'],
            'date_colonne'=> $row['date_colonne'],
            'niveau'=> $row['niveau'],
            'idDepartement'=> $row['idDepartement'],
            'taille'=> $row['taille'],
            'identifiant'=> $row['identifiant'],
            'departement'=> $row['departement'],
            'idRegion'=> $row['idRegion'],
            'region'=> $row['region']
        ]);

        // Ajouter la localisation à l'objet Contact
        $contacts[$idContact]->ajouterLocalisation($localisation);
    }

    return array_values($contacts); // Pour réindexer le tableau et obtenir un array normal
    }

}