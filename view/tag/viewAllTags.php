<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$tags = isset($tags) ? $tags : null;

$commentController = $this->di->get("commentController");
$tagUrl = $di->url->create("tag/tag/");

?>
<div class="viewAllTagsWrapper">
    <div class="noItems">
        <?php if (!$tags) : ?>
            <p>There are no tags to show.</p>
            <?php return; ?>
        <?php endif; ?>
    </div>

    <div class="viewAllTagsContent">
        <h1>All Tags</h1>
        <h3>Click on a tag to see all post with that tag.</h3>
        <?php foreach ($tags as $tag) : ?>
            <h4>Tag: <a class="tag" href="<?= $tagUrl . "/" . $tag->Category ?>"><?= $tag->Category ?></a>: Count: <?= $tag->count ?></h4>
        <?php endforeach; ?>
    </div>
</div>
