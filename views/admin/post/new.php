<?php

use App\Connection;
use App\Table\PostTable;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\PostValidator;

$post = new Post();
$errors = [];

$pdo = Connection::getPDO();

$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();

if( !empty($_POST))
{
    $postTable = new PostTable($pdo);

    $v = new PostValidator( $_POST, $postTable, $post->getID(), $categories );
    ObjectHelper::hydrate( $post, $_POST, ['name', 'slug', 'content', 'created_at']);

    if( $v->validate())
    {
        $pdo->beginTransaction();
         
        $postTable->createPost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();

        header('Location: ' . $router->url('admin_post', ["id" => $post->getID() ]));
        exit();//éviter que suite du script s'exec
    }
    else
    {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);

?>


<h1>Add an article</h1>

<?php if( !empty($errors) ): ?>
    <div class="alert alert-danger"> Error found </div>
<?php endif ?>

<?php require('_form.php');