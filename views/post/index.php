<?php
use App\Connection;
use App\Table\PostTable;

$title = "Index";
$pdo = Connection::getPDO();

$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

$link = $router->url('home');

?>

<h1>Blog Demo</h1>
<div class="row">
    <?php foreach($posts as $post ): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach; ?>
</div>
<div class="d-flex justify-content-between  my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>