<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\Comment;

use \Anax\Database\ActiveRecordModel;

class PostCategory extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "PostCategory";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $category;


    public function getId($category)
    {
        $res = $this->find("category", $category);
        return $res->id;
    }


    public function getCatName($id)
    {
        $res = $this->find("id", $id);
        return $res->category;
    }
}
