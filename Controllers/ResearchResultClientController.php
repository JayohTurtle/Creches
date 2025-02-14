<?php

class ResearchResultClientController{

    public function showResultClient(){
        $view = new View();
        $view -> render('researchResultClient', []);

    }
    
}