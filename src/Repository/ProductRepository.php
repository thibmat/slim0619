<?php
namespace App\Repository;

use App\Entity\Produit;
use App\Utilities\Database;

class ProductRepository
{
    /**
     * @var string Nom de la table en BDD
     */
    const tableName = 'produit';
    /**
     * @var database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array|null
     */
    public function findAll():?array
    {
        return $this->database->query("SELECT * FROM produit", self::tableName);
    }
    public function findById(int $id):?Produit
    {
        $theoricProduct = $this->database->prepared("SELECT * FROM produit WHERE id = ?",self::tableName,[$id]);
        return $theoricProduct ? $theoricProduct : null;
    }
    public function deleteById(array $id):int
    {
        $status = $this->database->exec("DELETE FROM produit WHERE id= ?", $id);
        return $status;
    }
}