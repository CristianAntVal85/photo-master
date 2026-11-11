<?php

$router->get('', __DIR__ . '/controllers/index.php');
$router->get('about', __DIR__ . '/controllers/about.php');
$router->get('asociados', __DIR__ . '/controllers/Asociados.php');
$router->get('blog', __DIR__ . '/controllers/blog.php');
$router->get('contact', __DIR__ . '/controllers/contact.php');
$router->get('galeria', __DIR__ . '/controllers/galery.php');
$router->get('post', __DIR__ . '/controllers/single_post.php');
$router->post('galeria/nueva', __DIR__ . '/controllers/galeria_nueva.php');
