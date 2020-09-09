<?php

$categories = array_map( function($category) use ($router) {
     $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getID() ]);
     return <<<HTML
          <a href="{$url}">{$category->getName()}</a>
HTML;
}, $post->getCategories() )

?>

<div class="card mb-3">
     <div class="card-body">
          <h5 class="card-title"><?= htmlentities( $post->getName() ) ?></h5>
          <p class="muted">
               <?= $post->getCreatedAt()->format('d F Y') ?>
               <?php if(!empty($post->getCategories() )): ?> ::
               <?= implode(',', $categories) ?>
               <?php endif; ?>
     <p><?= $post->getExcerpt() ?></p>
     <a href="<?= $router->url( 'post', ['slug' => $post->getSlug(),'id' => $post->getID() ]) ?>
     " class="btn btn-primary">Read more</a>
     </div>
</div>