<?php

require ("functions.php");

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
/*//el _SERVER es variable global que te una llista de variables,
 el REQUEST... es per demanar al servidor la URI, utilitzam la funcio
parse_url per pasar un string i demanar nomes la ruta, per així que el
enrutador sempre tengui la informació correcta

*/

$routes = [
  '/'=>'controllers/index.php',
  '/about'=>'controllers/about.php',
  '/contact'=>'controllers/contact.php'
];

if(array_key_exists($uri,$routes)){
    require $routes[$uri];
}else{
    http_response_code(404);

    require 'views/404.php';

    die();
}