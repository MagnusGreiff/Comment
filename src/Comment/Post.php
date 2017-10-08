<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\Comment;

use \Anax\Database\ActiveRecordModel;

class Post extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Posts";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $posttitle;
    public $postname;
    public $posttext;

    // /**
    //  * Set the password.
    //  *
    //  * @param string $password the password to use.
    //  *
    //  * @return void
    //  */
    // public function setPassword($password)
    // {
    //     $this->password = password_hash($password, PASSWORD_DEFAULT);
    // }
    //
    //
    // /**
    //  * Verify the email and the password, if successful the object contains
    //  * all details from the database row.
    //  *
    //  * @param        $email
    //  * @param string $password the password to use.
    //  * @return bool true if email and password matches, else false.
    //  * @internal param string $email email to check.
    //  */
    // public function verifyPassword($email, $password)
    // {
    //     $this->find("email", $email);
    //     return password_verify($password, $this->password);
    // }

    public function getInformation($email)
    {
        $res = $this->find("email", $email);
        return $res;
    }
}
