<?php

class AccueilController {

    private $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();

    }
    public function showAccueil(){

    $contacts = $this->contactManager->getContacts();
    
    $view = new View();
    $view->render("accueil", [ 
        'contacts' => $contacts,
    ]);
    }
}

