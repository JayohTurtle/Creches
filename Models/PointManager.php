<?php

include_once('AbstractEntityManager.php');

class PointManager extends AbstractEntityManager {
    public $db;

    public function purgeLocation() {
        echo "🗑️ Début de purgeLocation()<br>";
    
        $sql = "UPDATE localisations SET location = ST_GeomFromText('POINT(0 0)')";
        $this->db->query($sql);
    
        echo "✅ Colonne `location` purgée.<br>";
    }
    

    // Récupérer toutes les adresses à mettre à jour
    public function getAllAddresses() {
        $sql = "SELECT l.idLocalisation, l.adresse, v.codePostal, v.ville AS ville
                FROM localisations l
                JOIN villes v ON l.idVille = v.idVille";
        return $this->db->query($sql)->fetchAll();
    }

    // Construire une adresse complète
    public function createAddress($codePostal, $ville, $adresse) {
        return trim("$adresse, $codePostal $ville");
    }

    // Géocoder une adresse via OpenCage
    public function geocodeAdresse($adresse) {
        var_dump('on appelle lAPI');
        $apiKey = "e42f639a17dc40eebffcb9283aa34afe"; // Remplace avec ta clé API
        $adresse = urlencode($adresse);
        $url = "https://api.opencagedata.com/geocode/v1/json?q=$adresse&key=$apiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "YouInvestCreche/1.0");

        $response = curl_exec($ch);
        if ($response === false) {
            echo "cURL Error: " . curl_error($ch);
        }
        
        var_dump($response);
        curl_close($ch);

        $data = json_decode($response, true);
        var_dump($data);

        if (!empty($data['results'])) {
            return [
                'lat' => $data['results'][0]['geometry']['lat'],
                'lng' => $data['results'][0]['geometry']['lng']
            ];
        }
        return false;
    }

    // Mettre à jour la colonne location avec les coordonnées
    public function insertLocation($idLocalisation, $lat, $lng) {
        $sql = "UPDATE localisations SET location = ST_GeomFromText(:point) WHERE idLocalisation = :idLocalisation";
        $point = "POINT($lng $lat)"; // Longitude en premier

        $this->db->query($sql, [
            'idLocalisation' => $idLocalisation,
            'point' => $point
        ]);
    }

    // Script principal pour purger et mettre à jour toutes les localisations
    public function updateAllLocations() {

        $this->purgeLocation();
        $addresses = $this->getAllAddresses();

        foreach ($addresses as $row) {
            $fullAddress = $this->createAddress($row['codePostal'], $row['ville'], $row['adresse']);
            echo "📍 Géocodage de : $fullAddress\n";

            $coords = $this->geocodeAdresse($fullAddress);
            if ($coords) {
                $this->insertLocation($row['idLocalisation'], $coords['lat'], $coords['lng']);
                echo "✅ Localisation mise à jour pour ID " . $row['idLocalisation'] . " : " . $coords['lat'] . ", " . $coords['lng'] . "\n";
            } else {
                echo "❌ Échec du géocodage pour : $fullAddress\n";
            }
        }
    }


         // Récupérer toutes les villes avec leurs codes postaux
    public function getAllCities() {
        $sql = "SELECT idVille, ville, codePostal FROM villes";
        return $this->db->query($sql)->fetchAll();
    }

    // Géocoder une ville et son code postal via OpenCage
    public function geocodeCity($city, $postalCode) {
        $apiKey = "e42f639a17dc40eebffcb9283aa34afe"; // Remplace avec ta clé API
        $address = urlencode("$city, $postalCode");
        $url = "https://api.opencagedata.com/geocode/v1/json?q=$address&key=$apiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "YouInvestCreche/1.0");

        $response = curl_exec($ch);

        curl_close($ch);
        
        $data = json_decode($response, true);

        if (!empty($data['results'])) {
            return [
                'lat' => $data['results'][0]['geometry']['lat'],
                'lng' => $data['results'][0]['geometry']['lng']
            ];
        }
        return false;
    }

    // Mettre à jour la colonne location avec les coordonnées
    public function insertLocationVille($idVille, $lat, $lng) {
        $sql = "UPDATE villes SET location = ST_GeomFromText(:point) WHERE idVille = :idVille";
        $point = "POINT($lng $lat)"; // Longitude en premier

        $this->db->query($sql, [
            'idVille' => $idVille,
            'point' => $point
        ]);
    }

    // Script principal pour mettre à jour toutes les villes avec leur code postal
    public function updateAllCitiesLocations() {
        $this->purgeLocationVille();
        $cities = $this->getAllCities();

        foreach ($cities as $row) {
            $cityName = $row['ville'];
            $postalCode = $row['codePostal'];
            echo "📍 Géocodage de : $cityName, $postalCode\n";

            $coords = $this->geocodeCity($cityName, $postalCode);
            if ($coords) {
                $this->insertLocationVille($row['idVille'], $coords['lat'], $coords['lng']);
                echo "✅ Localisation mise à jour pour ID " . $row['idVille'] . " : " . $coords['lat'] . ", " . $coords['lng'] . "\n";
            } else {
                echo "❌ Échec du géocodage pour : $cityName, $postalCode\n";
            }
        }
    }

    public function purgeLocationVille() {
        echo "🗑️ Début de purgeLocation()<br>";
    
        $sql = "UPDATE villes SET location = ST_GeomFromText('POINT(0 0)')";
        $this->db->query($sql);
    
        echo "✅ Colonne `location` purgée.<br>";
    }
    }
    


?>