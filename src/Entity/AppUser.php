<?php
namespace App\Entity;

class AppUser
{
    /**
     * @var int
     */
    private $user_id;
    /**
     * @var string
     */
    private $user_name;
    /**
     * @var string
     */
    private $user_mail;
    /**
     * @var string
     */
    private $user_password;
    /**
     * @var string
     */
    private $user_photo;
    /**
     * @var string
     */
    private $user_dateinscription;
    /**
     * @var int
     */
    private $user_role_role_id;


    /**
     * AppUser constructor.
     * @param string $user_name
     * @param string $user_mail
     * @param string $user_dateinscription
     * @throws \Exception
     */
    public function __construct(?string $user_name = null, ?string $user_mail = null)
    {
        $this->user_name = $user_name;
        $this->user_mail = $user_mail;
    }
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getUserMail(): string
    {
        return $this->user_mail;
    }

    /**
     * @param string $user_mail
     */
    public function setUserMail(string $user_mail): void
    {
        $this->user_mail = $user_mail;
    }

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return $this->user_password;
    }

    /**
     * @param string $user_password
     */
    public function setUserPassword(string $user_password): void
    {
        $this->user_password = password_hash($user_password,PASSWORD_DEFAULT);
    }

    /**
     * @return int
     */
    public function getUserRoleRoleId(): int
    {
        return $this->user_role_role_id;
    }

    /**
     * @param int $user_role_role_id
     */
    public function setUserRoleRoleId(int $user_role_role_id): void
    {
        $this->user_role_role_id = $user_role_role_id;
    }

    /**
     * @return string
     */
    public function getUserPhoto():string
    {
        return $this->user_photo;
    }

    /**
     * @param string $user_photo
     */
    public function setUserPhoto(string $user_photo): void
    {
        $this->user_photo = $user_photo;
    }
    /**
     * @return string
     */
    public function getUserDateinscription(): string
    {
        return $this->user_dateinscription;
    }

    /**
     * @param string $user_dateinscription
     */
    public function setUserDateinscription(string $user_dateinscription): void
    {
        $this->user_dateinscription = $user_dateinscription;
    }

}
