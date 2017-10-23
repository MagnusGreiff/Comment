<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\User;

use \Anax\Database\ActiveRecordModel;

class User extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Users";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $name;
    public $email;
    public $age;
    public $password;
    public $created;
    public $updated;
    public $deleted;
    public $active;


    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }


    /**
     * Verify the email and the password, if successful the object contains
     * all details from the database row.
     *
     * @param        $email
     * @param string $password the password to use.
     * @return bool true if email and password matches, else false.
     * @internal param string $email email to check.
     */
    public function verifyPassword($email, $password)
    {
        $this->find("email", $email);
        return password_verify($password, $this->password);
    }

    public function getInformation($email)
    {
        $res = $this->find("email", $email);
        return $res;
    }

    public function getInformationById($id)
    {
        $res = $this->find("id", $id);
        return $res;
    }

    public function getInformationLimit($number)
    {
        $res = $this->findAllLimit($number);
        return $res;
    }

    public function returnPermissions($email)
    {
        $userInfo = $this->find("email", $email);
        $permissions = $userInfo->permissions;
        return $permissions;
    }

    public function checkUserExists($email)
    {
        $res = $this->find("email", $email);
        return !$res ? true : false;
    }
}
