<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017-09-27
 * Time: 10:27
 */

namespace Radchasay\Overview;

use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Radchasay\User\User;
use \Radchasay\Comment\Post;

class Overview implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function returnLimitUsers($db, $order, $number)
    {
        $user = new User();
        $user->setDb($db);
        $res = $user->findAllLimitOrderBy($order, $number);
        return $res;
    }

    public function returnLimitPosts($db)
    {
        $post = new Post();
        $post->setDb($db);
        $sql = "SELECT * FROM VPost ORDER BY postid DESC";
        $res = $post->findAllSql($sql);
        $id = [];
        $newRes = [];
        $limitPost = 0;
        foreach ($res as $r) {
            if ($limitPost == 5) {
                return $newRes;
            } else {
                if (!in_array($r->postid, $id)) {
                    array_push($id, $r->postid);
                    array_push($newRes, $r);
                    $limitPost++;
                }
            }
        }
        return $newRes;
    }

    public function returnAllTagsFromPost($db, $id)
    {
        $post = new Post();
        $post->setDb($db);
        $sql = "SELECT Category FROM VCategory WHERE postid = ?";
        $res = $post->findAllSql($sql, $id);
        return $res;
    }


    public function returnPopularTags($db)
    {
        $post = new Post();
        $post->setDb($db);
        $sql = "SELECT catid, count(catid) as count FROM Post2Cat GROUP BY catid order by count desc LIMIT 5";
        $res = $post->findAllSql($sql);
        return $res;
    }
}
