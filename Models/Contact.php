<?php

include_once('AbstractEntity.php');

class Contact extends AbstractEntity{

    private $idContact;
    private $nom;
    private $contact;
    private $siren;
    private $email;
    private $telephone;
    private $siteInternet;
    private $sens;

    public function setIdContact(int $idContact):void{
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setNom (string $nom){
        $this -> nom = $nom;
    }

    public function getNom ():string{
        return $this -> nom;
    }

    public function setContact (string $contact){
        $this -> contact = $contact;
    }

    public function getContact ():string{
        return $this -> contact;
    }

    public function setSiren (string $siren){
        $this -> siren = $siren;
    }

    public function getSiren ():string{
        return $this -> siren;
    }

    public function setEmail (string $email){
        $this -> email = $email;
    }

    public function getEmail ():string{
        return $this -> email;
    }

    public function setTelephone (string $telephone){
        $this -> telephone = $telephone;
    }

    public function getTelephone ():string{
        return $this -> telephone;
    }

    public function setSiteInternet (string $siteInternet){
        $this -> siteInternet = $siteInternet;
    }

    public function getSiteInternet ():string{
        return $this -> siteInternet;
    }

    public function setSens (string $sens){
        $this -> sens = $sens;
    }

    public function getSens ():string{
        return $this -> sens;
    }
    
}