<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();

$title = "admin";

$pdo = Connection::getPDO();
$link = $router->url('admin_posts');

[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

?>

<?php if(isset($_GET['delete'])):?>
    <div class="alert alert-success">
        Record well deleted
    </div>
<?php endif ?>
<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>
            <a class="btn btn-primary" href="<?= $router->url('admin_post_new') ?>">Add</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td>
                #<?= htmlentities($post->getID()) ?>
            </td>
            <td>
                <a href="<?=$router->url('admin_post', [ 'id' => $post->getID() ])?>">
                <?= htmlentities( $post->getName() ) ?></a>
            </td>
            <td>
                <a href="<?=$router->url('admin_post', [ 'id' => $post->getID() ])?>" class="btn btn-primary">
                Edit
            </a>
            <form action="<?=$router->url('admin_post_delete', [ 'id' => $post->getID() ])?>" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
               <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between  my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>