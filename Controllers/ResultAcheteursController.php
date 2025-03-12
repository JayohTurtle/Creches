<?php

class ResultAcheteursController {

    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $interetCrecheManager;
    private $interetGroupeManager;
    private $interetVilleManager;
    private $interetDepartementManager;
    private $interetRegionManager;
    private $interetFranceManager;
    private $interetTailleManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->interetVilleManager = new InteretVilleManager();
        $this->interetDepartementManager = new InteretDepartementManager();
        $this->interetRegionManager = new InteretRegionManager();
        $this->interetFranceManager = new InteretFranceManager();
        $this->interetTailleManager = new InteretTailleManager();
    }

    public function handleResearchAcheteur(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;

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
                    // Récupérer l'idContact
                    $idContact = $contact->getIdContact();
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idContact'])) {
            $idContact = (int) $_GET['idContact'];
        }

        $this->showResultAcheteur($idContact);
    }

    public function showResultAcheteur($idContact) {

        //Récupérer les données du contact
        $contact = $this->contactManager->getContactById($idContact);
        
        // Récupérer les commentaires du contact
        $commentaires = $this->commentManager->extractComments($idContact);

        //Récupérer les localisations du contact
        $localisations = $this->localisationManager->getLocalisationsByIdContact($idContact);

        // Récupèrer le nombre de crèches de cet idContact
        $nombreCreches = $this->localisationManager->countCreches($idContact);

        //Récupérer les intérêts par idContact
        $interetsCreches = $this->interetCrecheManager->getInteretsCrechesByIdContact($idContact);

        //Récupérer les intérêts pour un groupe
        $interetsGroupes = $this->interetGroupeManager->getInteretsGroupesByIdContact($idContact);

        //Récupérer les intérêts du contact
        $interetsVilles = $this->interetVilleManager->getInteretsVillesByContact($idContact);

        $interetsDepartements = $this->interetDepartementManager->getInteretsDepartementsByIdContact($idContact);

        $interetsRegions = $this->interetRegionManager->getInteretsRegionsByContact($idContact);
        
        $hasInteretFrance = $this->interetFranceManager->hasInteretFrance($idContact);;

        $interetTaille = $this->interetTailleManager->getInteretTailleByContact($idContact);
    
        // Passer les résultats à la vue
        $view = new View();
        $view->render('resultAcheteur', [
            'idContact' =>$idContact,
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations ?? [],
            'nombreCreches' => $nombreCreches ?? [],
            'interetVilles' => $interetsVilles ?? [],
            'interetDepartements' => $interetsDepartements ?? [],
            'interetRegions' => $interetsRegions ?? [],
            'hasInteretFrance' => $hasInteretFrance,
            'interetCreches' => $interetsCreches ?? [],
            'interetsGroupes' => $interetsGroupes ?? [],
            'interetTaille' => $interetTaille ?? [],
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



