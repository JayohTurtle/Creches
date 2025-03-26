<?php

class ResearchAcheteursController {

    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $interetCrecheManager;
    private $interetVilleManager;
    private $interetDepartementManager;
    private $interetRegionManager;
    private $interetFranceManager;
    private $interetTailleManager;
    private $departementManager;
    private $regionManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetVilleManager = new InteretVilleManager();
        $this->interetDepartementManager = new InteretDepartementManager();
        $this->interetRegionManager = new InteretRegionManager();
        $this->interetFranceManager = new InteretFranceManager();
        $this->interetTailleManager = new InteretTailleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
    }

    public function handleResearchAcheteurs(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Liste des champs à vérifier
            $donnees = [
                'contact' => $this->sanitizeInput($_POST['donneeContact'] ?? ''),
                'nom' => $this->sanitizeInput($_POST['donneeNomGroupe'] ?? ''),
                'email' => $this->sanitizeInput($_POST['donneeEmail'] ?? ''),
                'siren' => $this->sanitizeInput($_POST['donneeSIREN'] ?? ''),
                'telephone' => $this->sanitizeInput($_POST['donneeTelephone'] ?? ''),
                'siteInternet' => $this->sanitizeInput($_POST['donneeSiteInternet'] ?? ''),
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
        $contact = $this->contactManager->getContactByIdContact($idContact);
        
        // Récupérer les commentaires du contact
        $commentaires = $this->commentManager->getCommentsByIdContact($idContact);
        
        //Récupérer les localisations du contact
        $localisations = $this->localisationManager->getLocalisationsByIdContact($idContact);
        
        // Récupèrer le nombre de crèches de cet idContact
        $nombreCreches = $this->localisationManager->countCrechesByIdContact($idContact);

        //Récupérer les intérêts par idContact
        $interetsCreches = $this->interetCrecheManager->getInteretsCrechesByIdContact($idContact);

        //Récupérer les intérêts pour un groupe
        //$interetsGroupes = $this->interetGroupeManager->getInteretsGroupesByIdContact($idContact);

        //Récupérer les intérêts du contact
        $interetsVilles = $this->interetVilleManager->getInteretsVillesByContact($idContact);

        $interetsDepartements = $this->interetDepartementManager->getInteretsDepartementsByIdContact($idContact);

        $interetsRegions = $this->interetRegionManager->getInteretsRegionsByIdContact($idContact);
        
        $hasInteretFrance = $this->interetFranceManager->getInteretFranceByIdContact($idContact);;

        $interetTaille = $this->interetTailleManager->getInteretTailleByIdContact($idContact);
        
        //Réupérer les crèches à vendre
        $localisationsAVendre = $this->localisationManager->getLocalisationsAVendre();

        //Récupérer les départements et régions pour alimenter les formulaires
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();

        // Passer les résultats à la vue
        $view = new View();
        $view->render('researchAcheteurs', [
            'regions' => $regions,
            'departements' => $departements,
            'localisationsAVendre' => $localisationsAVendre,
            'idContact' =>$idContact,
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations,
            'nombreCreches' => $nombreCreches,
            'interetVilles' => $interetsVilles ?? [],
            'interetDepartements' => $interetsDepartements ?? [],
            'interetRegions' => $interetsRegions ?? [],
            'hasInteretFrance' => $hasInteretFrance,
            'interetsCreche' => $interetsCreches ?? [],
            'interetsGroupes' => $interetsGroupes ?? [],
            'interetTaille' => $interetTaille,
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
