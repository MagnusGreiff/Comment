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
}
