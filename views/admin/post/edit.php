<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;
use App\Validator;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\PostValidator;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);

$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();

$post = $postTable->find( $params['id'] );
$categoryTable->hydratePosts([$post]);
$success = false;
$errors = [];

if( !empty($_POST))
{
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories );
    
    ObjectHelper::hydrate( $post, $_POST, ['name', 'slug', 'content' , 'created_at']);
    
    if( $v->validate())
    {
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);//on re hydrate pour mettre les bonnes categories lors de modif 
        
        $success = true;
    }
    else
    {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);

?>

<h1>Editer l'article <?=  htmlentities( $post->getName() ) ?> </h1>

<?php if($success): ?>
    <div class="alert alert-success"> Success! </div>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success"> Article succesfully created! </div>
<?php endif ?>

<?php if( !empty($errors) ): ?>
    <div class="alert alert-danger"> Error found </div>
<?php endif ?>

<?php require('_form.php'); ?>