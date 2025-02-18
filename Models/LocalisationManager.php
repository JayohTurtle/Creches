<?php

include_once('AbstractEntityManager.php');

class LocalisationManager extends AbstractEntityManager{
    public $db;

    //Récupérer toutes les localisations
    function getLocalisations(){
        $request = "select * from localisations";
        $statement = $this -> db -> query($request);

        $localisationList=[];
        while ($localisation = $statement -> fetch()){
            $localisationList[] = new Localisation ($localisation);
        }
        return $localisationList;
    }

    // Insère la localisation avec les ID ville et département
    public function insertLocalisation($idContact, $idVille, $adresse, $idDepartement, $identifiant, $taille) {
        // Vérifier si l'identifiant existe déjà
        
        $sqlCheck = 'SELECT COUNT(*) FROM localisations WHERE identifiant = :identifiant';
        $stmt = $this->db->query($sqlCheck, ['identifiant' => $identifiant]);
        $exists = $stmt->fetchColumn();
    
        if ($exists > 0) {
            return; // Évite l'insertion d'un doublon
        }
        
        // Insérer si l'identifiant n'existe pas encore
        $sql = 'INSERT INTO localisations (idContact, idVille, adresse, idDepartement, identifiant, taille) 
                VALUES (:idContact, :idVille, :adresse, :idDepartement, :identifiant, :taille)';
        
        $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVille,
            'adresse' => $adresse,
            'idDepartement' => $idDepartement,
            'identifiant' => $identifiant,
            'taille' => $taille
        ]);

        $idLocalisation = $this->db->lastInsertId();
        return $idLocalisation;

    }

    //Récupére l'id d'un identifiant
    public function getIdLocalisationByIdentifiant($identifiant) {
        $sql = "SELECT idLocalisation FROM localisations WHERE identifiant = :identifiant LIMIT 1";
        $stmt = $this->db->prepare($sql);  // Prépare la requête SQL
        $stmt->execute(['identifiant' => $identifiant]);  // Exécute avec la valeur de l'identifiant
        return $stmt->fetchColumn();  // Retourne l'ID de la localisation
    }

    //Créer une adresse à partir du code postal, de la ville et de l'adresse
    public function createAddress($codePostal, $ville, $adresse) {
        // Vérifier si les paramètres ne sont pas vides
        if (empty($adresse) || empty($codePostal) || empty($ville)) {
            return false; // Ou lancer une exception
        }
    
        // Nettoyer les espaces inutiles
        if (is_array($adresse)) {
            $adresse = implode(' ', $adresse); // Convertit le tableau en string
        }
        
        $adresse = trim($adresse);
        
        if (is_array($codePostal)) {
            $codePostal = implode(' ', $codePostal); // Convertit le tableau en string
        }
        
        $codePostal = trim($codePostal);

        if (is_array($ville)) {
            $ville = implode(' ', $ville); // Convertit le tableau en string
        }
        $ville = trim($ville);
    
        // Construire l'adresse complète
        $result = "$adresse, $codePostal $ville";
    
        return $result;
    }

    //Récupérer les coordonnées géographiques d'une adresse
    public function geocodeAdresse($adresse) {
        $apiKey = "e42f639a17dc40eebffcb9283aa34afe"; // Remplace par ta clé API OpenCage
        $adresse = urlencode($adresse);
        $url = "https://api.opencagedata.com/geocode/v1/json?q=$adresse&key=$apiKey";
    
        // Initialisation de cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "YouInvestCreche/1.0"); // Obligatoire pour OpenCage
    
        // Exécuter la requête et récupérer la réponse
        $response = curl_exec($ch);
        curl_close($ch);
    
        $data = json_decode($response, true);
    
        if (!empty($data['results'])) {
            $latitude = $data['results'][0]['geometry']['lat'];
            $longitude = $data['results'][0]['geometry']['lng'];
            return ['lat' => $latitude, 'lng' => $longitude];
        } else {
            return false; // Adresse introuvable
        }
    }

    public function getLocation($idLocalisation) {
        $sql = 'SELECT ST_X(location) AS lat, ST_Y(location) AS lng FROM localisations WHERE idLocalisation = :idLocalisation';
        return $this->db->query($sql, ['idLocalisation' => $idLocalisation])->fetch();
    }
    
    //Insérer les points lat et lng dans la base de données
    public function insertLocation($idLocalisation, $lat, $lng) {
        echo "insertLocation appelée avec : ID = $idLocalisation, LAT = $lat, LNG = $lng<br>";
    
        $sql = 'UPDATE localisations SET location = ST_GeomFromText(:point) WHERE idLocalisation = :idLocalisation';
        
        $point = "POINT($lng $lat)"; // Longitude en premier
    
        return $this->db->query($sql, [
            'idLocalisation' => $idLocalisation,
            'point' => $point
        ]);
    }

    //Récupérer tous les points lat et lng
    public function getPoints() {
        try {
            $sql = "SELECT l.identifiant, ST_X(l.location) AS lat, ST_Y(l.location) AS lng, c.sens 
            FROM localisations l
            JOIN contacts c ON l.idContact = c.idContact";

            $query = $this->db->query($sql);
            return $query->fetchAll(); // Retourne le résultat sous forme de tableau associatif
        } catch (PDOException $e) {
            return ["error" => "Erreur SQL : " . $e->getMessage()];
        }
    }
     //Récupérer les localisations d'un contact
     public function getLocalisationByContact($idContact) {
        try {
            $sql = "SELECT l.adresse, v.idVille, v.ville, d.idDepartement, d.departement 
                    FROM localisations l
                    JOIN villes v ON l.idVille = v.idVille
                    JOIN departements d ON l.idDepartement = d.idDepartement
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
                    'departement' => $row['departement']
                ]);
    
                // Création de l'objet Localisation
                $localisation = new Localisation([
                    'adresse' => $row['adresse'],
                ]);
                $localisation->setVille($ville);
                $localisation->setDepartement($departement);
    
                $localisations[] = $localisation;
            }
    
            return $localisations; // ✅ Retourne des objets avec Ville et Departement
    
        } catch (PDOException $e) {
            return ["error" => "Erreur SQL : " . $e->getMessage()];
        }
    } 
}
    






