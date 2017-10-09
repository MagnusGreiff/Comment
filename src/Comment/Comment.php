<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\Comment;

use \Anax\Database\ActiveRecordModel;

class Comment extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $idcomment;
    public $commenttext;
    public $idpost;
    public $postuser;

    public function getInformation($email)
    {
        $res = $this->find("postuser", $email);
        return $res;
    }
}
