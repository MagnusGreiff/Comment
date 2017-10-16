<?php
namespace Anax\View;

$logout = url("user/logout");
$adminTools = url("admin/viewUsers");

$gravatar = $this->di->get("gravatar");


?>

<main class="wrapper">
    <div class="profile_name">
        <h1><?= $content->name ?>'s Profil</h1>
    </div>
    <div class="profile_info">
        <p>Email: <?= $content->email ?></p>
        <p>Namn: <?= $content->name ?></p>
        <p>Ålder: <?= $content->age ?></p>
        <p>Id: <?= $content->id ?></p>
        <img src="<?php echo $gravatar->getGravatar($content->email, 40) ?>" alt="Image"/>
    </div>
    <?php if ($content->permissions === "admin") : ?>
        <p><a href="<?= $adminTools ?>">User Management</a></p>
    <?php endif ?>
    <p><a href="<?= url("user/editProfile/{$content->id}"); ?>">Redigera Profil</a></p>
    <p><a href="<?= $logout ?>">Logga ut</a></p>
</main>
