<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if( $post->getSlug() !== $slug )
{
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id ] );
    header('Location: ' . $url);
    http_response_code(301); 
}

?>


<h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>

<?php foreach($post->getCategories() as $k => $category ): ?>
<?php if($k > 0): ?>
,
<?php endif ?>
<a href="<?= $router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getID() ]) ?>"><?= htmlentities($category->getName()) ?></a>
<?php endforeach ?>
<p><?= $post->getFormattedContent() ?></p>

