<?php
namespace Anax\View;

$logout = url("user/logout");
$adminTools = url("admin/viewUsers");
$email = $content->email;
$default = "http://www.student.bth.se/~magp16/dbwebb-kurser/design/me/anax-flat/htdocs/img/image1.jpeg";
$size = 40;
$grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=wavatar" . urlencode($default) . "&s=" . $size;


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
        <img src="<?php echo $grav_url; ?>" alt="Image"/>
    </div>
    <?php if ($content->permissions === "admin") : ?>
        <p><a href="<?= $adminTools ?>">User Management</a></p>
    <?php endif ?>
    <p><a href="<?= url("user/editProfile/{$content->id}"); ?>">Redigera Profil</a></p>
    <p><a href="<?= $logout ?>">Logga ut</a></p>
</main>
