<?php
namespace App\Repository;

use App\Utilities\Database;
use App\Entity\AppUser;

class UserRepository
{
    /**
     * @var string Nom de la table en BDD
     */
    const tableName = 'appUser';
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
        return $this->database->query('SELECT * FROM '.self::tableName, self::tableName);
    }
    public function findByEmail(string $user_mail):?AppUser
    {
        $theoricUser = $this->database->prepared("SELECT * FROM ".self::tableName." WHERE user_mail = ?",self::tableName,[$user_mail]);
        return $theoricUser ? $theoricUser : null;
    }
    public function deleteById(array $id):int
    {
        $status = $this->database->exec("DELETE FROM ".self::tableName." WHERE id= ?", $id);
        return $status;
    }
}