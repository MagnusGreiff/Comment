<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$post = isset($posts) ? $posts : null;

$comment = isset($comments) ? $comments : null;


$postUrl = $this->di->get("url")->create("comment/retrieve/");

?>


<div class="wrapper"><h1>All the things</h1>

    <h2>Posts</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Button</th>
            </tr>
            <?php foreach ($posts as $p) : ?>
                <tr>
                    <td><?= $p->posttitle ?></td>
                    <td><a href="<?= $postUrl . "/$p->id" ?>">Check post</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

    <h2>Comments</h2>
        <table>
            <tr>
                <th>Comment</th>
                <th>Post</th>
                <th>Button</th>
            </tr>
            <?php foreach ($comment as $c) : ?>
                <tr>
                    <td><?= $c->commenttext ?></td>
                    <td><?= $c->idpost ?></td>
                    <td><a href="<?= $postUrl . "/$c->idpost" ?>">Check Comment</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
</div>
