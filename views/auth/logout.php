<?php
session_start();
session_destroy();
header('Location: ' . $router->url('login') . "?logout=1" );
exit();