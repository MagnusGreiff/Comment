<?php

$urlToPost = $di->url->create("comment/submit");
?>

<form action="<?= $urlToPost ?>" method="post">
    <label for="title">Title</label>
    <input type="text" name="title" id="title">
    <label for="text">Text</label>
    <input type="text" name="text" id="text">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <input type="submit" value="Posta Inlägg">
</form>
