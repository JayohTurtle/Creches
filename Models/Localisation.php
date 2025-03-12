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
    private $region;
    private ?Ville $ville = null;   
    private ?Departement $departement = null;
    private $distance;
    private $idGroupe;
    private $distanceKm;
    private array $interets = []; // Stocke les intérêts

    public function setInterets(array $interets) {
        $this->interets = $interets;
    }

    public function getInterets(): array {
        return $this->interets;
    }

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

    public function getVille(): ?Ville {
        return $this->ville;
    }

    public function setVille(Ville $ville): void {
        $this->ville = $ville;
    }

    public function getDepartement(): ?Departement {
        return $this->departement;
    }

    public function setDepartement(Departement $departement): void {
        $this->departement = $departement;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setRegion($region){
        $this->region = $region;
    }

    public function setIdVille(int $idVille) {
        $this->idVille = $idVille;
    }

    public function getIdVille(): int {
        return $this->idVille;
    }

    public function setDistanceKm($distanceKm) {
        $this->idVille = $distanceKm;
    }

    public function getDistanceKm(){
        return $this->distanceKm;
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
}

