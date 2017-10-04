<?php
$createNewComment = $di->url->create("comment/newComment");
$login = $di->url->create("user/login");
$currentUser = $di->get("session")->has("name") ? $di->get("session")->get("name") : "";
$deleteComment = $di->url->create("comment/deleteComment");
$editComment = $di->url->create("comment/editComment");


if ($content[2] instanceof stdClass) {
    $permission = $content[2]->permissions;
} else {
    $permission = $content[2]["permissions"];
}

?>

<main class="postsAndComments">
    <div class="posts">
        <h1>Post:</h1>
        <h5>Title: <?= $content[0]->posttitle ?></h5>
        <p>Text: <?= $content[0]->posttext ?></p>
        <p>Author: <?= $content[0]->postname ?></p>
    </div>
    <div>
        <?php if ($this->di->get("session")->has("name")) : ?>
            <h4 class="createComment">Create <a href="<?= $createNewComment . "/" . $content[0]->id ?>">New Comment</a>
            </h4>
        <?php else : ?>
            <h4 class="createComment">Login to create new comment. <a href="<?= $login ?>">Click here</a></h4>
        <?php endif ?>
    </div>
    <div class="comments">
        <?php foreach ($content[1] as $con => $value) : ?>
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
                <?php if ($currentUser === $value->Author || $permission === "admin") : ?>
                    <a href="<?= $deleteComment . "/$value->idcomment" ?>">Delete Comment</a>
                    <a href="<?= $editComment . "/$value->idcomment" ?>">Edit Comment</a>
                <?php endif ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
