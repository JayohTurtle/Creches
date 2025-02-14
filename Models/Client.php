<?php

include_once('AbstractEntity.php');

class Client extends AbstractEntity{

    private $idClient;
    private $idContact;
    private $statut;
    private $valorisation;
    private $commission;
    private $nom;
    private $identifiant;
    

    public function setIdClient(int $idClient):void{
        $this -> idClient = $idClient;
    }

    public function getIdClient ():int{
        return $this -> idClient;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setStatut (string $statut){
        $this -> statut = $statut;
    }

    public function getStatut ():string{
        return $this -> statut;
    }
    

    public function setValorisation (int $valorisation){
        $this -> valorisation = $valorisation;
    }

    public function getValorisation ():int{
        return $this -> valorisation;
    }

    public function setCommission (int $commission){
        $this -> commission = $commission;
    }

    public function getCommission ():int{
        return $this -> commission;
    }

    public function setNom (string $nom){
        $this -> nom = $nom;
    }

    public function getNom ():string{
        return $this -> nom;
    }

    public function setIdentifiant(string $identifiant){
        $this -> identifiant = $identifiant;
    }

    public function getIdentifiant ():string{
        return $this -> identifiant;
    }

    
}