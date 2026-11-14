<?php

$router->get('', 'PagesController@index');
$router->get('about', 'PagesController@about');
$router->get('asociados', 'AsociadosController@index');
$router->post('asociados', 'AsociadosController@index');
$router->get('blog', 'PagesController@blog');
$router->get('contact', 'ContactoController@index');
$router->post('contact/enviar', 'ContactoController@enviar');
$router->get('galeria', 'GaleriaController@index');
$router->get('post', 'PagesController@post');
$router->post('galeria/nueva', 'GaleriaController@nueva');
