<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\Comment;

use \Anax\Database\ActiveRecordModel;

class CommentComments extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "CommentComments";
    //protected $idField = 'idcomment';

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $idcommentc;
    public $textcomment;
    public $idcommentcomment;
    public $postuser;

    public function getAllCommentFromComments($params)
    {
        $sql = "Call GetCommentsOfComments(?)";
        $res = $this->findAllSql($sql, $params);
        $this->getNext();
        return $res;
    }


    public function getNext()
    {
        return $this->next();
    }
}
