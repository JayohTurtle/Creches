<?php

include_once('AbstractEntity.php');

class Interet extends AbstractEntity{

    private $idInteret;
    private $idContact;
    private $idVille;
    private $idDepartement;
    private $idRegion;
    private $taille;
    private $rayon;


    public function setIdInteret(int $idInteret):void{
        $this -> idInteret = $idInteret;
    }

    public function getIdInteret ():int{
        return $this -> idInteret;
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

    public function setIdDepartement (?int $idDepartement){
        $this -> idDepartement = $idDepartement;
    }

    public function getIdDepartement ():?int{
        return $this -> idDepartement;
    }
    
    public function setIdRegion (?int $idRegion){
        $this -> idRegion = $idRegion;
    }

    public function getIdRegion ():?int{
        return $this -> idRegion;
    }

    public function setTaille (string $taille){
        $this -> taille = $taille;
    }

    public function getTaille ():string{
        return $this -> taille;
    }

    public function setRayon (int $rayon){
        $this -> rayon = $rayon;
    }

    public function getRayon ():int{
        return $this -> rayon;
    }
    
}