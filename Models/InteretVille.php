<?php

include_once('AbstractEntity.php');

class InteretVille extends AbstractEntity{

    private $idInteretVille;
    private $idContact;
    private $idVille;
    private $taille;
    private $rayon;


    public function setIdInteretVille(int $idInteretVille):void{
        $this -> idInteretVille = $idInteretVille;
    }

    public function getIdInteretVille ():int{
        return $this -> idInteretVille;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setIdVille (?int $idVille){
        $this -> idVille = $idVille;
    }

    public function getIdVille ():?int{
        return $this -> idVille;
    }

    public function setRayon (int $rayon){
        $this -> rayon = $rayon;
    }

    public function getRayon ():int{
        return $this -> rayon;
    }
    
}