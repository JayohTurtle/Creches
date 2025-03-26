<?php

class ModifValorisationController {

    private $clientManager;

    public function __construct() {
        $this->clientManager = new ClientManager();
    }

    public function handleModifValorisation() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
            $valorisation = $_POST["infoValorisation"];
    
            $result = $this->clientManager->modifValorisation($idContact, $valorisation);

            if ($result) {
                // Réponse en cas de succès
                echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
                exit;
            } else {
                // Si l'insertion a échoué
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'intérêt']);
            }
        }
    }
}