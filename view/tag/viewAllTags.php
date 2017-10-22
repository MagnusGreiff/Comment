<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$tags = isset($tags) ? $tags : null;

$commentController = $this->di->get("commentController");
$tagUrl = $di->url->create("tag/tag/");

?>
<div class="wrapper"><h1>All Tags</h1>
    <?php if (!$tags) : ?>
        <p>There are no tags to show.</p>
        <?php return; ?>
    <?php endif; ?>

    <h3>Click on a tag to see all post with that tag.</h3>
    <?php foreach ($tags as $tag) : ?>
        <h4>Tag: <a href="<?= $tagUrl . "/" . $tag->Category ?>"><?= $tag->Category ?></a></h4>
    <?php endforeach; ?>
</div>
