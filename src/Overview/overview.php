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
        $sql = "Call VPost(null, null, 'desc', null, null)";
        $res = $post->findAllSql($sql);
        $post->getNext();
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
        $sql = "Call VCategory(?)";
        $res = $post->findAllSql($sql, $id);
        $post->getNext();
        return $res;
    }


    public function returnPopularTags($db)
    {
        $post = new Post();
        $post->setDb($db);
        $sql = "Call PopularTags()";
        $res = $post->findAllSql($sql);
        $post->getNext();
        return $res;
    }
}
