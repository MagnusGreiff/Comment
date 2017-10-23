<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

$url = $this->di->get("url")->create("comment/newPost");

$commentController = $this->di->get("commentController");
$tag = $di->url->create("tag/tag/");



?>
<div class="viewAllPostsWrapper">
    <div class="noItems">
        <?php if (!$items) : ?>
            <p>There are no items to show.</p>
            <?php return; ?>
        <?php endif; ?>
    </div>

    <h1>Posts</h1>
    <p>Create  new post: <a href="<?= $url ?>">Click here.</a></p>
    <div class="viewAllPostsContent">
        <?php foreach ($items as $item) : ?>
            <?php
            $tags = explode(",", $item[1][0]->Category);
            $url = $di->url->create("comment/retrieve/" . $item[0]->postid);
            $p = "<p> Tags: ";
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
                <p>Author: <?= $item[0]->postname ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
