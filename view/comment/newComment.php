<?php

$url = $di->request->getCurrentUrl();
$end = basename($url);

$urlToPost = $di->url->create("comment/submitComment/$end")

?>

<form action="<?= $urlToPost ?>" method="post">
    <label for="text">Text</label>
    <input type="text" name="text" id="text">
    <input type="hidden" name="id" value="<?= $end ?>">
    <input type="submit" value="Lägg till kommentar">
</form>
