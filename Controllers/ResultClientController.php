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
    
        $localisations = null;

        if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
            // Récupérer l'objet client
            $contact = $this->contactManager->extractResearchContact($donneeRecherchee, $valeurRecherchee);

            if ($contact && method_exists($contact, 'getIdContact')) {
                // Récupérer l'idContact
                $idContact = $contact->getIdContact();
                }
            }

            //Récupérer les données du contact
            $contact = $this->contactManager->getContactById($idContact);
            
            // Récupérer les commentaires du contact
            $commentaires = $this->commentManager->extractComments($idContact);

            //Récupérer les localisations du contact
            $localisations = $this->localisationManager->getLocalisationsByIdContact($idContact);
            
            // Récupérer les attributs vendeurs
            $clientData = $this->clientManager->getDataClientsById($idContact);

            // Récupèrer le nombre de crèches de cet idContact
            $nombreCreches = $this->localisationManager->countCreches($idContact);
    
            // Récupérer idLocalisation pour bascule vers interetCreche
            $idLocalisations = array_map(fn($loc) => (int) $loc->getIdLocalisation(), $localisations);
            
            // Récupérer les intérêts sur les localisations
            $interetsLocalisations = $this->interetCrecheManager->getInteretsByIdLocalisation($idLocalisations);
            // Indexer les intérêts par idLocalisation
            $interetsParLocalisation = [];
            foreach ($interetsLocalisations as $interet) {
                $interetsParLocalisation[$interet->getIdLocalisation()][] = $interet;
            }

            $acheteurs = [];
            if (!empty($interetsLocalisations)) {
                // Récupérer les ID des acheteurs
                $idAcheteurs = array_unique(array_map(fn($interet) => (int) $interet->getIdContact(), $interetsLocalisations));
                
                // Itérer sur chaque idAcheteur pour récupérer leurs informations
                foreach ($idAcheteurs as $idContact) {
                    // Appeler la méthode getAcheteursById pour chaque idContact
                    $acheteur = $this->contactManager->getAcheteursById($idContact);
                    
                    // Vérifier si l'acheteur existe avant de l'ajouter au tableau
                    if ($acheteur !== null) {
                        $acheteurs[] = $acheteur; // Ajouter l'acheteur au tableau
                    }
                }
            
                // Indexer les acheteurs par ID après avoir récupéré tous les acheteurs
                $acheteursParId = [];
                foreach ($acheteurs as $acheteur) {
                    $acheteursParId[$acheteur->getIdContact()] = $acheteur;
                }
            }

            // Ajouter les intérêts et acheteurs aux localisations
            $localisationsFinales = [];
            foreach ($localisations as $loc) {
                $idLoc = $loc->getIdLocalisation();
                $interets = $interetsParLocalisation[$idLoc] ?? [];

                // Associer les acheteurs aux intérêts
                $acheteursAssocies = [];
                foreach ($interets as $interet) {
                    $idAcheteur = $interet->getIdContact();
                    if (isset($acheteursParId[$idAcheteur])) {
                        $acheteursAssocies[] = $acheteursParId[$idAcheteur];
                    }
                }

                // Construire la structure finale
                $localisationsFinales[] = [
                    'localisation' => $loc,
                    'interets' => $interets,
                    'acheteurs' => $acheteursAssocies
                ];
            }

        // Passer les résultats à la vue
        $view = new View();
        $view->render('resultClient', [
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations,
            'clientData' => $clientData,
            'localisationsFinales' => $localisationsFinales,
            'nombreCreches' => $nombreCreches
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
