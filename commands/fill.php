<?php
/*
*Generate fake following elements using Faker:*
    posts,
    categories,
    admin_user
    password admin_user
*/

use App\Connection;

require dirname(__DIR__).'/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS =0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS =1');

$posts = [];
$categories = [];

for($i = 1; $i < 51; $i++) {
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->iso8601}', content='{$faker->paragraph(rand(3,15), true)}'");

    $posts[] = $pdo->lastInsertId();
}

for($i = 1; $i < 6; $i++) {

    $pdo->exec("INSERT INTO category SET name='{$faker->sentence(3)}', slug='{$faker->slug}' ");
    $categories[] = $pdo->lastInsertId();
}

foreach( $posts as $post )
{
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
        
    foreach( $randomCategories as $randomCategory )
    {   
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$randomCategory");
    }
}

$password_hash = password_hash('your_password_here', PASSWORD_BCRYPT);
$pdo->exec(" INSERT INTO user SET username='admin', password='$password_hash' ");