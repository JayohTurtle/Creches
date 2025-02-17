<?php

class ResearchContactController{

    private $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
    }

    public function showResultContact(){
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
    
            $contact = null; // Initialisation
    
            if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
                // Récupérer un SEUL contact
                $contact = $this->contactManager->extractResearchContact($donneeRecherchee, $valeurRecherchee);
            }
    
            // Passer les résultats à la vue
            $view = new View();
            $view->render('researchResultContact', ['contact' => $contact]);
        }
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


