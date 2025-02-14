<?php

include_once('AbstractEntity.php');

class InteretTaille extends AbstractEntity{

    private $idInteretTaille;
    private $idContact;
    private $taille;

    public function setIdInteretTaille(int $idInteretTaille):void{
        $this -> idInteretTaille = $idInteretTaille;
    }

    public function getIdInteretTaille ():int{
        return $this -> idInteretTaille;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setTaille (string $taille){
        $this -> taille = $taille;
    }

    public function getTaille ():string{
        return $this -> taille;
    }
}