<?php
$createPost = $di->url->create("comment/newPost");
?>
<main class="mainPost">
    <div class="createPost">
       <!-- --><?php /*if ($this->di->get("session")->has("name")) :*/?>
        <h4>Create <a href="<?= $createPost ?>">New Post</a></h4>
<!--        --><?php /*endif */?>
    </div>

    <?php foreach ($content as $con) : ?>
        <?php
        $url = $di->url->create("comment/retrieve/$con->id");
        ?>
        <div class="post">
            <a href="<?= $url ?>">
                <h2>Title: <?= $con->posttitle ?></h2>
            </a>
            <p>Text: <?= $con->posttext ?></p>
            <p>Author: <?= $con->postname ?></p>
        </div>
    <?php endforeach; ?>
</main>
