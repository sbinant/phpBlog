<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

$title ="Categories Manager";

Auth::check();

$pdo = Connection::getPDO();
$link = $router->url('admin_category');
$items = (new CategoryTable($pdo))->all();

?>

<h1>Category</h1>

<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">category deleted</div>
<?php endif ?>

<table class="table">
    <thead>
        <th>#</th>
        <th>Category Name</th>
        <th>URL</th>
        <th>
            <a class="btn btn-primary" href="<?= $router->url('admin_category_new') ?>">Add</a>
        </th>
    </thead>
    <tbody>
    <?php foreach($items as $item): ?>
        <tr>
            <td>
                #<?= htmlentities($item->getID()) ?>
            </td>
            <td>
                <?= htmlentities($item->getName()) ?>
            </td>
            <td>
                <?= $item->getSlug() ?>
            </td>
            <td>
                <a href="<?=$router->url('admin_category', [ 'id' => $item->getID() ]) ?>" class="btn btn-primary">Edit</a>
           
                <form action="<?=$router->url('admin_category_delete', [ 'id' => $item->getID() ]) ?>" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>