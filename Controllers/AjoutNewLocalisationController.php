<?php

class AjoutNewLocalisationController{

    private $villeManager;
    private $groupeManager;
    private $departementManager;
    private $localisationManager;

    public function __construct() {
        $this->villeManager = new VilleManager();
        $this->departementManager = new departementManager();
        $this->localisationManager = new LocalisationManager();
        $this->groupeManager = new GroupeManager();

    }

    public function handleAjoutNewLocalisation() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = $_POST['idContact'];
            $nom = $_POST['nom'];
            $adresse = $this-> sanitizeInput($_POST['adresse']);
            $ville = $this-> sanitizeInput($_POST['newVille']);
            $codePostal = $this-> sanitizeInput($_POST['newCodePostal']);
            $taille = $this-> sanitizeInput($_POST['taille']);
        }

        $identifiant = "$nom - $ville - $adresse";
        $idDepartement = $this->departementManager->getIdDepartementByCodePostal($codePostal);
        $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
        $idGroupe = $this->groupeManager->getIdGroupeByName($nom);

        $idLocalisation = $this->addLocalisation($idContact, $idVille, $idDepartement, $adresse, $identifiant, $taille, $idGroupe);
        $this->addLocation($idLocalisation, $ville, $codePostal, $adresse);
    }
        
    private function addLocalisation($idContact, $idVille, $idDepartement, $adresse, $identifiant, $taille, $idGroupe){
       
        $newLocalisation = new Localisation();
        $newLocalisation->setIdContact($idContact);
        $newLocalisation->setAdresse($adresse);
        $newLocalisation->setIdVille($idVille);
        $newLocalisation->setIdDepartement($idDepartement);
        $newLocalisation->setIdentifiant($identifiant);
        $newLocalisation->setIdGroupe($idGroupe);
        $newLocalisation->setTaille($taille);

        $idLocalisation = $this->localisationManager->insertLocalisation($newLocalisation);

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
