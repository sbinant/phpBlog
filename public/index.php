<?php
require '../vendor/autoload.php';

/**
 * calcule loading page from index to layer's footer (in microtime)
 */
define('DEBUG_TIME', microtime(true));

/**
 * display errors
 */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if( isset( $_GET['page'] ) && $_GET['page'] === '1' )
{
   $uri = explode( '?', $_SERVER['REQUEST_URI'])[0];
   $get = $_GET;
   unset($get['page']);
   $query = http_build_query( $get );
   if( ! empty($query))
   {
      $uri = $uri .'?'.$query;
   }
   header('Location:'. $uri);
   http_response_code(301);
   exit();
}

$router = new App\Router( dirname(__DIR__).'/views' );
$router
   ->get('/', 'post/index', 'home')
   ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
   ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
   ->match('/login', 'auth/login', 'login')
   ->post('/logout', 'auth/logout', 'logout')

   //ADMIN
   //Articles manager
   ->get('/admin', 'admin/post/index', 'admin_posts')
   ->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post')
   ->match('/admin/post/new', 'admin/post/new', 'admin_post_new')
   ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
   
   //Categories manager
    ->get('/admin/categories', 'admin/category/index', 'admin_categories')
    ->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category')
    ->match('/admin/category/new', 'admin/category/new', 'admin_category_new')
    ->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete')

   ->run();