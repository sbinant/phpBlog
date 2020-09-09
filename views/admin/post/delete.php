<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();

$pdo = Connection::getPDO();
$table = new PostTable($pdo);
$table->delete( $params['id'] );
header('Location:'.$router->url('admin_posts') . '?delete=1' );
exit(); 

?>

<h1>delete <?=  $params['id'] ?></h1>