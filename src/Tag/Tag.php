<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\Tag;

use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Anax\Database\ActiveRecordModel;

class Tag extends ActiveRecordModel implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function returnAllSpecificTag($tag)
    {
        $sql = "Call VPost(false, 1, 'true', ? , null)";
        $res = $this->findAllSql($sql, [$tag]);
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


    public function returnAllTags()
    {
        $sql = "Call GetPostCategory()";
        //$sql = "SELECT Category FROM PostCategory";
        $res = $this->findAllSql($sql);
        return $res;
    }
}
