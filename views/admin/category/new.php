<?php

use App\Connection;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Model\Category;
use App\ObjectHelper;
use App\Validators\CategoryValidator;

$item = new Category();
$errors = [];

if( !empty($_POST))
{
    $pdo = Connection::getPDO();
    $table = new CategoryTable($pdo);

    $v = new CategoryValidator( $_POST, $table );
  
    if( $v->validate())
    {
        ObjectHelper::hydrate( $item, $_POST, ['name', 'slug']);
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug()]);
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    }
    else
    {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors);

?>

<h1>Create an article</h1>
<?php if( !empty($errors) ): ?>
    <div class="alert alert-danger"> Error found </div>
<?php endif ?>
<?php require('_form.php');