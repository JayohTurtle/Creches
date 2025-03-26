<?php

class AccueilController {

    private $clientManager;

    public function __construct() {
        $this->clientManager = new ClientManager();
    }

    public function showAccueil(){

        $commissions = $this->clientManager->getCommissions();
    
    $view = new View();
    $view->render("accueil", [ 
        'commissions'=> $commissions
    ]);
    }
}
