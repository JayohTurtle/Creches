<?php

class ResearchVendeursController{

    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $clientManager;
    private $interetCrecheManager;
    private $interetGroupeManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
    }

    public function handleResearchVendeurs(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;

        }// Liste des champs à vérifier
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

        if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
            // Récupérer l'objet client
            $contact = $this->contactManager->extractResearchContact($donneeRecherchee, $valeurRecherchee);

            if ($contact && method_exists($contact, 'getIdContact')) {
                // Récupérer l'idContact
                $idContact = $contact->getIdContact();
            }
        }

            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idContact'])) {
                $idContact = (int) $_GET['idContact'];
        }
    
            $this->showResultClient($idContact);
    }

            public function showResultClient($idContact){

            //Récupérer les données du client
            //Dans contacts
            $client = $this->contactManager->getContactByIdContact($idContact);
            
            //Dans clients
            $clientData = $this->clientManager->getDataClientsByIdContact($idContact);
            
            // Récupèrer le nombre de crèches du client
            $nombreCreches = $this->localisationManager->countCrechesByIdContact($idContact);

            //Ajouter le nombre de crèches à l'objet clientData (Client)
            $clientData->setNombreCreches($nombreCreches);

            // Récupérer les commentaires du client
            $commentaires = $this->commentManager->getCommentsByIdContact($idContact);

            //Récupérer les localisations du contact
            $localisations = $this->localisationManager->getLocalisationsByIdContact($idContact);

            // Récupérer les idLocalisation pour bascule vers interetCreche
            $idLocalisations = array_map(fn($loc) => (int) $loc->getIdLocalisation(), $localisations);
            
            // Récupérer les intérêts sur les localisations            
            $interetsCreche = $this->interetCrecheManager->getInteretsCrecheByIdLocalisations($idLocalisations); 
        
            $formatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
            $villes = $this->villeManager->getVilles();
            $departements = $this->departementManager->getDepartements();
            $regions = $this->regionManager->getRegions();

            
            // Passer les résultats à la vue
            $view = new View();
            $view->render('researchVendeurs', [
                'idContact' => $idContact,
                'formatter'=>$formatter,
                'client'=> $client,
                'clientData'=> $clientData,
                'commentaires'=> $commentaires,
                'localisations'=> $localisations,
                'interetsCreche'=> $interetsCreche,
                'villes'=> $villes,
                'departements'=>$departements,
                'regions'=>$regions,
                'nombreCreches'=> $nombreCreches
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
