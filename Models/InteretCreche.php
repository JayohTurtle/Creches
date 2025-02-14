<?php

include_once('AbstractEntity.php');

class InteretCreche extends AbstractEntity{

    private $idInteretCreche;
    private $idContact;
    private $niveau;
    private $idIdentifiant;
    

    public function setIdInteretCreche(int $idInteretCreche):void{
        $this -> idInteretCreche = $idInteretCreche;
    }

    public function getIdInteretCreche ():int{
        return $this -> idInteretCreche;
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

    public function getNiveau ():string{
        return $this -> niveau;
    }

    public function setIdIdentifiant(int $idIdentifiant){
        $this -> idIdentifiant = $idIdentifiant;
    }

    public function getIdIdentifiant ():int{
        return $this -> idIdentifiant;
    }
}