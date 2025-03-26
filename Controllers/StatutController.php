<?php

class StatutController{

    private $clientManager;
    private $localisationManager;

    public function __construct() {
        $this->clientManager = new ClientManager();
        $this->localisationManager = new LocalisationManager();
    }

    public function showStatut() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $statut = $_POST['statut'];

            $clients = $this->clientManager->getClientsByStatut($statut);

            foreach ($clients as $client) {
                $idContact = $client->getIdContact();
                $nombreCreches = $this->localisationManager->countCrechesByIdContact($idContact);
                $client->setNombreCreches($nombreCreches); // ✅ Associe le nombre de crèches à l'objet Client
            }

            // Passer les résultats à la vue
            $view = new View();
            $view->render('seeStatuts', [
             'clients'=> $clients,
             'statut'=> $statut,
         ]);
        }
    }

}