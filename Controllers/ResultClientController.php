<?php

class ResultClientController{

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

    public function handleResearchClient(){
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
            $client = $this->contactManager->getContactById($idContact);
            //Dans clients
            $clientData = $this->clientManager->getDataClientsById($idContact);
            // Récupèrer le nombre de crèches du client
            $nombreCreches = $this->localisationManager->countCreches($idContact);
            // Récupérer les commentaires du client
            $commentaires = $this->commentManager->extractComments($idContact);

            //Récupérer les localisations du contact
            $localisations = $this->localisationManager->getLocalisationsByIdContact($idContact);
            // Récupérer les idLocalisation pour bascule vers interetCreche
            $idLocalisations = array_map(fn($loc) => (int) $loc->getIdLocalisation(), $localisations);
           
            // Récupérer les intérêts sur les localisations            
            $interetsCreche = $this->interetCrecheManager->getInteretsCrecheByIdLocalisations($idLocalisations);
            
            if (!empty($interetsCreche) && $interetsCreche[0] instanceof InteretCreche) {
                $idGroupe = $interetsCreche[0]->getLocalisation()->getIdGroupe();
                // Récupérer les intérêts sur le groupe
                $interetsGroupe = $this->interetGroupeManager->getInteretsGroupeByIdGroupe($idGroupe);
            } else {
                $interetsGroupe = null;
            }      

            // Passer les résultats à la vue
            $view = new View();
            $view->render('resultClient', [
                'client'=> $client,
                'clientData'=> $clientData,
                'commentaires'=> $commentaires,
                'localisations'=> $localisations,
                'interetsCreche'=> $interetsCreche,
                'interetsGroupe'=> $interetsGroupe,
                'nombreCreches'=> $nombreCreches,
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
