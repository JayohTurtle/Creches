<?php

class ResultContactController {

    private $contactManager;
    private $commentManager;
    private $localisationManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
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
            }
        }

        // Vérifier si $idContact est défini avant de l'utiliser
        if (isset($idContact)) {

            //Récupérer les clients pour ajout à la vue en cas de modification des intére^ts sur une crèche ou un groupe
            $clientManager = new ClientManager();
            $clients = $clientManager->getClientsWithContacts(); // ✅ Récupération des clients

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

            $interetGroupeManager = new InteretGroupeManager();
            $interetGroupe = $interetGroupeManager->getInteretGroupesByContact($idContact);

            $interetTailleManager = new InteretTailleManager();
            $interetTaille = $interetTailleManager->getInteretTailleByContact($idContact);
            
            // Récupérer les commentaires du contact
            $commentaires = $this->extractCommentsFromContact($contact);
        
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
                'clients' => $clients,
            ]);
        }
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
                return array_map([$this, 'sanitizeInput'], $input);
            }
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }
}


