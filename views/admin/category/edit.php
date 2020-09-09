<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$pdo = Connection::getPDO();

$table = new CategoryTable($pdo);
$item = $table->find( $params['id'] );
$success = false;
$errors = [];
$fields = ['name', 'slug'];


if( !empty($_POST))
{
    $v = new CategoryValidator( $_POST, $table, $item->getID() );

    if( $v->validate())
    {
        ObjectHelper::hydrate( $item, $_POST, $fields);
        $table->update([
            'name' => $item->getName(),
            'slug' => $item->getSlug()], $item->getID());
        $success = true;
    }
    else
    {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors);


?>

<?php if($success): ?>
    <div class="alert alert-success"> Success! </div>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success"> Category succesfully created! </div>
<?php endif ?>

<?php if( !empty($errors) ): ?>
    <div class="alert alert-danger"> Error found </div>
<?php endif ?>

<h1>Edit category <?= htmlentities( $item->getName() ) ?> </h1>

<?php require('_form.php'); ?>