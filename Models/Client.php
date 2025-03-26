<?php

include_once('AbstractEntity.php');

class Client extends AbstractEntity{

    private $idClient;
    private $idContact;
    private $statut;
    private $valorisation;
    private $commission;
    private $dateStatut;
    private $nombreCreches;
    private $contact;


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

    public function setDateStatut(string $dateStatut){
        $this -> dateStatut = $dateStatut;
    }

    public function getDateStatut ():string{
        return $this -> dateStatut;
    }

    public function getDateStatutFormatFr(): string {
        if ($this->dateStatut) {
            $date = DateTime::createFromFormat('Y-m-d', $this->dateStatut);
            return $date ? $date->format('d-m-Y') : "";
        }
        return "";
    }

    public function setNombreCreches(int $nombreCreches){
        $this -> nombreCreches = $nombreCreches;
    }

    public function getNombreCreches():int{
        return $this -> nombreCreches;
    }

    public function setContact(Contact $contact){
        $this -> contact = $contact;
    }

    public function getContact():Contact{
        return $this -> contact;
    }
}