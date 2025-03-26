<?php

class AjoutAcheteurController {
    private $localisationManager;
    private $villeManager;
    private $groupeManager;
    private $departementManager;
    private $interetCrecheManager;
    private $interetVilleManager;
    private $interetDepartementManager;
    private $regionManager;
    private $interetRegionManager;
    private $interetTailleManager;
    private $interetGroupeManager;
    private $interetFranceManager;

    public function __construct() {
        $this->localisationManager = new LocalisationManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetVilleManager = new InteretVilleManager();
        $this->interetDepartementManager = new InteretDepartementManager();
        $this->interetRegionManager = new InteretRegionManager();
        $this->interetTailleManager = new InteretTailleManager();
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->interetFranceManager = new InteretFranceManager();
        $this->groupeManager = new GroupeManager();
    }

    public function handleAjoutAcheteur() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = $_POST['idContact'];

            // Vérifier si une ville est renseignée avant d'ajouter une localisation et un point de location(liée au contact, à ville et à departement)            
            if (!empty($_POST['ville']) && array_filter($_POST['ville'])) {
                $idLocalisations = $this->addLocalisation($idContact);
                $this->addLocation($idLocalisations, $_POST['ville'], $_POST['codePostal'], $_POST['adresse']);
            }

            // Vérifier si un intérêt crèche est renseigné et ajouter l'intérêt crèche
            if (!empty($_POST['niveau']) && !empty($_POST['identifiantInterest'])) {
                $this->addInteretCreche($idContact);
            }

            //Vérifier si un intérêt groupe est renseigné et ajouter l'intérêt groupe
            if (!empty($_POST['niveau']) && !empty($_POST['groupeInterest'])) {
                $this->addInteretGroupe($idContact);
            }

            // Vérifier si villeInterest est rempli avant d'ajouter un intérêt ville
            if (!empty($_POST['villeInterest']) && array_filter($_POST['villeInterest'], 'strlen')) {
                $this->addInteretVille($idContact);
            }

            // Vérifier si departementInterest est rempli avant d'ajouter un intérêt département
            if (!empty($_POST['departementInterest']) && array_filter($_POST['departementInterest'], 'strlen')) {
                $this->addInteretDepartement($idContact);
            }

            // Vérifier si regionInterest est rempli avant d'ajouter un intérêt région
            if (!empty($_POST['regionInterest']) && array_filter($_POST['regionInterest'], 'strlen')) {
                $this->addInteretRegion($idContact);
            }

            if (!empty($_POST['franceInterest'])){
                $this->addInteretFrance($idContact);
            }
            //Ajouter l'intérêt taille
            $this->addInteretTaille($idContact);

            // Redirection après ajout

            unset($_SESSION['form_data']['contact']); 
            unset($_SESSION['form_data']['nom']);
            unset($_SESSION['form_data']['email']);
            unset($_SESSION['form_data']['siren']);
            unset($_SESSION['form_data']['telephone']);
            unset($_SESSION['form_data']['site']);
            unset($_SESSION['form_data']['comment']);   

