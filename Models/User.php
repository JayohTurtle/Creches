<?php

include_once('AbstractEntity.php');

class User extends AbstractEntity {

    private $idUser;
    private $email;
    private $password;

    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }
}