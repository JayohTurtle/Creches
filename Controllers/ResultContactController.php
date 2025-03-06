<?php

class ResultContactController {

    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $clientManager;
    private $interetCrecheManager;
    private $interetGroupeManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetGroupeManager = new InteretGroupeManager();
    }

    public function handleResearchContact(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;

            $nom = $this->sanitizeInput($postData['nom'] ?? null);
            $contact = $this->sanitizeInput($postData['contact'] ?? null);
            $email = $this->sanitizeInput($postData['email'] ?? null);

            $this->extractCommentsFromContact($nom, $contact, $email);

            $this->showResultContact($postData);
        }
    }

    public function showResultContact($postData) {
        // Liste des champs à vérifier
        $donnees = [
            'contact' => $this->sanitizeInput($postData['donneeContact'] ?? ''),
            'nom' => $this->sanitizeInput($postData['donneeNomGroupe'] ?? ''),
            'email' => $this->sanitizeInput($postData['donneeEmail'] ?? ''),
            'siren' => $this->sanitizeInput($postData['donneeSIREN'] ?? ''),
            'telephone' => $this->sanitizeInput($postData['donneeTelephone'] ?? ''),
            'siteInternet' => $this->sanitizeInput($postData['donneeSiteInternet'] ?? ''),
        ];
    
        $donneeRecherchee = null;
        $valeurRecherchee = null;
    
        // Trouver la première valeur non vide
        foreach ($donnees as $champ => $valeur) {
            if (!empty($valeur)) {
                $donneeRecherchee = $champ; 
                $valeurRecherchee = $valeur;
                
                break; // On s'arrête après avoir trouvé la première donnée remplie
            }
        }
    
        $contact = null;
        $localisations = null;
    
        if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
            // Récupérer un SEUL contact
            $contact = $this->contactManager->extractResearchContact($donneeRecherchee, $valeurRecherchee);

            if ($contact && method_exists($contact, 'getIdContact')) {
                // Récupérer les localisations du contact
                $idContact = $contact->getIdContact();
                
                $localisations = $this->localisationManager->getLocalisationByContact($idContact);
                $adresses = array_map(fn($loc) => $loc->getAdresse(), $localisations);

            }
        }

        // Récupérer les commentaires du contact
        $commentaires = $this->extractCommentsFromContact($contact);

        $clients = $this->clientManager->getClientsWithContacts();
        $clientData = $this->clientManager->getDataClientsById($idContact);

        //Récupérer les localisations du contact
        $localisations = $this->localisationManager->getLocalisationByContact($idContact);

        //Extraire les adresses des localisations
        $adresses = array_map(fn($loc) => $loc->getAdresse(), $localisations);

        //Récupérer les idLocalisations en fonction des adresses
        $idLocalisations = $this->localisationManager->getIdLocalisationByAdresse($adresses);

        //Récupérer les intérêts pour chaque localisation
        $interets = $this->interetCrecheManager->getInteretsByIdLocalisations($idLocalisations);

        //Récupérer les intérêts pour un groupe
        $nom = $this->sanitizeInput($postData['donneeNomGroupe'] ?? '');
        $interetsGroupe = $this->interetGroupeManager->getIdGroupeByName($nom);


        //Extraire les idContact uniques des intérêts
        $idContacts = [];
        if (!empty($interets)) {
            $idContacts = [];
            foreach ($interets as $listeInterets) {
                foreach ($listeInterets as $interet) {
                    if (isset($interet['idContact'])) {
                        $idContacts[] = $interet['idContact'];
                    }
                }
            }
            $idContacts = array_unique($idContacts); // Évite les doublons
            // 6️⃣ Récupérer les informations des contacts
            $contacts = [];
            foreach ($idContacts as $id) {
                $contacts[$id] = $this->contactManager->getContactById($id);

            }

            // 7️⃣ Associer chaque localisation avec ses intérêts et leurs contacts
            foreach ($localisations as $localisation) {
                $idLoc = $localisation->getIdLocalisation();
                if (isset($interets[$idLoc])) {
                    foreach ($interets[$idLoc] as &$interet) {
                        $interet['contact'] = $contacts[$interet['idContact']] ?? null;
                    }
                }
                $localisation->setInterets($interets[$idLoc] ?? []);
            }
        }

        if (!empty($interetsGroupe)) {
            $idContacts = [];
        
            // Étape 1 : Extraire tous les ID de contact
            foreach ($interetsGroupe as $interet) {
                if (!empty($interet->getIdContact())) {
                    $idContacts[] = $interet->getIdContact();
                }
            }
        
            // Éviter les doublons
            $idContacts = array_unique($idContacts);
        
            // Étape 2 : Récupérer tous les contacts associés aux ID trouvés
            $contacts = [];
            foreach ($idContacts as $id) {
                $contacts[$id] = $this->contactManager->getContactById($id);
            }
        
            // Étape 3 : Attacher chaque contact à son objet InteretGroupe
            foreach ($interetsGroupe as $interet) {
                if (isset($contacts[$interet->getIdContact()])) {
                    $interet->setContact($contacts[$interet->getIdContact()]); // ✅ Utilisation du setter

                }
            }

        }
        
        if ($clientData) {
            // 🔹 Si un client existe, on redirige vers la vue `researchResultClient`
            $view = new View();
            $view->render('researchResultClient', [
                'clientData' => $clientData,
                'idContact' => $idContact,
                'commentaires' => $commentaires,
                'contact' => $contact,
                'client' => $clientData,
                'clients' => $clients,
                'localisations' => $localisations ?? [],
                'interetsGroupe' => $interetsGroupe ?? [],
            ]);
            return; // 🔹 Arrêt ici pour éviter de continuer vers `researchResultContact`
        }
    
        //Récupérer les intérêts du contact
        $interetVilleManager = new InteretVilleManager();
        $interetVilles = $interetVilleManager->getInteretVillesByContact($idContact);

        $interetDepartementManager = new InteretDepartementManager();
        $interetDepartements = $interetDepartementManager->getInteretDepartementsByContact($idContact);

        $interetRegionManager = new InteretRegionManager();
        $interetRegions = $interetRegionManager->getInteretRegionsByContact($idContact);
        
        $interetFranceManager = new InteretFranceManager();
        $hasInteretFrance = $interetFranceManager->hasInteretFrance($idContact);

        $interetCrecheManager = new InteretCrecheManager();
        $interetCreches = $interetCrecheManager->getInteretCrechesByContact($idContact);

        $interetGroupeManager = new InteretGroupeManager();
        $interetGroupe = $interetGroupeManager->getInteretGroupesByContact($idContact);

        $interetTailleManager = new InteretTailleManager();
        $interetTaille = $interetTailleManager->getInteretTailleByContact($idContact);
    
        // Passer les résultats à la vue
        $view = new View();
        $view->render('researchResultContact', [
            'idContact' =>$idContact,
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations ?? [],
            'interetVilles' => $interetVilles ?? [],
            'interetDepartements' => $interetDepartements ?? [],
            'interetRegions' => $interetRegions ?? [],
            'hasInteretFrance' => $hasInteretFrance,
            'interetCreches' => $interetCreches ?? [],
            'interetGroupe' => $interetGroupe ?? [],
            'interetTaille' => $interetTaille ?? [],
            'clients' => $clients
        ]);
    }
        
    public function extractCommentsFromContact($contact) {
        if (!$contact || !method_exists($contact, 'getIdContact')) {
            return []; // Aucun commentaire si pas d'ID de contact
        }
    
        $idContact = $contact->getIdContact(); // Utilisation du getter
        return $this->commentManager->extractComments($idContact);
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



