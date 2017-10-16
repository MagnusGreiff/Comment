<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;


$gravatar = $this->di->get("gravatar");

// Create urls for navigation

?>
<div class="wrapper"><h1>View all items</h1>

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
            <!-- <?php
            // $default = "https://www.gravatar.com/avatar/3b3be63a4c2a439b013787725dfce802?d=identicon";
            // $size = 40;
            // $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($item->email))) . "?d=wavatar" . urlencode($default) . "&s=" . $size;
             ?> -->
            <tr>
                <td><?= $item->name ?></td>
                <td><img src="<?php $gravatar->getGravatar($item->email) ?>" alt="Image"/></td>
                <td><?= $item->age ?></td>
                <td><?= $item->permissions ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
