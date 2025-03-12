<?php

class ResultTailleController{

    public function showResultTaille(){
        $view = new View();
        $view -> render('researchResultTaille', []);

    }
    
}