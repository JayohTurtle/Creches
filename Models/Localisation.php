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
    private ?Ville $ville = null;   
    private ?Departement $departement = null;
    private $distance;

    public function setIdLocalisation(int $idLocalisation): void {
        $this->idLocalisation = $idLocalisation;
    }

    public function getIdLocalisation(): int {
        return $this->idLocalisation;
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
}

