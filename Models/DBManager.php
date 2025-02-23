<?php
include_once ('config.php');
class DBManager {

    private static $instance;

    private $db;

    private function __construct(){
        $this -> db = new PDO('mysql:host='. DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        $this -> db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this -> db ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO ::FETCH_ASSOC);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }

    public static function getInstance() {
        if(!self::$instance){
            self::$instance = new DBManager;
        }
        return self::$instance;
    }


        public function query(string $sql, ?array $params = null) : PDOStatement
    {
    $query = $this->db->prepare($sql);

    $query->execute($params ?? []);
    return $query;

        return $query;
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }

    // Expose la méthode prepare() pour être accessible depuis DBManager
    public function prepare($sql) {
        return $this->db->prepare($sql);
    }
}