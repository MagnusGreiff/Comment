<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

$showAll = $this->di->get("url")->create("user/all/");


$gravatar = $this->di->get("gravatar");

// Create urls for navigation

?>
<div class="showAllUsersWrapper">

    <div class="noItems">
        <?php if (!$items) : ?>
            <p>There are no items to show.</p>
            <?php return; ?>
        <?php endif; ?>
    </div>

    <div class="showAllUsersContent">
        <h1>All users</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Age</th>
                <th>Rank</th>
            </tr>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td><a class="showAllUsersLink" href="<?= $showAll . "/" . $item->id ?>"><?= $item->name ?></a></td>
                    <td><img src="<?php echo $gravatar->getGravatar($item->email, 40) ?>" alt="Image"/></td>
                    <td><?= $item->age ?></td>
                    <td><?= $item->permissions ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
