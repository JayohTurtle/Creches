<?php

class AddContactController {
    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $villeManager;
    private $departementManager;
    private $clientManager;
    private $interetCrecheManager;
    private $interetVilleManager;
    private $interetDepartementManager;
    private $regionManager;
    private $interetRegionManager;
    private $interetTailleManager;
    private $interetGroupeManager;
    private $interetFranceManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->clientManager = new ClientManager();
        $this->regionManager = new RegionManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetVilleManager = new InteretVilleManager();
        $this->interetDepartementManager = new InteretDepartementManager();
        $this->interetRegionManager = new InteretRegionManager();
        $this->interetTailleManager = new InteretTailleManager();
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->interetFranceManager = new InteretFranceManager();
    }

    public function handleAddContact() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;

            $operateur = $_SESSION['user_email'];

            // Ajout du contact et récupération de son ID
            $idContact = $this->addContact($postData);

            // Ajout du commentaire (liée au contact)
            $this->addComment($postData, $operateur, $idContact);

            // Vérifier si une ville est renseignée avant d'ajouter une localisation et un point de location(liée au contact, à ville et à departement)            
            if (!empty($postData['ville']) && array_filter($postData['ville'])) {
                $idLocalisations = $this->addLocalisation($postData, $idContact);
                $this->addLocation($idLocalisations, $postData['ville'], $postData['codePostal'], $postData['adresse']);
            }
            
            // Vérifier si un intérêt crèche est renseigné et ajouter l'intérêt crèche
            if (!empty($postData['niveau']) && !empty($postData['identifiantInterest'])) {
            $this->addInteretCreche($postData, $idContact);
            }

            //Vérifier si un intérêt groupe est renseigné et ajouter l'intérêt groupe
            if (!empty($postData['niveau']) && !empty($postData['groupeInterest'])) {
                $this->addInteretGroupe($postData, $idContact);
            }

            // Vérifier si le contact est un vendeur avant d'ajouter un client (liée au contact)
            if (isset($postData['directionChoice']) && strtolower(trim($postData['directionChoice'])) === "vendeur") {
            $this->addClient($postData, $idContact);
            }
            
            // Vérifier si villeInterest est rempli avant d'ajouter un intérêt ville
            if (!empty($postData['villeInterest']) && array_filter($postData['villeInterest'], 'strlen')) {
                $this->addInteretVille($postData, $idContact);
            }

            // Vérifier si departementInterest est rempli avant d'ajouter un intérêt département
            if (!empty($postData['departementInterest']) && array_filter($postData['departementInterest'], 'strlen')) {
                $this->addInteretDepartement($postData, $idContact);
            }

            // Vérifier si regionInterest est rempli avant d'ajouter un intérêt région
            if (!empty($postData['regionInterest']) && array_filter($postData['regionInterest'], 'strlen')) {
                $this->addInteretRegion($postData, $idContact);
            }

            if (!empty($postData['franceInterest'])){
                $this->addInteretFrance($idContact);
            }

            //vérifier si france est rempli avant d'ajouter un intérêt france

            // Vérifier si au moins une des valeurs est remplie avant d'ajouter un intérêt taille
            if (
                (!empty($postData['villeInterest']) && array_filter($postData['villeInterest'], 'strlen')) ||
                (!empty($postData['departementInterest']) && array_filter($postData['departementInterest'], 'strlen')) ||
                (!empty($postData['regionInterest']) && array_filter($postData['regionInterest'], 'strlen')) ||
                (!empty($postData['franceInterest']))
            ) {
                $this->addInteretTaille($postData, $idContact);
            }

            // Redirection après ajout
            header("Location: index.php?action=newContactForm&success=1");
            exit();
        }
    }

    private function addContact($postData) {

        $nom = $this->sanitizeInput($postData['nom'] ?? null);
        $contact = $this->sanitizeInput($postData['contact'] ?? null);
        $email = $this->sanitizeInput($postData['email'] ?? null);
        
        $existingContactId = $this->contactManager->contactExists($nom, $contact, $email);
        
        if ($existingContactId) {
            return $existingContactId; // Retourner l'ID du contact existant
        }
        
        $contact = new Contact();
        $contact->setNom($this->sanitizeInput(($postData['nom'])));
        $contact->setContact($this->sanitizeInput(($postData['contact'])));
        $contact->setSiren($this->sanitizeInput(($postData['siren'])));
        $contact->setEmail($this->sanitizeInput(($postData['email'])));
        $contact->setTelephone($this->sanitizeInput(($postData['telephone'])));
        $contact->setSiteInternet($this->sanitizeInput(($postData['site'])));
        $contact->setSens(isset($postData['directionChoice']) ? ($postData['directionChoice']) : null);

        return $this->contactManager->insertContact(
            $contact->getNom(),
            $contact->getContact(),
            $contact->getSiren(),
            $contact->getEmail(),
            $contact->getTelephone(),
            $contact->getSiteInternet(),
            $contact->getSens()
        );
            
    }
    
    private function addComment($postData, $operateur, $idContact) {
        if (!empty($postData['comment'])) {
            $comment = new Comment();
            $comment->setIdContact($idContact);
            $comment->setCommentaire($this->sanitizeInput(($postData['comment'])));
            $comment->setDateComment(date("d/m/Y"));
            $comment->setOperateur($operateur);

            $this->commentManager->insertComment(
                $idContact,
                $comment->getCommentaire(),
                $comment->getDateComment(),
                $comment->getOperateur(),
            );
        }
    }

    private function addLocalisation($postData, $idContact) {
        $idLocalisations = [];
    
        if (!empty($postData['ville'])) {
            foreach ($postData['ville'] as $key => $ville) {
                $ville = $this->sanitizeInput($ville);
                $codePostal = $this->sanitizeInput($postData['codePostal'][$key] ?? '');
                $adresse = $this->sanitizeInput($postData['adresse'][$key] ?? '');
                $taille = $postData['taille'][$key] ?? null;
    
                $idDepartement = $this->departementManager->getDepartementIdByCodePostal($codePostal);
                $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
    
                $nom = $this->sanitizeInput($postData['nom']);
                $identifiant = "$nom - $ville - $adresse";
    
                $idLocalisation = $this->localisationManager->insertLocalisation(
                    $idContact,
                    $idVille,
                    $adresse,
                    $idDepartement,
                    $identifiant,
                    $taille
                );
    
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
                // On récupère la valeur correspondant à chaque localisation
                $ville = $villes[$key] ?? '';
                $codePostal = $codesPostaux[$key] ?? '';
                $adresse = $adresses[$key] ?? '';
    
                $adresseComplete = $this->localisationManager->createAddress($adresse, $codePostal, $ville);
    
                $coords = $this->localisationManager->geocodeAdresse($adresseComplete);
                if ($coords) {
                    $latitude = $coords['lat'];
                    $longitude = $coords['lng'];
                    $this->localisationManager->insertLocation($idLocalisation, $latitude, $longitude);
                }
            }
        }
    }
    
    private function addClient($postData, $idContact){

        $client = new Client;
        $client->setIdContact($idContact);
        $client->setStatut($this->sanitizeInput(($postData['statut'])));
        // Vérifier si la valorisation est un nombre, sinon mettre 0
        $valorisation = $this->sanitizeInput($postData['valorisation'] ?? null);
        $client->setValorisation(is_numeric($valorisation) ? (int) $valorisation : 0);

        // Vérifier si la commission est un nombre, sinon mettre 0
        $commission = $this->sanitizeInput($postData['commission'] ?? null);
        $client->setcommission(is_numeric($commission) ? (int) $commission : 0);

        $this->clientManager->insertClient(
            $idContact,
            $client->getStatut(),
            $client->getValorisation(),
            $client->getCommission()
        );
    }

    private function addInteretCreche($postData, $idContact) {
            
        // Récupérer l'ID de la localisation correspondant à l'identifiant
        $identifiantInterest = $this->sanitizeInput($postData['identifiantInterest'] ?? null);
        $idIdentifiant = $this->localisationManager->getIdLocalisationByIdentifiant($identifiantInterest);


        if ($idIdentifiant) { // Vérifier si un ID a bien été trouvé
            $interetCreche = new InteretCreche();
            $interetCreche->setIdContact($idContact);
            $interetCreche->setNiveau($this->sanitizeInput($postData['niveau'] ?? null));
            $interetCreche->setIdIdentifiant($idIdentifiant);

            $this->interetCrecheManager->insertInteretCreche(
                $idContact,
                $interetCreche->getNiveau(),
                $interetCreche->getIdIdentifiant()
            );
        }
    }
    private function addInteretGroupe($postData) {
            
        // Récupérer l'ID du contact correspondant au groupe
        $groupeInterest = $this->sanitizeInput($postData['groupeInterest'] ?? null);
        $idGroupe = $this->contactManager->getIdContactByName($groupeInterest);


        if ($idGroupe) { // Vérifier si un ID a bien été trouvé
            $interetGroupe = new InteretGroupe();
            $interetGroupe->setIdContact($idGroupe);
            $interetGroupe->setNiveau($this->sanitizeInput($postData['niveau'] ?? null));

            $this->interetGroupeManager->insertInteretGroupe(
                $interetGroupe->getIdContact(),
                $interetGroupe->getNiveau(),
            );
        }
    }

    private function addInteretVille($postData, $idContact) {

        foreach ($postData['villeInterest'] as $key => $villeInterest) {
            $villeInterest = $this->sanitizeInput($villeInterest);
            $codePostalInterest = $this->sanitizeInput ($postData['codePostalInterest'][$key]);
            $rayonInterest = !empty($postData['rayonInterest'][$key]) && is_numeric($postData['rayonInterest'][$key]) 
            ? (int) $this->sanitizeInput($postData['rayonInterest'][$key]) 
            : 0;
        
        $interetVille = new InteretVille();
        
        // Récupérer l'ID du département à partir du code postal
        $idDepartement = $this->departementManager->getDepartementIdByCodePostal($codePostalInterest);

        // Vérifier si la ville existe, sinon l'ajouter
        $idVilleInterest = $this->villeManager->insertVilleIfNotExists($villeInterest, $codePostalInterest,$idDepartement);
        
        $interetVille->setIdContact($idContact);
        $interetVille->setIdVille($idVilleInterest);
        $interetVille->setRayon($rayonInterest ?? 0);
    
        $this->interetVilleManager->insertInteretVille(
            $idContact,
            $interetVille->getIdVille(),
            $interetVille->getRayon(),
        );
    }
}
    private function addInteretDepartement($postData, $idContact) {

        foreach ($postData['departementInterest'] as $key => $departementInterest) {
            $departementInterest = $this->sanitizeInput($departementInterest);
        
        $interetDepartement = new InteretDepartement();
        
        // Récupérer l'ID du département à partir du nom
        $idDepartementInterest = $this->departementManager->getDepartementIdByName($departementInterest);
        
        $interetDepartement->setIdContact($idContact);
        $interetDepartement->setIdDepartement($idDepartementInterest);

        $this->interetDepartementManager->insertInteretDepartement(
            $idContact,
            $interetDepartement->getIdDepartement(),
        );
    }
}
    private function addInteretRegion($postData, $idContact) {

        foreach ($postData['regionInterest'] as $key => $regionInterest) {
            $regionInterest = $this->sanitizeInput($regionInterest);
        
        $interetRegion = new InteretRegion();
        
        // Récupérer l'ID de la région à partir du nom
        $idRegionInterest = $this->regionManager->getRegionIdByName($regionInterest);
        
        $interetRegion->setIdContact($idContact);
        $interetRegion->setIdRegion($idRegionInterest);

        $this->interetRegionManager->insertInteretRegion(
            $idContact,
            $interetRegion->getIdRegion(),
        );
    }
}
    private function addInteretFrance($idContact) {
        
        $interetFrance = new InteretFrance();

        $interetFrance->setIdContact($idContact);

        $this->interetFranceManager->insertInteretFrance(
            $idContact,
        );
    }

    private function addInteretTaille($postData, $idContact) {

        $tailleInterest = $postData['sizeCreche'];
        
        $interetTaille = new InteretTaille();
        
        $interetTaille->setIdContact($idContact);
        $interetTaille->setTaille($tailleInterest);

        $this->interetTailleManager->insertInteretTaille(
            $idContact,
            $interetTaille->getTaille(),
        );
    }
    /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    
}

    

