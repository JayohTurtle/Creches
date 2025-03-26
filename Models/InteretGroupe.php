<?php

include_once('AbstractEntity.php');

class InteretGroupe extends AbstractEntity{

    private $idInteretGroupe;
    private $idContact;
    private $niveau;
    private $idGroupe;
    private $dateInteret;

    public function getIdGroupe(){
        return $this->idGroupe;
    }

    public function setIdGroupe($idGroupe) {
        $this->idGroupe = $idGroupe;
    }

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

    public function setDateInteret (string $dateInteret){
        $this -> dateInteret = $dateInteret;
    }

    public function getDateInteret ():string{
        return $this -> dateInteret;
    }

    public function getDateInteretFormatFr() {
        if (!empty($this->dateInteret)) {
            return date("d-m-Y", strtotime($this->dateInteret)); // Format JJ/MM/AAAA
        }
        return null; // Retourne null si la date est vide
    }
}