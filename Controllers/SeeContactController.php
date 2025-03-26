<?php

class SeeContactController {

    private $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();

    }
    public function selectSens(){
        $requestData = array_merge($_GET, $_POST);

        if (isset($requestData['idContact'])) {
            $idContact = (int) $requestData['idContact'];
        }
        if (isset($requestData['sens'])) {
            $sens = $requestData['sens'];
        }

        if ($sens === 'Acheteur') {
            $url = "index.php?action=researchAcheteurs&idContact=" . urlencode($idContact) . "&sens=" . urlencode($sens);

            header("Location: $url");
            exit();
        } elseif($sens === 'Vendeur') {
            $url = "index.php?action=researchVendeurs&idContact=" . urlencode($idContact) . "&sens=" . urlencode($sens);

            header("Location: $url");
            exit();
        }else{
            $url = "index.php?action=researchContacts&idContact=" . urlencode($idContact) . "&sens=" . urlencode($sens);

            header("Location: $url");
            exit();

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