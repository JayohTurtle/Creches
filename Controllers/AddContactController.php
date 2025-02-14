<?php

class AddContactController {
    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;
    private $clientManager;
    private $interetCrecheManager;
    private $interetManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->clientManager = new ClientManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetManager = new InteretManager();
        $this->regionManager = new RegionManager();
    }

    public function handleAddContact() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;
            $operateur = 'jzabiolle@youinvest.fr';

            // Ajout du contact et récupération de son ID
            $idContact = $this->addContact($postData);

            // Ajout du commentaire (liée au contact)
            $this->addComment($postData, $operateur, $idContact);

            // Vérifier si une ville est renseignée avant d'ajouter une localisation (liée au contact, à ville et à departement)            
            if (!empty($postData['ville']) && array_filter($postData['ville'])) {//si on a une chaine vide, c'est vide
                $this->addLocalisation($postData, $idContact);
            }

            // Vérifier si un intérêt crèche est renseigné et ajouter l'intérêt crèche
            if (!empty($postData['niveau']) && !empty($postData['identifiantInterest'])) {
            $this->addInteretCreche($postData, $idContact);
            }

            // Vérifier si le contact est un vendeur avant d'ajouter un client (liée au contact)
            if (isset($postData['directionChoice']) && strtolower(trim($postData['directionChoice'])) === "vendeur") {
            $this->addClient($postData, $idContact);
            }
            
            //Vérifier si ville, departement ou région sont remplis avant d'ajouter un interet global
            if (!empty($postData['villeInterest']) || !empty($postData['departementInterest']) || !empty($postData['regionInterest'])){
            $this->addInteret($postData, $idContact);
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
            $comment->setDateComment(date("Y/m/d"));
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
        
        if (!empty($postData['ville'])) {
    
            foreach ($postData['ville'] as $key => $ville) {
                $ville = $this->sanitizeInput($ville);
                $codePostal = $this->sanitizeInput ($postData['codePostal'][$key]);
                $adresse = $this->sanitizeInput ($postData['adresse'][$key]);
                $taille = $this->sanitizeInput ($postData['taille'][$key]);

                // Créer une instance de Localisation
                $localisation = new Localisation();

                // Récupérer l'ID du département à partir du code postal
                $idDepartement = $this->departementManager->getDepartementIdByCodePostal($codePostal);
    
                // Vérifier si la ville existe, sinon l'ajouter
                $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal,$idDepartement);
                
                $nom = $this->sanitizeInput($postData['nom']);
                $ville = $this->sanitizeInput($ville);
                $adresse = $this->sanitizeInput($adresse);

                $identifiant = $nom . ' - ' . $ville . ' - ' . $adresse;

                $localisation->setIdVille($idVille);
                $localisation->setIdDepartement($idDepartement);
                $localisation->setAdresse($adresse);
                $localisation->setIdentifiant($identifiant);

                // Insérer la localisation
                $this->localisationManager->insertLocalisation(
                    $idContact,
                    $localisation->getIdVille(),
                    $localisation->getAdresse(),
                    $localisation->getIdDepartement(),
                    $localisation->getidentifiant(),
                    $taille
                    
                );
            }
        }
        return [$idVille, $idDepartement]; // Retourner les IDs pour qu'ils soient utilisés plus tard
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

    private function addInteret($postData, $idContact) {
        $interetsInsérés = [];
    
        // 📌 1️⃣ Traitement des villes
        if (!empty($postData['villeInterest'])) {
            foreach ($postData['villeInterest'] as $key => $villeInterest) {
                $villeInterest = $this->sanitizeInput($villeInterest);
                $codePostalInterest = $this->sanitizeInput($postData['codePostalInterest'][$key] ?? null);
                $rayonInterest = !empty($postData['rayonInterest'][$key]) && is_numeric($postData['rayonInterest'][$key]) 
                    ? (int) $this->sanitizeInput($postData['rayonInterest'][$key]) 
                    : 0;
    
                $departementInterest = $this->sanitizeInput($postData['departementInterest'][$key] ?? null);
                $regionInterest = $this->sanitizeInput($postData['regionInterest'][$key] ?? null);
    
                $idDepartement = !empty($codePostalInterest) ? 
                    $this->departementManager->getDepartementIdByCodePostal($codePostalInterest) : null;
                $idVille = (!empty($villeInterest) && !empty($codePostalInterest)) ? 
                    $this->villeManager->insertVilleIfNotExists($villeInterest, $codePostalInterest, $idDepartement) : null;
                $idRegion = !empty($regionInterest) ? $this->regionManager->getRegionIdByName($regionInterest) : null;
    
                // Clé unique pour éviter les doublons
                $cleInteret = "$idContact-$idVille-$idDepartement-$idRegion";
                if (!isset($interetsInsérés[$cleInteret])) {
                    $this->insertInteret($idContact, $idVille, $idDepartement, $idRegion, $rayonInterest, $postData['sizeCreche'] ?? '');
                    $interetsInsérés[$cleInteret] = true;
                }
            }
        }
    
        // 📌 2️⃣ Traitement des départements + région (sans doublons avec les villes déjà insérées)
        if (!empty($postData['departementInterest'])) {
            foreach ($postData['departementInterest'] as $key => $departementInterest) {
                $departementInterest = $this->sanitizeInput($departementInterest);
                $regionInterest = $this->sanitizeInput($postData['regionInterest'][$key] ?? null);
    
                $idDepartement = $this->departementManager->getDepartementIdByName($departementInterest);
                $idRegion = !empty($regionInterest) ? $this->regionManager->getRegionIdByName($regionInterest) : null;
    
                $cleInteret = "$idContact-null-$idDepartement-$idRegion";
                if (!isset($interetsInsérés[$cleInteret])) {
                    $this->insertInteret($idContact, null, $idDepartement, $idRegion, null, $postData['sizeCreche'] ?? '');
                    $interetsInsérés[$cleInteret] = true;
                }
            }
        }
    
        // 📌 3️⃣ Traitement des régions seules (évite les doublons)
        if (!empty($postData['regionInterest'])) {
            foreach ($postData['regionInterest'] as $key => $regionInterest) {
                $regionInterest = $this->sanitizeInput($regionInterest);
                $idRegion = $this->regionManager->getRegionIdByName($regionInterest);
    
                $cleInteret = "$idContact-null-null-$idRegion";
                if (!isset($interetsInsérés[$cleInteret])) {
                    $this->insertInteret($idContact, null, null, $idRegion, null, $postData['sizeCreche'] ?? '');
                    $interetsInsérés[$cleInteret] = true;
                }
            }
        }
    }
    
    
    /**
     * Fonction pour insérer un intérêt dans la base
     */
    private function insertInteret($idContact, $idVille, $idDepartement, $idRegion, $rayonInterest, $taille) {
    // Vérifier qu'au moins un des trois ID n'est pas NULL avant d'insérer
    if ($idVille === null && $idDepartement === null && $idRegion === null) {
        return; // Ne rien insérer si tout est NULL
    }
        $interet = new Interet();
        $interet->setIdContact($idContact);
        $interet->setIdVille($idVille ?? null);
        $interet->setIdDepartement($idDepartement ?? null);
        $interet->setIdRegion($idRegion ?? null);
        $interet->setTaille($taille);
        $interet->setRayon($rayonInterest ?? 0);
    
        $this->interetManager->insertInteret(
            $idContact,
            $interet->getIdVille(),
            $interet->getIdDepartement(),
            $interet->getIdRegion(),
            $interet->getRayon(),
            $interet->getTaille()
        );
    }
    
 /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($value) {
        return !empty($value) ? trim(strip_tags($value)) : null;
    }    
}

    

