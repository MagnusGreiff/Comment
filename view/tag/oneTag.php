<?php

namespace Anax\View;

$content = isset($content) ? $content : null;


$showAll = $this->di->get("url")->create("user/all/");

$gravatar = $this->di->get("gravatar");

?>

<div class="oneTagWrapper">

    <div class="noItems">
        <?php if (!$content) : ?>
            <p>There are no tag with that name.</p>
            <?php return; ?>
        <?php endif; ?>
    </div>

    <h1>All posts that have the tag: <?= $content[0]->Category ?></h1>
    <div class="oneTagContent">
        <?php foreach ($content as $c) : ?>
            <?php
            $url = $di->url->create("comment/retrieve/$c->postid");
            ?>
            <div class="post">
                <a href="<?= $url ?>">
                    <h2><?= $c->posttitle ?></h2>
                </a>
                <p><?= substr($c->posttext, 0, 50); ?></p>
                <p>Author: <?= $c->postname ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
