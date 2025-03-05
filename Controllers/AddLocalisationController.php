<?php

class AddLocalisationController{

    private $villeManager;
    private $departementManager;
    private $localisationManager;

    public function __construct() {
        $this->villeManager = new VilleManager();
        $this->departementManager = new departementManager();
        $this->localisationManager = new LocalisationManager();

    }

    public function handleAddLocalisation() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = $_POST['idContact'];
            $nom = $_POST['nom'];
            $adresse = $this-> sanitizeInput($_POST['adresse']);
            $ville = $this-> sanitizeInput($_POST['ville']);
            $codePostal = $this-> sanitizeInput($_POST['codePostal']);
            $taille = $this-> sanitizeInput($_POST['taille']);
        }

        $idLocalisations = $this->addLocalisation($idContact, $nom, $ville, $codePostal, $adresse, $taille);

        $this->addLocation($idLocalisations, $ville, $codePostal, $adresse);
        
    }
        
    private function addLocalisation($idContact, $nom, $ville, $codePostal, $adresse, $taille){
        $idDepartement = $this->departementManager->getDepartementIdByCodePostal($codePostal);
        $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
            
        $identifiant = "$nom - $ville - $adresse";

        $idLocalisation = $this->localisationManager->insertLocalisation(
            $idContact,
            $idVille,
            $adresse,
            $idDepartement,
            $identifiant,
            $taille
        );
        return $idLocalisation;
    }
        
    private function addLocation($idLocalisation, $ville, $codePostal, $adresse) {
        
        $result = false;
    
        $adresseComplete = $this->localisationManager->createAddress($adresse, $codePostal, $ville);
    
        $coords = $this->localisationManager->geocodeAdresse($adresseComplete);
    
        if ($coords) {
            $latitude = $coords['lat'];
            $longitude = $coords['lng'];
            $result = $this->localisationManager->insertLocation($idLocalisation, $latitude, $longitude);
        }
    
        header('Content-Type: application/json');
    
        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Localisation ajoutée avec succès' : 'Erreur lors de l\'ajout de la localisation',
            'result' => $result
        ]);
        exit;
    }
    
    /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur destinées à la base de données.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }
}
