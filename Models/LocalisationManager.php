<?php

include_once('AbstractEntityManager.php');

class LocalisationManager extends AbstractEntityManager{
    public $db;

    //Récupérer toutes les localisations
    function getLocalisations(){
        $sql = "SELECT 
                l.idLocalisation, l.idContact, l.identifiant, l.adresse, l.taille, l.idDepartement, 
                d.departement, 
                r.idRegion, r.region
                FROM localisations l
                JOIN departements d ON l.idDepartement = d.idDepartement
                JOIN regions r ON d.idRegion = r.idRegion";

        $result = $this -> db -> query($sql);

        // Initialiser le tableau d'objets Identifiant
        $localisations = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Création de l'objet Localisation
            $localisation = new Localisation();
            $localisation->setIdentifiant($row['identifiant']);
            $localisation->setIdLocalisation($row['idLocalisation']);
            $localisation->setAdresse($row['adresse']);
            $localisation->setIdContact($row['idContact']);
            $localisation->setTaille($row['taille']);
        
            // Création de l'objet Département
            $departement = new Departement();
            $departement->setIdDepartement($row['idDepartement']);
            $departement->setDepartement($row['departement']);
        
            // Création de l'objet Région
            $region = new Region();
            $region->setIdRegion($row['idRegion']);
            $region->setRegion($row['region']);
        
            // Associer Département et Région à la Localisation
            $localisation->setDepartement($departement);
            $localisation->setRegion($region);
        
            // Ajouter à la liste des localisations
            $localisations[] = $localisation;
        }
        
