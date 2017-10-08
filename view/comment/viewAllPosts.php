<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

$url = $this->di->get("url")->create("comment/newPost");

?>
<div class="wrapper"><h1>Posts</h1>
    <?php if (!$items) : ?>
        <p>There are no items to show.</p>
        <?php return; ?>
    <?php endif; ?>

    <p>Create  new post: <a href="<?= $url ?>">Click here.</a></p>

    <?php foreach ($items as $item) : ?>
        <?php
        $url = $di->url->create("comment/retrieve/$item->id");
        ?>
        <div class="post">
            <a href="<?= $url ?>">
                <h2>Title: <?= $item->posttitle ?></h2>
            </a>
            <p>Text: <?= $item->posttext ?></p>
            <p>Author: <?= $item->postname ?></p>
        </div>
    <?php endforeach; ?>
</div>
