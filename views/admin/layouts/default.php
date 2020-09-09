<html lang="en">
<head class="h-100">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlentities($title) : 'Blog' ?></title>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="<?= $router->url('home') ?>" class="navbar-brand">Blog Demo</a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="<?= $router->url('admin_posts') ?>"class="nav-link">Articles</a>
        </li>
        <li class="nav-item">
            <a href="<?= $router->url('admin_categories') ?>" class="nav-link">Categories</a>
        </li>
        <li class="nav-item">
            <!-- on a volontairement mis notre lien de deco en POST (donc en form) pour éviter de pouvoir se deco avec simple lien envoyée (lien pirate par ex)-->
            <form action="<?= $router->url('logout')?>" method="POST" style="display:inline">
                <button type="submit" class="nav-link" style="background:transparent; border:none ">Logout</button>
            </form>
        </li>
    </ul>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            <?php if( defined('DEBUG_TIME') ): ?>
                Technical Stage Info | Page generated in: <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
            <?php endif ?>
        </div>
    </footer>
</body>
</html>