        return $localisations; // Retourne un tableau d'objets Localisation
    }
    
    //Récupére l'id d'un identifiant
    public function getIdLocalisationByIdentifiant($identifiant) {
        $sql = "SELECT idLocalisation FROM localisations WHERE identifiant = :identifiant LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['identifiant' => $identifiant]);
        return $stmt->fetchColumn();  // Retourne l'ID de la localisation
    }

    //Créer une adresse à partir du code postal, de la ville et de l'adresse
    public function createAddress($adresse, $codePostal, $ville) {
        // Vérifier si les paramètres ne sont pas vides
        if (empty($adresse) || empty($codePostal) || empty($ville)) {
            return false;
        }
    
        if (is_array($adresse)) {
            $adresse = implode(' ', $adresse); // Convertit le tableau en string
        }
        
        if (is_array($codePostal)) {
            $codePostal = implode(' ', $codePostal);
        }
        
        $codePostal = trim($codePostal);

        if (is_array($ville)) {
            $ville = implode(' ', $ville);
        }
        $ville = trim($ville);
    
        // Construire l'adresse complète
        $result = "$adresse, $codePostal, $ville";
    
        return $result;
    }

    //Récupérer les coordonnées géographiques d'une adresse
    public function geocodeAdresse($adresse) {

        $geocoder = new \OpenCage\Geocoder\Geocoder('e42f639a17dc40eebffcb9283aa34afe');
        try {
            $result = $geocoder->geocode($adresse . ", France", ['language' => 'fr', 'countrycode' => 'fr']);
        } catch (\Exception $e) {
            echo "Erreur lors de la géolocalisation : " . $e->getMessage();
            return false;
        }
    
         // Pas besoin de json_decode ici, car $result est déjà un tableau
        if (!empty($result['results'])) {
            $latitude = $result['results'][0]['geometry']['lat'];
            $longitude = $result['results'][0]['geometry']['lng'];

            return ['lat' => $latitude, 'lng' => $longitude];
        } else {
            return false; // Adresse introuvable
        }
    }

    public function getLocation($idLocalisation) {
        $sql = 'SELECT ST_X(location) AS lat, ST_Y(location) AS lng FROM localisations WHERE idLocalisation = :idLocalisation';
        return $this->db->query($sql, ['idLocalisation' => $idLocalisation])->fetch();
    }
    
    public function insertLocation($idLocalisation, $latitude, $longitude) {
        // Correction de la requête SQL en utilisant les paramètres correctement dans ST_GeomFromText
        $sql = "UPDATE localisations 
                SET location = ST_GeomFromText(:point)
                WHERE idLocalisation = :idLocalisation";
        
        // Construire le point géospatial sous forme de chaîne WKT
        $point = "POINT($longitude $latitude)";
        
        // Paramètres à passer à la requête
        $params = [
            ':point' => $point,               // Point en format WKT
            ':idLocalisation' => $idLocalisation // L'ID de la localisation à mettre à jour
        ];
        
        // Exécution de la requête avec la méthode query
        $query = $this->db->query($sql, $params);
        
        // Retourne true si la requête a réussi, sinon false
        return $query !== false;
    }
    
    //Récupérer tous les points lat et lng
    public function getPoints() {
        try {
            $sql = "SELECT l.identifiant, ST_X(l.location) AS lng, ST_Y(l.location) AS lat, c.sens 
            FROM localisations l
            JOIN contacts c ON l.idContact = c.idContact";

            $query = $this->db->query($sql);
            return $query->fetchAll(); // Retourne le résultat sous forme de tableau associatif
        } catch (PDOException $e) {
            return ["error" => "Erreur SQL : " . $e->getMessage()];
        }
    }
    
    public function getContactsByIdVille($idVille): array
    {
        $sql = 'SELECT c.idContact
                FROM localisations l
                JOIN contacts c ON l.idContact = c.idContact
                WHERE l.idVille = :idVille';
    
        $stmt = $this->db->query($sql, [':idVille' => $idVille]);
    
        // Récupérer les résultats sous forme de tableau d'ID
        $idContacts = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
        return $idContacts; // Retourne un tableau contenant uniquement les idContact
    }

    public function getContactsByIdDepartement($idDepartement): array
    {
        $sql = 'SELECT c.idContact
                FROM localisations l
                JOIN contacts c ON l.idContact = c.idContact
                WHERE l.idDepartement = :idDepartement';
    
        $stmt = $this->db->query($sql, [':idDepartement' => $idDepartement]);
    
        // Récupérer les résultats sous forme de tableau d'ID
        $idContacts = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
        return $idContacts; // Retourne un tableau contenant uniquement les idContact
    }
    
    public function getLocalisationIdByIdentifiant($identifiant) {
        $sql = "SELECT idLocalisation FROM localisations WHERE identifiant = :identifiant LIMIT 1";
        
        $stmt = $this->db->prepare($sql);  // 🔹 Préparer la requête
        $stmt->execute([':identifiant' => $identifiant]);  // 🔹 Exécuter avec le paramètre
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // 🔹 Récupérer la ligne au lieu de l'objet
    
        return $result ? $result['idLocalisation'] : null; // 🔹 Retourner l'ID ou null
    }

    //Récupére l'id d'une adresse
    public function getIdLocalisationByAdresse(array $adresses) {
        if (empty($adresses)) {
            return []; // Retourne un tableau vide si aucune adresse n'est fournie
        }
        // Création des placeholders dynamiques pour le `IN (...)`
        $placeholders = implode(', ', array_fill(0, count($adresses), '?'));
    
        $sql = "SELECT idLocalisation FROM localisations WHERE adresse IN ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($adresses);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return array_column($results, 'idLocalisation');
    }

    public function countCreches($idContact){
        if (empty($idContact)) {
            return 0; // Si l'idContact est vide, on retourne 0
        }
    
        // Requête SQL pour compter les crèches à vendre pour un seul idContact
        $sql = "SELECT COUNT(*) FROM localisations WHERE idContact = :idContact";
    
        // Appel à la méthode du dbManager qui se charge de préparer et exécuter la requête
        $result = $this->db->query($sql, [':idContact' => $idContact]);

    
        // Si le résultat est valide, retourner l'entier (COUNT(*))
        $nombreCreches = (int) $result->fetchColumn();

        return $nombreCreches;
    }
    

    public function getIdContactByLocalisations() {
        $sql = "SELECT idContact FROM localisations";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_COLUMN); // Retourne un tableau d'idContact
    }

    // Insère la localisation avec les ID ville et département
    public function insertLocalisation(Localisation $localisation) {
        // Vérifier si l'identifiant existe déjà
        $sqlCheck = 'SELECT COUNT(*) FROM localisations WHERE identifiant = :identifiant';
        $stmt = $this->db->query($sqlCheck, ['identifiant' => $localisation->getIdentifiant()]);
        $exists = $stmt->fetchColumn();
    
        if ($exists > 0) {
            return; // Évite l'insertion d'un doublon
        }
    
        // Insérer si l'identifiant n'existe pas encore
        $sql = 'INSERT INTO localisations (idContact, idVille, adresse, idDepartement, identifiant, taille, idGroupe) 
                VALUES (:idContact, :idVille, :adresse, :idDepartement, :identifiant, :taille, :idGroupe)';
    
        $this->db->query($sql, [
            'idContact' => $localisation->getIdContact(),
            'idVille' => $localisation->getIdVille(),
            'adresse' => $localisation->getAdresse(),
            'idDepartement' => $localisation->getIdDepartement(),
            'identifiant' => $localisation->getIdentifiant(),
            'taille' => $localisation->getTaille(),
            'idGroupe'=>$localisation->getIdGroupe()
        ]);
    
        return $this->db->lastInsertId();
    }

    public function getLocalisationsByIdContact($idContact) {
    
        $sql = "SELECT l.idLocalisation, l.identifiant, l.adresse, 
            v.idVille, v.ville, 
            d.idDepartement, d.departement, 
            r.idRegion, r.region  
        FROM localisations l
        JOIN villes v ON l.idVille = v.idVille
        JOIN departements d ON l.idDepartement = d.idDepartement
        JOIN regions r ON d.idRegion = r.idRegion
        WHERE l.idContact = :idContact";
        
        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $localisations = [];
        foreach ($result as $row) {
            // Création des objets Ville et Departement
            $ville = new Ville([
                'idVille' => $row['idVille'],
                'ville' => $row['ville']
            ]);

            $departement = new Departement([
                'idDepartement' => $row['idDepartement'],
                'idRegion' => $row['idRegion'],
                'departement' => $row['departement']
            ]);

            $region = new Region([
                'idRegion' => $row['idRegion'],
                'region' => $row['region']
            ]);

            // Création de l'objet Localisation avec idLocalisation
            $localisation = new Localisation([
                'idLocalisation' => (int) $row['idLocalisation'],
                "identifiant" => $row['identifiant'],
                'adresse' => $row['adresse'],
            ]);
            $localisation->setVille($ville);
            $localisation->setDepartement($departement);
            $localisation->setRegion($region);

            $localisations[] = $localisation;
        }
        
        return $localisations;
    }

    public function getLocalisationsAVendre($idContact): array {
        // Requête pour récupérer uniquement les données de la table localisations
        $sql = "SELECT * 
                FROM localisations
                WHERE idContact = :idContact";
        
        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Initialisation du tableau des localisations
        $localisationsAVendre = [];
        
        // Créer des objets Localisation à partir des résultats
        foreach ($result as $row) {
            $localisation = new Localisation($row);  // Créer un objet Localisation
    
            // Ajouter l'objet Localisation au tableau final
            $localisationsAVendre[] = $localisation;
        }
    
        return $localisationsAVendre;
    }
    
    public function getLocalisationsInRayon($coords, $rayon) {
        // Vérification des paramètres
        if (empty($coords['lng']) || empty($coords['lat']) || empty($rayon)) {
            throw new Exception("Les coordonnées et le rayon doivent être définis.");
        }
        
        // Construire la requête SQL
        $sql = "SELECT 
        l.idLocalisation, l.idContact, l.identifiant,l.adresse, l.taille, l.idDepartement, 
        d.departement, 
        r.idRegion, r.region,
        ST_Distance_Sphere(location, POINT(?, ?)) / 1000 AS distance_km
        FROM localisations l
        JOIN departements d ON l.idDepartement = d.idDepartement
        JOIN regions r ON d.idRegion = r.idRegion
        WHERE ST_Distance_Sphere(location, POINT(?, ?)) / 1000 <= ?";

        // Passer la requête SQL au DBManager qui s'occupe de la préparation et de l'exécution
        $result = $this->db->query($sql, [
            $coords['lng'],  // Longitude du point
            $coords['lat'],  // Latitude du point
            $coords['lng'],  // Longitude du point (pour le calcul de distance)
            $coords['lat'],  // Latitude du point (pour le calcul de distance)
            $rayon           // Rayon en kilomètres
        ]);
    
        // Vérifier si on a bien récupéré des résultats sous forme de tableau
        if (!$result) {
            throw new Exception("Aucun résultat trouvé.");
        }
    
        // Stocker les identifiants sous forme d'objets Localisation
        $localisations = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Création de l'objet Localisation
            $localisation = new Localisation();
            $localisation->setIdentifiant($row['identifiant']);
            $localisation->setIdLocalisation($row['idLocalisation']);
            $localisation->setAdresse($row['adresse']);
            $localisation->setIdContact($row['idContact']);
            $localisation->setTaille($row['taille']);
        
            // Création de l'objet Département
            $departement = new Departement();
            $departement->setIdDepartement($row['idDepartement']);
            $departement->setDepartement($row['departement']);
        
            // Création de l'objet Région
            $region = new Region();
            $region->setIdRegion($row['idRegion']);
            $region->setRegion($row['region']);
        
            // Associer Département et Région à la Localisation
            $localisation->setDepartement($departement);
            $localisation->setRegion($region);
        
            // Ajouter à la liste des localisations
            $localisations[] = $localisation;
        }
        
        return $localisations; // Retourne un tableau d'objets Localisation
    }        

    public function getIdContactByIdDepartement(array $idDepartements) {
        if (empty($idDepartements)) {
            return [];
        }
        // Générer les placeholders dynamiquement (ex: ":id1, :id2, :id3")
        $placeholders = implode(',', array_map(fn($key) => ":id$key", array_keys($idDepartements)));
    
        $sql = "SELECT idContact FROM localisations WHERE idDepartement IN ($placeholders)";
    
        // Associer chaque département à un paramètre nommé (ex: [":id0" => 1, ":id1" => 2, ":id2" => 3])
        $params = [];
        foreach ($idDepartements as $key => $id) {
            $params[":id$key"] = $id;
        }
    
        $result = $this->db->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_COLUMN); // Retourne un tableau d'idContact
    }

    public function countCrechesAVendre($idClients){
        if (empty($idClients)) {
            return 0; // Si la liste est vide, on retourne 0
        }
    
        // Construction d'une chaîne de placeholders "?, ?, ?" pour une requête préparée
        $placeholders = implode(',', array_fill(0, count($idClients), '?'));
        $sql = "SELECT COUNT(*) FROM localisations WHERE idContact IN ($placeholders)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute($idClients);
    
        return $stmt->fetchColumn(); 
    }
    public function getLocalisationsByVendeurAndRegion(array $idVendeurs, array $idDepartementList): array {
        // Vérifier si on a des objets ou déjà des ID
        if (!empty($idDepartementList) && is_object(reset($idDepartementList))) {
            $idDepartementArray = array_map(fn($dep) => $dep->getIdDepartement(), $idDepartementList);
        } else {
            $idDepartementArray = $idDepartementList;
        }

        // Vérifier que les listes ne sont pas vides
        if (empty($idVendeurs) || empty($idDepartementArray)) {
            return [];
        }

        // Création des placeholders dynamiques pour la requête SQL
        $placeholdersVendeurs = implode(',', array_fill(0, count($idVendeurs), '?'));
        $placeholdersDepartements = implode(',', array_fill(0, count($idDepartementArray), '?'));

        // Requête SQL pour récupérer la colonne identifiant
        $sql = "SELECT 
                l.idLocalisation, l.idContact, l.identifiant, l.adresse, l.taille, l.idDepartement, 
                d.departement, 
                r.idRegion, r.region
                FROM localisations l
                JOIN departements d ON l.idDepartement = d.idDepartement
                JOIN regions r ON d.idRegion = r.idRegion
                WHERE l.idContact IN ($placeholdersVendeurs) 
                AND l.idDepartement IN ($placeholdersDepartements)";

        // Fusionner les valeurs à injecter
        $params = array_merge($idVendeurs, $idDepartementArray);
        
        $result = $this->db->query($sql, $params);

        // Initialiser le tableau d'objets Identifiant
        $localisations = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Création de l'objet Localisation
            $localisation = new Localisation();
            $localisation->setIdentifiant($row['identifiant']);
            $localisation->setIdLocalisation($row['idLocalisation']);
            $localisation->setAdresse($row['adresse']);
            $localisation->setIdContact($row['idContact']);
            $localisation->setTaille($row['taille']);
        
            // Création de l'objet Département
            $departement = new Departement();
            $departement->setIdDepartement($row['idDepartement']);
            $departement->setDepartement($row['departement']);
        
            // Création de l'objet Région
            $region = new Region();
            $region->setIdRegion($row['idRegion']);
            $region->setRegion($row['region']);
        
            // Associer Département et Région à la Localisation
            $localisation->setDepartement($departement);
            $localisation->setRegion($region);
        
            // Ajouter à la liste des localisations
            $localisations[] = $localisation;
        }
        
        return $localisations; // Retourne un tableau d'objets Localisation
    }

    public function getLocalisationsByVendeurAndDepartement(array $idContacts, array $idDepartements): array
{
    if (empty($idContacts) || empty($idDepartements)) {
        return []; // Retourne un tableau vide si aucun contact vendeur ou département
    }

    // Création des placeholders pour la requête IN (?, ?, ?)
    $placeholdersContacts = implode(',', array_fill(0, count($idContacts), '?'));
    $placeholdersDepartements = implode(',', array_fill(0, count($idDepartements), '?'));

    $sql = "SELECT 
        l.idLocalisation, l.idContact, l.identifiant, l.adresse, l.taille, l.idDepartement, 
        d.departement, 
        r.idRegion, r.region
        FROM localisations l
        JOIN departements d ON l.idDepartement = d.idDepartement
        JOIN regions r ON d.idRegion = r.idRegion
        WHERE l.idContact IN ($placeholdersContacts) 
        AND l.idDepartement IN ($placeholdersDepartements)";

        // Fusionner les paramètres pour correspondre aux placeholders
        $params = array_merge($idContacts, $idDepartements);
        
        $result = $this->db->query($sql, $params);

        // Stocker les localisations sous forme d'objets
        $localisations = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Création de l'objet Localisation
            $localisation = new Localisation();
            $localisation->setIdentifiant($row['identifiant']);
            $localisation->setIdLocalisation($row['idLocalisation']);
            $localisation->setAdresse($row['adresse']);
            $localisation->setIdContact($row['idContact']);
            $localisation->setTaille($row['taille']);
        
            // Création de l'objet Département
            $departement = new Departement();
            $departement->setIdDepartement($row['idDepartement']);
            $departement->setDepartement($row['departement']);
        
            // Création de l'objet Région
            $region = new Region();
            $region->setIdRegion($row['idRegion']);
            $region->setRegion($row['region']);
        
            // Associer Département et Région à la Localisation
            $localisation->setDepartement($departement);
            $localisation->setRegion($region);
        
            // Ajouter à la liste des localisations
            $localisations[] = $localisation;
        }
        
        return $localisations; // Retourne un tableau d'objets Localisation
    }

    public function getLocalisationsByVendeurs(array $idVendeurs): array
    {
    if (empty($idVendeurs)) {
        return []; // Retourne un tableau vide si aucun contact vendeur ou département
    }

    // Création des placeholders pour la requête IN (?, ?, ?)
    $placeholdersVendeurs = implode(',', array_fill(0, count($idVendeurs), '?'));

    $sql = "SELECT 
        l.idLocalisation, l.idContact, l.identifiant, l.adresse, l.taille, l.idDepartement, 
        d.departement, 
        r.idRegion, r.region
        FROM localisations l
        JOIN departements d ON l.idDepartement = d.idDepartement
        JOIN regions r ON d.idRegion = r.idRegion
        WHERE l.idContact IN ($placeholdersVendeurs) ";

        // Fusionner les paramètres pour correspondre aux placeholders
        $params = array_merge($idVendeurs);
        
        $result = $this->db->query($sql, $params);

        // Stocker les localisations sous forme d'objets
        $localisations = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Création de l'objet Localisation
            $localisation = new Localisation();
            $localisation->setIdentifiant($row['identifiant']);
            $localisation->setIdLocalisation($row['idLocalisation']);
            $localisation->setAdresse($row['adresse']);
            $localisation->setIdContact($row['idContact']);
            $localisation->setTaille($row['taille']);
        
            // Création de l'objet Département
            $departement = new Departement();
            $departement->setIdDepartement($row['idDepartement']);
            $departement->setDepartement($row['departement']);
        
            // Création de l'objet Région
            $region = new Region();
            $region->setIdRegion($row['idRegion']);
            $region->setRegion($row['region']);
        
            // Associer Département et Région à la Localisation
            $localisation->setDepartement($departement);
            $localisation->setRegion($region);
        
            // Ajouter à la liste des localisations
            $localisations[] = $localisation;
        }
        
        return $localisations; // Retourne un tableau d'objets Localisation
    }
}    
    
    
    



    






