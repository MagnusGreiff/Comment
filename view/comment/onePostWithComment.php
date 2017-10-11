<?php
$createNewComment = $di->url->create("comment/newComment");
$login = $di->url->create("user/login");
$currentUser = $di->get("session")->has("email") ? $di->get("session")->get("email") : "";
$deleteComment = $di->url->create("comment/deleteComment");
$editComment = $di->url->create("comment/editComment");


var_dump($comment);
?>

<main class="postsAndComments">
    <div class="posts">
        <h1>Post:</h1>
        <h5>Title: <?= $post->posttitle ?></h5>
        <p>Text: <?= $post->posttext ?></p>
        <p>Author: <?= $post->postname ?></p>
    </div>
    <div>
        <?php if ($this->di->get("session")->has("email")) : ?>
            <h4 class="createComment">Create <a href="<?= $createNewComment . "/" . $post->id ?>">New Comment</a>
            </h4>
        <?php else : ?>
            <h4 class="createComment">Login to create new comment. <a href="<?= $login ?>">Click here</a></h4>
        <?php endif ?>
    </div>
    <div class="comments">
        <?php foreach ($comments as $con => $value) : ?>
            <?php
            $email = $value->Author;
            $default = "http://www.student.bth.se/~magp16/dbwebb-kurser/design/me/anax-flat/htdocs/img/image1.jpeg";
            $size = 40;
            $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=wavatar" . urlencode($default) . "&s=" . $size;
            ?>
            <div>
                <h5>Text: <?= $value->commenttext ?></h5>
                <h6>Author: <?= $value->Author ?></h6>
                <img src="<?php echo $grav_url; ?>" alt=""/>
                <?php if ($currentUser === $value->Author || $permissions === "admin") : ?>
                    <a href="<?= $deleteComment . "/$value->idcomment" ?>">Delete Comment</a>
                    <a href="<?= $editComment . "/$value->idcomment" ?>">Edit Comment</a>
                <?php endif ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
