<?php

class AccueilController {

    public function showAccueil(){
        $view = new View();
        $view->render("accueil", [
        ]);
    }
}
