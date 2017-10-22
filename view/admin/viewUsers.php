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

// Create urls for navigation

$urlToCreate = url("admin/create");
$urlToDelete = url("admin/delete");


?>
<div class="wrapper"><h1>View all items</h1>

    <p>
        <a href="<?= $urlToCreate ?>">Create</a> |
        <a href="<?= $urlToDelete ?>">Delete</a>
    </p>

    <?php if (!$items) : ?>
        <p>There are no items to show.</p>
        <?php return; ?>
    <?php endif; ?>

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Permissions</th>
        </tr>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td>
                    <a href="<?= url("admin/update/{$item->id}"); ?>"><?= $item->id ?></a>
                </td>
                <td><?= $item->name ?></td>
                <td><?= $item->email ?></td>
                <td><?= $item->age ?></td>
                <td><?= $item->permissions ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
