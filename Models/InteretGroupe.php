<?php

include_once('AbstractEntity.php');

class InteretGroupe extends AbstractEntity{

    private $idInteretGroupe;
    private $idContact;
    private $niveau;

    public function setIdInteretGroupe(int $idInteretGroupe):void{
        $this -> idInteretGroupe = $idInteretGroupe;
    }

    public function getIdInteretGroupe ():int{
        return $this -> idInteretGroupe;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setNiveau (string $niveau){
        $this -> niveau = $niveau;
    }

    public function getniveau ():string{
        return $this -> niveau;
    }
}