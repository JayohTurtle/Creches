<?php

class ResultZoneAchatController{

    private $localisationManager;
    private $contactManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;
    private $interetCrecheManager;
    private $interetDepartementManager;
    private $interetRegionManager;
    private $interetVilleManager;
    private $interetGroupeManager;
    private $commentManager;

    public function __construct() {
        $this->villeManager = new VilleManager;
        $this->departementManager = new DepartementManager;
        $this->localisationManager = new LocalisationManager();
        $this->contactManager = new ContactManager();
        $this->regionManager = new RegionManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetDepartementManager = new InteretDepartementManager();
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->interetRegionManager = new InteretRegionManager();
        $this->interetVilleManager = new InteretVilleManager();
        $this->commentManager = new CommentManager();
    }

    public function showResultZoneAchat(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $zoneType = $_POST['localResearchAchat'] ?? null;
            $nombreCreche = (int) ($_POST['researchNbreCreche'] ?? 0);
            $zoneValue = null;
            $idDepartementList = [];

            // Vérifier quel input a été rempli selon le bouton radio sélectionné
            if ($zoneType === "researchVilleAchat") {
                $zoneVille = $this->sanitizeInput($_POST['zoneVilleAchat'] ?? null);
                $rayon = $_POST['zoneVilleRayonAchat'] ?? ''; // Récupérer la valeur ou une chaîne vide
                $rayon = !empty($rayon) ? (int) $this->sanitizeInput($rayon) : 5;
                $zoneValue = 'Recherche dans un rayon de ' . $rayon . ' kms autour de ' . $zoneVille;
                
            } elseif ($zoneType === "researchDepartementAchat") {
                $zoneValue = $this->sanitizeInput($_POST['zoneDepartementAchat'] ?? null);
            } elseif ($zoneType === "researchRegionAchat") {
                $zoneValue = $this->sanitizeInput($_POST['zoneRegionAchat'] ?? null);
            } elseif ($zoneType === "researchFranceAchat"){
                $zoneValue = "France";
            }

            // Vérifier quel type de recherche est sélectionné
            switch ($zoneType) {
                case 'researchVilleAchat':
                    $coords = $this->villeManager->getCoordsByName($zoneVille);
                    if (!$coords) {
                        die("Erreur : Ville introuvable.");
                    }
                    break;
                case 'researchDepartementAchat':
                    $idZone = $this->departementManager->getDepartementIdByName($zoneValue);
                    break;
                case 'researchRegionAchat':
                    $idRegion = $this->regionManager->getRegionIdByName($zoneValue);
                    break;
                
                case 'researchFranceAchat':
                    break;

                default:
                    die("Type de recherche invalide.");
            }

            // Vérifier quel type de recherche est sélectionné
            $idContacts = [];
            $idContacts1 = [];
            $idContacts2 = [];

            switch ($zoneType) {
                case 'researchVilleAchat':

                    //Récupérer l'idVille
                    $idVille = $this->villeManager->getIdVilleByName($zoneVille);
                    // Récupérer les objets Localisation contenant les identifiants
                    $localisationContacts = $this->localisationManager->getLocalisationsInRayon($coords, $rayon);
                    
                    // Récupérer uniquement les idContact
                    foreach ($localisationContacts as $localisation) {
                        // Vérifier si l'idContact est non nul avant de l'ajouter au tableau
                        if ($localisation->getIdContact() !== null) {
                            $idContacts1[] = $localisation->getIdContact();
                        }
                    }
                    
                    $idContacts2 = array_filter($this->interetVilleManager->getIdContactByInteretVille($idVille), function($idContact) {
                        return $idContact !== null;
                    });
                    
                    $idContacts = array_unique(array_merge($idContacts1, $idContacts2));
                    break;

                case 'researchDepartementAchat':
                    // S'assurer que idZone est un tableau, même si c'est un seul ID
                    
                    $idContacts1 = $this->localisationManager->getIdContactByIdDepartement([$idZone]);
                    $idContacts2 = $this->interetDepartementManager->getIdContactByInteretDepartement([$idZone]);
                    
                    $idContacts1 = is_array($idContacts1) ? $idContacts1 : [];
                    $idContacts2 = is_array($idContacts2) ? $idContacts2 : [];
                    
                    $idContacts = array_unique(array_merge($idContacts1, $idContacts2));
                    break;

                case 'researchRegionAchat':
                    // Récupérer la liste des départements de la région
                    $idDepartementList = $this->departementManager->getDepartementsIdByIdRegion($idRegion);

                    // On s'assure que idDepartementList est un tableau
                    $idDepartementArray = [];
                    foreach ($idDepartementList as $dep) {
                        $idDepartementArray[] = $dep->getIdDepartement();
                    }
                
                    // Passer un tableau de départements à la méthode
                    $idContacts1 = $this->localisationManager->getIdContactByIdDepartement($idDepartementArray);
                    $idContacts2 = $this->interetRegionManager->getIdContactByInteretRegion($idRegion);
                    
                    // S'assurer que $idContacts1 et $idContacts2 sont des tableaux avant de les fusionner
                    $idContacts1 = is_array($idContacts1) ? $idContacts1 : [];
                    $idContacts2 = is_array($idContacts2) ? $idContacts2 : [];
                    
                    $idContacts = array_unique(array_merge($idContacts1, $idContacts2));
                    break;

                case 'researchFranceAchat':
                    $idContacts = $this->localisationManager->getIdContactByLocalisations();
            }
            
        // Supprimer les doublons
        $idContacts = array_unique($idContacts);
        
        // Récupérer les informations des contacts
        $contacts = [];
        foreach ($idContacts as $idContact) {

            $contact = $this->contactManager->getContactByIdContact($idContact);
            $commentaires = $this->commentManager->getCommentsByIdContact($idContact);
            
            $nombreCrecheContact = $this->localisationManager->countCrechesByIdContact($idContact);
            
            if($nombreCrecheContact >= $nombreCreche){
                
                if ($contact instanceof Contact) {
                    if ($contact->getSens() === 'Acheteur' || $contact->getSens() === 'Neutre') { 
                    // Récupérer les intérêts des crèches pour ce contact
                    
                    $interetsCreche = $this->interetCrecheManager->getInteretsCrechesByIdContact($idContact);
                    // Ajouter les intérêts sous forme de tableau associatif ou dans un tableau spécifique
                    $contacts[] = [
                        'contact' => $contact,
                        'interetsCreche' => $interetsCreche,
                        'commentaires' => $commentaires
                    ];
                    }
                    
                };
                
            }
        }
        $nombreContacts = count($contacts);
    }

        // Passer les résultats à la vue
        $view = new View();
        $view->render('resultZoneAchat', [
            'contacts'=> $contacts,
            'zoneValue'=> $zoneValue ?? '',
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