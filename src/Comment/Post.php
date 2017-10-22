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

    public function getInformation($name)
    {
        $res = $this->find("postname", $name);
        return $res;
    }

    public function getAllInformationWhere($name)
    {
        $res = $this->findAllWhere("postname = ?", $name);
        return $res;
    }

    public function checkId($id)
    {
        $row = $this->find("id", $id);
        return !$row ? false : true;
    }

    public function getPostInfo($params)
    {
        $this->getNext();
        $sql = "SELECT * FROM VPost WHERE postid = ?";
        $res = $this->findAllSql($sql, $params);
        return $res;
    }

    public function getTags($params)
    {
        $sql = "SELECT Category FROM VCategory WHERE postid = ?";
        $res = $this->findAllSql($sql, $params);
        return $res;
    }

    public function getAllPosts()
    {
        $sql = "SELECT * FROM VPost";
        $res = $this->findAllSql($sql);
        $id = [];
        $newRes = [];
        foreach ($res as $r) {
            if (!in_array($r->postid, $id)) {
                array_push($id, $r->postid);
                array_push($newRes, $r);
            }
        }
        return $newRes;
    }

    public function getNext()
    {
        return $this->next();
    }
}
