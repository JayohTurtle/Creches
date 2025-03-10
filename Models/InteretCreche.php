<?php

include_once('AbstractEntity.php');

class InteretCreche extends AbstractEntity{

    private $idInteretCreche;
    private $idContact;
    private $niveau;
    private $idLocalisation;
    private $identifiant;
    private $dateColonne;
    

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

    public function setDateColonne (string $dateColonne){
        $this -> dateColonne = $dateColonne;
    }

    public function getDateColonne ():string{
        return $this -> dateColonne;
    }

    public function getDateColonneFormatFr(): string {
        if ($this->dateColonne) {
            $date = DateTime::createFromFormat('Y-m-d', $this->dateColonne);
            return $date ? $date->format('d-m-Y') : "";
        }
        return "";
    }

    public function setIdLocalisation(int $idLocalisation){
        $this -> idLocalisation = $idLocalisation;
    }

    public function getIdLocalisation ():int{
        return $this -> idLocalisation;
    }

    public function setIdentifiant (string $identifiant){
        $this -> identifiant = $identifiant;
    }

    public function getIdentifiant ():string{
        return $this -> identifiant;
    }
}