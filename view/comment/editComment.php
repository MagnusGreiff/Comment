<?php

$url = $di->request->getCurrentUrl();
$end = basename($url);
$urlToPost = $di->url->create("comment/editComment/Submit/$end")

?>

<form action="<?= $urlToPost ?>" method="post">
    <label for="text">Text</label>
    <input type="text" name="text" id="text" value="<?= $content->commenttext ?>">
    <input type="hidden" name="id" value="<?= $end ?>">
    <input type="hidden" name="postid" value="<?= $content->idpost ?>">
    <input type="submit" value="Lägg till kommentar">
</form>
