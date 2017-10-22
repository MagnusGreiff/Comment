<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

$showAll = $this->di->get("url")->create("user/all/");


$gravatar = $this->di->get("gravatar");

// Create urls for navigation

?>
<div class="wrapper"><h1>View All Users</h1>

    <?php if (!$items) : ?>
        <p>There are no items to show.</p>
        <?php return; ?>
    <?php endif; ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th>Age</th>
            <th>Permissions</th>
        </tr>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><a href="<?= $showAll . "/" . $item->id ?>"><?= $item->name ?></a></td>
                <td><img src="<?php echo $gravatar->getGravatar($item->email, 40) ?>" alt="Image"/></td>
                <td><?= $item->age ?></td>
                <td><?= $item->permissions ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
