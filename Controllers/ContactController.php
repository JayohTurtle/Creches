<?php

class ContactController {

    private $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();

    }
    public function selectSens(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['idContact'])) {
                $idContact = (int) $_POST['idContact'];
            }
            
            if (isset($_POST['sens'])) {
                $sens = $_POST['sens'];
            }

            if ($sens === 'Acheteur') {
                $url = "index.php?action=resultAcheteur&idContact=" . urlencode($idContact) . "&sens=" . urlencode($sens);

                header("Location: $url");
                exit();
            } else {
                $url = "index.php?action=resultClient&idContact=" . urlencode($idContact) . "&sens=" . urlencode($sens);

                header("Location: $url");
                exit();
            }
        }
        
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