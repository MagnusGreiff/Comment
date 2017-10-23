<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

$showAll = $this->di->get("url")->create("user/all/");

$gravatar = $this->di->get("gravatar");

$commentController = $this->di->get("commentController");
$overview = $this->di->get("overviewController");
$tag = $di->url->create("tag/tag/");

?>
<div class="wrapperOverview">
    <div class="noItems">
        <?php if (!$items) : ?>
            <p>There are no items to show.</p>
            <?php return; ?>
        <?php endif; ?>
    </div>

    <div class="overviewUsersAndTags">
        <div class="overviewUsersAndTagsContent">
            <h2>Most active users</h2>
            <table>
                <tr>
                    <th>Name</th>
                </tr>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><a href="<?= $showAll . "/" . $item->id ?>"><?= $item->name ?></a></td>
                        <td><img src="<?php echo $gravatar->getGravatar($item->email, 40) ?>" alt="Image"/></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <h2>Most popular tags:</h2>
            <?php foreach ($popularTags as $t) : ?>
                <h4><a class="tag" href="<?= $tag . "/" . $overview->getCatName($t->catid) ?>"><?= $overview->getCatName($t->catid) ?></a></h4>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="overviewPosts">
        <div class="overviewPostsContent">
            <h2>Newest posts</h2>
            <?php foreach ($posts as $item) : ?>
                <?php
                $url = $di->url->create("comment/retrieve/" . $item[0]->postid);

                $tags = explode(",", $item[1][0]->Category);
                $p = "<p class=tags> Tags: ";
                foreach ($tags as $t) {
                    $id = $commentController->returnCatId($t);
                    $p .= '<a class="tag" href=' . $tag . "/" . $t .'>' . $t . '</a> ';
                }
                $p .= "</p>";
                ?>
                <div class="post">
                    <a href="<?= $url ?>">
                        <h2><?= $item[0]->posttitle ?></h2>
                    </a>
                    <?= $p ?>
                    <p class="Author">Author: <?= $item[0]->postname ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
