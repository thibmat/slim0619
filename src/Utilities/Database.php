<?php
namespace App\Utilities;

use PDO;

/**
 * Cette classe utilise PDO afin d'effectuer des opérations sur la BDD
 */
class Database
{
    /**
     * Instance de PDO
     * @var PDO
     */
    private $pdo;
    public function __construct()
    {
        $this->connect();
    }
    /**
     * Creer une instance de PDO
     */
    public function connect():void
    {
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=catalogue',
                'root',
                '',
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
    }
    /**
     * @param string $sql
     * @param string $className
     * @return array|null
     */
    public function query(string $sql, ?string $className=''): ?array
    {
        if ($className != '') {
            $result = $this->pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);
        }else{
            $result = $this->pdo->query($sql);
            return $result->fetchAll();
        }
    }

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

    /**
     * Requete SQL pour la création, la modification, l'update et la suppression
     * @param string $sql
     * @return int
     */
    public function exec(string $sql):int
    {
        return $this->pdo->exec($sql);
    }
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
}