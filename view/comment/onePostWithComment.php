<?php
$createNewComment = $di->url->create("comment/newComment");
$login = $di->url->create("user/login");
$currentUser = $di->get("session")->has("email") ? $di->get("session")->get("email") : "";
$deleteComment = $di->url->create("comment/deleteComment");
$editComment = $di->url->create("comment/editComment");
$gravatar = $this->di->get("gravatar");

$showAll = $this->di->get("url")->create("user/all/");

$createNewCommentComment = $di->url->create("comment/newCommentComment");
$deleteCommentComment = $di->url->create("comment/deleteCommentComment");
$editCommentComment = $di->url->create("comment/editCommentComment");

$userController = $this->di->get("userController");
$commentController = $this->di->get("commentController");

$tag = $di->url->create("tag/tag/");

$tags = explode(",", $tags[0]->Category);
$p = "<p> Tags: ";
foreach ($tags as $t) {
    //$id = $commentController->returnCatId($t);
    $p .= '<a class="tag" href=' . $tag . "/" . $t .'>' . $t . '</a> ';
}
$p .= "</p>";
?>

<main class="postsAndComments">
    <div class="posts">
        <h1><?= $post[0]->posttitle ?></h5>
        <div class="postContent"><?= $post[0]->posttext ?></div>
        <p><a class="poster" href="<?= $showAll . "/" . $userController->returnId($post[0]->postname) ?>"><?= $post[0]->postname ?></a></p>
        <?= $p ?>
        <img src="<?php echo $gravatar->getGravatar($post[0]->postname, 40); ?>" alt=""/>
        <hr>
    </div>
    <div>
        <?php if ($this->di->get("session")->has("email")) : ?>
            <h4 class="createComment"> <a href="<?= $createNewComment . "/" . $post[0]->postid ?>">Create new comment</a>
            </h4>
        <?php else : ?>
            <h4 class="createComment">Login to create new comment. <a href="<?= $login ?>">Click here</a></h4>
        <?php endif ?>
    </div>
    <div class="comments">
        <?php foreach ($comments as $con => $value) : ?>
            <div class="test">
                <div class="commenttext"><?= wordwrap($value[0]->commenttext, 200, "<br />\n"); ?></div>

                <p class="commentPoster"><a href="<?= $showAll . "/" . $userController->returnId($value[0]->Author) ?>"><?= $value[0]->Author ?></a></p>
                <img src="<?php echo $gravatar->getGravatar($value[0]->Author, 40); ?>" alt=""/>
                <?php if ($currentUser === $value[0]->Author || $permissions === "admin") : ?>
                    <a class="adminLinks" href="<?= $deleteComment . "/" . $value[0]->idcomment ?>">Delete Comment</a>
                    <a class="adminLinks" href="<?= $editComment . "/" . $value[0]->idcomment ?>">Edit Comment</a>
                <?php endif ?>
                <a class="newCommentLink" href="<?= $createNewCommentComment . "/" . $value[0]->idcomment . "/" . $post[0]->postid ?>">Add new Comment</a>

                    <?php foreach ($value[1] as $v) : ?>
                        <div class="commentcomments">
                            <div class="commenttext"><?= wordwrap($v->textcomment, 200, "<br />\n"); ?></div>
                            <p class="commentcommentPoster"><a href="<?= $showAll . "/" . $userController->returnId($v->postuser) ?>"><?= $v->postuser ?></a></p>
                            <img src="<?php echo $gravatar->getGravatar($v->postuser, 40); ?>" alt=""/>
                            <?php if ($currentUser === $v->postuser || $permissions === "admin") : ?>
                                <a class="adminLinks" href="<?= $deleteCommentComment . "/" . $v->idcommentc ?>">Delete Comment</a>
                                <a class="adminLinks" href="<?= $editCommentComment . "/" . $v->idcommentc ?>">Edit Comment</a>
                            <?php endif ?>
                        </div>
                    <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
