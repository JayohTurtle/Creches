<?php

include_once('AbstractEntityManager.php');

class VilleManager extends AbstractEntityManager{

    public function insertVilleIfNotExists($ville, $codePostal, $idDepartement) {
        $sql = 'SELECT idVille FROM villes WHERE ville = :ville AND codePostal = :codePostal AND idDepartement = :idDepartement';
        $idVille = (int) $this->db->query($sql, [
            'ville' => $ville, 
            'codePostal' => $codePostal, 
            'idDepartement' => $idDepartement
        ])->fetchColumn();
        
        if (!$idVille) {
            $sql = 'INSERT INTO villes (ville, codePostal, idDepartement) VALUES (:ville, :codePostal, :idDepartement)';
            $this->db->query($sql, [
                'ville' => $ville, 
                'codePostal' => $codePostal, 
                'idDepartement' => $idDepartement
            ]);
            $idVille = (int) $this->db->lastInsertId();
            
            // Géocodage
            $coords = $this->geocodeCity($ville, $codePostal);
            
            if ($coords) {
                $this->insertLocationVille($idVille, $coords['lat'], $coords['lng']);
            } else {
                echo "❌ Échec du géocodage pour : $ville ($codePostal)";
            }
        }
        return $idVille;
    }

    // Géocoder une ville et son code postal via OpenCage
    public function geocodeCity($ville, $codePostal) {
        $apiKey = "e42f639a17dc40eebffcb9283aa34afe"; // Remplace avec ta clé API
        $address = urlencode("$ville, $codePostal");
        $queryParams = http_build_query([
            'q' => $address,
            'key' => $apiKey,
            'limit' => 1, // Limite à un seul résultat
            'no_annotations' => 1, // Désactive les annotations inutiles
            'language' => 'fr' // Récupère les résultats en français
        ]);
        $url = "https://api.opencagedata.com/geocode/v1/json?$queryParams";

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

    public function insertLocationVille($idVille, $lat, $lng) {
        $sql = "UPDATE villes SET location = ST_GeomFromText(:point) WHERE idVille = :idVille";
        $point = "POINT($lng $lat)"; // Longitude en premier
    
        $this->db->query($sql, [
            'idVille' => $idVille,
            'point' => $point
        ]);
    }

    function getVilles(){
        $request = "select * from villes";
        $statement = $this -> db -> query($request);

        $villeList=[];
        while ($ville = $statement -> fetch()){
            $villeList[] = new Ville ($ville);
        }
        return $villeList;
    }

    public function getCoordsByName($ville){
        $sql = 'SELECT ST_X(location) AS lng, ST_Y(location) AS lat 
            FROM villes 
            WHERE ville = :ville';

        $coords = $this->db->query($sql, [$ville])->fetch(); 

        return $coords ?: null; // Retourne null si aucun résultat
    }

    public function getIdVilleByName($ville){

        $sql = 'SELECT idVille FROM villes WHERE ville = :ville';
        $idVille = $this->db->query($sql, ['ville' => $ville])->fetchColumn();
        return $idVille !== false ? (int) $idVille : null;
    }
}
