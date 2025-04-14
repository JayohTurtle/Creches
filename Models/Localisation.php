<?php

include_once('AbstractEntity.php');

class Localisation extends AbstractEntity {

    private $idLocalisation;
    private $idContact;
    private $idVille;
    private $adresse;
    private $idDepartement;
    private $identifiant;
    private $taille;  
    private $distance;
    private $idGroupe;
    private $vente;
    private $location;
    private $region;
    private $departement;
    private $ville;
    private $niveau;
    private $statut;


    public function setIdLocalisation(int $idLocalisation): void {
        $this->idLocalisation = $idLocalisation;
    }

    public function getIdLocalisation(): int {
        return $this->idLocalisation;
    }

    public function setIdGroupe(int $idGroupe){
        $this -> idGroupe = $idGroupe;
    }

    public function getIdGroupe ():int{
        return $this -> idGroupe;
    }

    public function setIdContact(int $idContact) {
        $this->idContact = $idContact;
    }

    public function getIdContact(): int {
        return $this->idContact;
    }

    public function setIdVille(int $idVille) {
        $this->idVille = $idVille;
    }

    public function getIdVille(): int {
        return $this->idVille;
    }

    public function setAdresse(string $adresse) {
        $this->adresse = $adresse;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function setIdDepartement(int $idDepartement) {
        $this->idDepartement = $idDepartement;
    }

    public function getIdDepartement(): int {
        return $this->idDepartement;
    }

    public function setIdentifiant(string $identifiant) {
        $this->identifiant = $identifiant;
    }

    public function getIdentifiant(): string {
        return $this->identifiant;
    }

    public function setTaille(string $taille) {
        $this->taille = $taille;
    }

    public function getTaille(): string {
        return $this->taille;
    }

    public function setDistance( $distance) {
        $this->distance = $distance;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function setVente( $vente) {
        $this->vente = $vente;
    }

    public function getVente() {
        return $this->vente;
    }

    public function setLocation( $location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setRegion( $region) {
        $this->region = $region;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setDepartement( $departement) {
        $this->departement = $departement;
    }

    public function getDepartement() {
        return $this->departement;
    }

    public function setVille( $ville) {
        $this->ville = $ville;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setNiveau( $niveau) {
        $this->niveau = $niveau;
    }

    public function getNiveau() {
        return $this->niveau;
    }

    public function setStatut( $statut) {
        $this->statut = $statut;
    }
    
    public function getStatut() {
        return $this->statut;
    }
}