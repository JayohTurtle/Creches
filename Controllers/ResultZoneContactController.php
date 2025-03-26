<?php

class ResultZoneContactController{

    private $localisationManager;
    private $contactManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;


    public function __construct() {
        $this->villeManager = new VilleManager;
        $this->departementManager = new DepartementManager;
        $this->localisationManager = new LocalisationManager();
        $this->contactManager = new ContactManager();
        $this->regionManager = new RegionManager();

    }

    public function showResultZoneContact(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $zoneType = $_POST['localResearch'] ?? null;
            $nombreCreche = (int) ($_POST['researchNbreCreche'] ?? 0);
            $zoneValue = null;
            $idDepartementList = [];

            // Vérifier quel input a été rempli selon le bouton radio sélectionné
            if ($zoneType === "researchVille") {
                $zoneVille = $this->sanitizeInput($_POST['zoneVille'] ?? null);
                $rayon = $_POST['zoneVilleRayon'] ?? ''; // Récupérer la valeur ou une chaîne vide
                $rayon = !empty($rayon) ? (int) $this->sanitizeInput($rayon) : 5;
                $zoneValue = 'Recherche dans un rayon de ' . $rayon . ' kms autour de ' . $zoneVille;
                
            } elseif ($zoneType === "researchDepartement") {
                $zoneValue = $this->sanitizeInput($_POST['zoneDepartement'] ?? null);
            } elseif ($zoneType === "researchRegion") {
                $zoneValue = $this->sanitizeInput($_POST['zoneRegion'] ?? null);
            } elseif ($zoneType === "researchFrance"){
                $zoneValue = "France";
            }
        }elseif ($_SERVER["REQUEST_METHOD"] == "GET") {

            $zoneType = $_GET['zoneType'];
            $nombreCreche = (int) ($_GET['researchNbreCreche'] ?? 0);
            $zoneValue = $_GET['zoneValue'];
            $zoneVille = $_GET['zoneVille']?? null;
            $rayon = $_GET['rayon']?? null;
            $idDepartementList = [];
        }

        // Vérifier quel type de recherche est sélectionné
        switch ($zoneType) {
            case 'researchVille':
                $coords = $this->villeManager->getCoordsByName($zoneVille);
                if (!$coords) {
                    die("Erreur : Ville introuvable.");
                }
                break;
            case 'researchDepartement':
                $idZone = $this->departementManager->getDepartementIdByName($zoneValue);
                break;
            case 'researchRegion':
                $idRegion = $this->regionManager->getRegionIdByName($zoneValue);
                break;
            
            case 'researchFrance':
                break;

            default:
                die("Type de recherche invalide.");
        }

        // Vérifier quel type de recherche est sélectionné
        $idContacts = [];

        switch ($zoneType) {
            case 'researchVille':
                // Récupérer les objets Localisation contenant les identifiants
                $localisationContacts = $this->localisationManager->getLocalisationsInRayon($coords, $rayon);

                // Récupérer uniquement les idContact
                foreach ($localisationContacts as $localisation) {
                    // Accéder directement à l'index 'idContact'
                    $idContacts[] = $localisation->getIdContact();
                }
                break;

            case 'researchDepartement':
                // S'assurer que idZone est un tableau, même si c'est un seul ID
                $idContacts = $this->localisationManager->getIdContactByIdDepartement([$idZone]);
                break;

            case 'researchRegion':
                // Récupérer la liste des départements de la région
                $idDepartementList = $this->departementManager->getDepartementsIdByIdRegion($idRegion);
            
                // On s'assure que idDepartementList est un tableau
                $idDepartementArray = [];
                foreach ($idDepartementList as $dep) {
                    $idDepartementArray[] = $dep->getIdDepartement();
                }
            
                // Passer un tableau de départements à la méthode
                $idContacts = $this->localisationManager->getIdContactByIdDepartement($idDepartementArray);
                break;

            case 'researchFrance':
                $idContacts = $this->localisationManager->getIdContactByLocalisations();
                break;
        }

        // Supprimer les doublons
        $idContacts = array_unique($idContacts);            
        
        // Récupérer les informations des contacts
        $contacts = [];
        foreach ($idContacts as $idContact) {

            $contact = $this->contactManager->getContactByIdContact($idContact);
            
            $nombreCrecheContact = $this->localisationManager->countCrechesByIdContact($idContact);
            
            if($nombreCrecheContact >= $nombreCreche){
                $contacts[] = ['contact' => $contact];  
            }
        }

        $nombreContacts = count($contacts);

        // Passer les résultats à la vue
        $view = new View();
        $view->render('resultZoneContact', [
            'contacts'=> $contacts,
            'zoneValue'=> $zoneValue ?? '',
            'zoneType' => $zoneType,
            'zoneVille' => $zoneVille ?? '',
            'rayon'=> $rayon ?? null,
            'nombreContacts'=> $nombreContacts,
            'nombreCreche'=> $nombreCreche
        ]);
    }

    /**
    * Fonction utilitaire pour nettoyer les entrées utilisateur.
    */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }
}