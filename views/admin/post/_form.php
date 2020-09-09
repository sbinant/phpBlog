<form action="" method="POST">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->select('categories_ids', 'Catégories', $categories); ?>
    <?= $form->textarea('content', 'Contenu') ?>
    <?= $form->textarea('created_at', 'Date') ?>
    <button class="btn btn-primary">
    <?php if ($post->getID() !== null): ?>
    Edit
    <?php else: ?>
    Create
    <?php endif ?>
    </button>
</form>