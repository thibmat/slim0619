<?php
namespace App\Utilities;

use PDO;
use PDOException;

/**
 * Cette classe utilise PDO afin d'effectuer des opérations sur la BDD
 */
class Database
{
    private $settingsBDD;

    /**
     * Instance de PDO
     * @var PDO
     */
    private $pdo;

    public function __construct(array $settingsBDD)
    {
        $this->settingsBDD = $settingsBDD;
        $this->connect();
    }
    /**
     * Creer une instance de PDO
     */
    public function connect():void
    {
        try{
            $this->pdo = new PDO('mysql:host='.
                $this->settingsBDD['host'].';dbname='.$this->settingsBDD['dbname'],
                $this->settingsBDD['user'],
                $this->settingsBDD['password'],
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }catch(PDOException $e){
            print "Erreur!".$e->getMessage()."<br>";
            die();
        }

    }

    /**
     * @param string $sql
     * @param string|null $tableName
     * @return array|null
     */
    public function query(string $sql, ?string $tableName = null): ?array
    {
        $result = $this->pdo->query($sql);
        if ($tableName) {
            $className = "App\Entity\\".ucfirst($tableName);
            $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);
        }
        return $result->fetchAll();
    }

    /**
     * @param string $query
     * @param string|null $tableName
     * @param array|null $params
     * @return mixed
     */
    public function prepared(string $query, string $tableName = null, ?array $params = [])
    {
        $statement = $this->pdo->prepare($query);
        if ($tableName) {
            $className = "App\Entity\\".ucfirst($tableName);
            $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);
        }
        $statement->execute($params);
        return $statement->fetch();
    }

    /*
        public function queryUnique(string $sql, string $classname)
        {
            $result = $this->pdo->query($sql);
            return $result->fetchObject($classname);
        }

        public function fetch(string $sql)
        {
            $result = $this->pdo->query($sql);
            return $result->fetch();
        }
        public function fetchArray(string $sql):array
        {
            $result = $this->pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_NUM);
        }
    */
    /**
     * Requete SQL pour la création, la modification, l'update et la suppression
     * @param string $sql
     * @return int
     */

        public function exec(string $sql, ?array $param = []):int
        {
            $statement = $this->pdo->prepare($sql);
            $status = $statement->execute($param);
            return $status;
        }
        /*
        public function getStrParamsGlobalSQL(...$params): string
        {
            // On crée un tableau avec les 3 propriétés
            // $params = [
            //     htmlentities($this->username),
            //     htmlentities($this->email),
            //     htmlentities($this->password)
            // ];
            // On crée une chaîne de caractères séparés de virgules et les quotes simples

            $params = array_map(function($elem){
                return htmlentities($elem, ENT_QUOTES);
            },$params);
            $str = implode("','", $params);


            // On a ajoute une quote simple au début et une à la fin
            // On retourne l'ensemble
            return "'" .$str. "'" ;
        }
        public function __destruct()
        {
            $this->pdo = null;
        }
    */
}