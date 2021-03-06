<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$post = isset($posts) ? $posts : null;

$comment = isset($comments) ? $comments : null;


$postUrl = $this->di->get("url")->create("comment/retrieve/");

?>


<div class="allWrapper">
    <div class="allContent">
        <h1>All the things</h1>
        <div class="allPostContent">
            <h2>Posts</h3>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Button</th>
                    </tr>
                    <?php foreach ($posts as $p) : ?>
                        <tr>
                            <td><?= $p->posttitle ?></td>
                            <td><a class="allPostLink" href="<?= $postUrl . "/$p->id" ?>">Check post</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
        </div>
        <div class="allCommentContent">
            <h2>Comments</h2>
                <table>
                    <tr>
                        <th>Comment</th>
                        <th>Post</th>
                    </tr>
                    <?php foreach ($comment as $c) : ?>
                        <tr>
                            <td><?= $c->commenttext ?></td>
                            <td><a class="allCommentLink" href="<?= $postUrl . "/$c->idpost" ?>">Check Comment</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
        </div>
    </div>
</div>
