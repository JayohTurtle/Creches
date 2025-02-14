<?php

include_once('DBManager.php');

abstract class AbstractEntityManager{
//model = gestion des données
    public $db;

    public function __construct(){
        $this ->db = DBManager :: getInstance();
        
    }
}