            header("Location: index.php?action=newContact&success=1");
            exit();
        }
    }

    private function addLocalisation($idContact) {
        $nom = $this->sanitizeInput($_POST['nom'] ?? null);
        
        $groupe = new Groupe;
        $groupe->setNom($nom);
        $groupe->setIdContact($idContact);

        $idGroupe = $this->groupeManager->insertGroupe($groupe);
    
        $idLocalisations = [];

        if (!empty($_POST['ville'])) {
            foreach ($_POST['ville'] as $key => $ville) {
                $ville = $this->sanitizeInput($ville);
                $codePostal = $this->sanitizeInput($_POST['codePostal'][$key] ?? '');
                $adresse = $this->sanitizeInput($_POST['adresse'][$key] ?? '');
                $taille = $_POST['taille'][$key] ?? null;

                $idDepartement = $this->departementManager->getIdDepartementByCodePostal($codePostal);
                $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
                
                $nom = $this->sanitizeInput($_POST['nom']);
                $identifiant = "$nom - $ville - $adresse";

                $localisation = new Localisation;
                $localisation->setIdContact($idContact);
                $localisation->setIdVille($idVille);
                $localisation->setIdDepartement($idDepartement);
                $localisation->setAdresse($adresse);
                $localisation->setIdentifiant($identifiant);
                $localisation->setTaille($taille);
                $localisation->setIdGroupe($idGroupe);

                $idLocalisation = $this->localisationManager->insertLocalisation($localisation);
    
                if ($idLocalisation) {
                    $idLocalisations[] = $idLocalisation;
                }
            }
        }

        return $idLocalisations;
    }

    private function addLocation($idLocalisations, $villes, $codesPostaux, $adresses) {
        if (!empty($idLocalisations)) {
            foreach ($idLocalisations as $key => $idLocalisation) {
                $ville = $villes[$key] ?? '';
                $codePostal = $codesPostaux[$key] ?? '';
                $adresse = $adresses[$key] ?? '';
    
                $adresseComplete = $this->localisationManager->createAddress($adresse, $codePostal, $ville);
    
                // Appel à geocodeAdresse
                $coords = $this->localisationManager->geocodeAdresse($adresseComplete);
                if ($coords) {
                    $latitude = $coords['lat'];
                    $longitude = $coords['lng'];
    
                    $this->localisationManager->insertLocation($idLocalisation, $latitude, $longitude);

                }
            }
        }
    }

    private function addInteretCreche($idContact) {
            
        // Récupérer l'ID de la localisation correspondant à l'identifiant
        $identifiantInterest = $this->sanitizeInput($_POST['identifiantInterest'] ?? null);
        $idLocalisation= $this->localisationManager->getIdLocalisationByIdentifiant($identifiantInterest);

        if ($idLocalisation) { // Vérifier si un ID a bien été trouvé
            $interetCreche = new InteretCreche();
            $interetCreche->setIdContact($idContact);
            $interetCreche->setNiveau($this->sanitizeInput($_POST['niveau'] ?? null));
            $interetCreche->setIdLocalisation($idLocalisation);

            $this->interetCrecheManager->insertInteretCreche($interetCreche);
        }
    }

    private function addInteretGroupe($idContact) {

        $nom = $this->sanitizeInput ($_POST['groupeInterest']);
        $idGroupe = $this->groupeManager->getIdGroupeByName($nom);

        $interetGroupe = new InteretGroupe();

        $interetGroupe->setNiveau($this->sanitizeInput($_POST['niveau'] ?? null));
        $interetGroupe->setIdGroupe($idGroupe);
        $interetGroupe->setIdContact($idContact);

        $this->interetGroupeManager->insertInteretGroupe($interetGroupe);
    }

    private function addInteretVille($idContact) {

        foreach ($_POST['villeInterest'] as $key => $villeInterest) {
            $villeInterest = $this->sanitizeInput($villeInterest);
            $codePostalInterest = $this->sanitizeInput ($_POST['codePostalInterest'][$key]);
            $rayonInterest = !empty($_POST['rayonInterest'][$key]) && is_numeric($_POST['rayonInterest'][$key]) 
            ? (int) $this->sanitizeInput($_POST['rayonInterest'][$key]) 
            : 0;
        
        $interetVille = new InteretVille();
        
        // Récupérer l'ID du département à partir du code postal
        $idDepartement = $this->departementManager->getIdDepartementByCodePostal($codePostalInterest);
        
        // Vérifier si la ville existe, sinon l'ajouter
        $idVilleInterest = $this->villeManager->insertVilleIfNotExists($villeInterest, $codePostalInterest,$idDepartement);
        
        $interetVille->setIdContact($idContact);
        $interetVille->setIdVille($idVilleInterest);
        $interetVille->setRayon($rayonInterest ?? 0);
    
        $this->interetVilleManager->insertInteretVille($interetVille);
        }
    }
    private function addInteretDepartement($idContact) {

        foreach ($_POST['departementInterest'] as $departementInterest) {
            $departementInterest = $this->sanitizeInput($departementInterest);
            
            $interetDepartement = new InteretDepartement();
            
            // Récupérer l'ID du département à partir du nom
            $idDepartementInterest = $this->departementManager->getIdDepartementByName($departementInterest);
            $interetDepartement->setIdContact($idContact);
            $interetDepartement->setIdDepartement($idDepartementInterest);

            $this->interetDepartementManager->insertInteretDepartement($interetDepartement);
        }
    }

    private function addInteretRegion($idContact) {

        foreach ($_POST['regionInterest'] as $key => $regionInterest) {
            $regionInterest = $this->sanitizeInput($regionInterest);
        
        $interetRegion = new InteretRegion();
        
        // Récupérer l'ID de la région à partir du nom
        $idRegionInterest = $this->regionManager->getRegionIdByName($regionInterest);
        
        $interetRegion->setIdContact($idContact);
        $interetRegion->setIdRegion($idRegionInterest);

        $this->interetRegionManager->insertInteretRegion($interetRegion);
        }
    }

    private function addInteretFrance($idContact) {
        
        $interetFrance = new InteretFrance();

        $interetFrance->setIdContact($idContact);

        $this->interetFranceManager->insertInteretFrance($interetFrance);

    }

    private function addInteretTaille($idContact) {

        $tailleInterest = $_POST['sizeCreche'];
        
        $interetTaille = new InteretTaille();
        
        $interetTaille->setIdContact($idContact);
        $interetTaille->setTaille($tailleInterest);

        $this->interetTailleManager->insertInteretTaille($interetTaille);

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