<?php

use App\Connection;
use App\Table\PostTable;

$title = "Admin";
$pdo = Connection::getPDO();

[$posts, $pagination] = (new PostTable($pdo))->findPaginated();
$link = $router->url('home');

?>

<h1>admin</h1>
<div class="row">
    <?php foreach($posts as $post ): ?>
    <div class="col-md-12">
        <?php require 'admin_card.php' ?>
    </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between  my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>