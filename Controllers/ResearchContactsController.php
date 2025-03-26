<?php
class ResearchContactsController {
    private $commentManager;
    private $contactManager;
    private $localisationManager;

    public function __construct() {
        $this->commentManager = new CommentManager();
        $this->contactManager = new ContactManager();
        $this->localisationManager = new LocalisationManager();
    }

    public function handleResearchContacts() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
    
            foreach ($donnees as $champ => $valeur) {
                if (!empty($valeur)) {
                    $donneeRecherchee = $champ;
                    $valeurRecherchee = $valeur;
                    break;
                }
            }
    
            $contact = null;
            $localisations = null;
            $commentaires = null;
    
            if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
                // Récupérer un SEUL contact
                $contact = $this->contactManager->extractResearchContact($donneeRecherchee, $valeurRecherchee);
                
                if ($contact && method_exists($contact, 'getIdContact')) {
                    $idContact = $contact->getIdContact();
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idContact'])) {
            $idContact = (int) $_GET['idContact'];
            $contact = $this->contactManager->getContactByIdContact($idContact);
        }

        $localisations = $this->localisationManager->getLocalisationsByIdContact($idContact);
        $commentaires = $this->commentManager->getCommentsByIdContact($idContact);

        // Passer les résultats à la vue
        $view = new View();
        $view->render('researchContacts', [
            'idContact' =>$idContact,
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations,
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