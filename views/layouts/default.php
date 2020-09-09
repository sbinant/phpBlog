<html lang="en">
<head class="h-100">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlentities($title) : 'Blog Demo' ?></title>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="<?= $router->url('home') ?>" class="navbar-brand">Blog Demo</a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            <?php if( defined('DEBUG_TIME') ): ?>
                Technical Stage Info | Page generated in: <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms | <a href="<?= $router->url('admin_posts') ?>">Admin</a>
            <?php endif ?>
        </div>
    </footer>
</body>
</html>