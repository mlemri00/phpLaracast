<?php


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
/*//el _SERVER és variable global que té una llista de variables,
 el REQUEST... és per demanar al servidor lURI, utilitzam la funció
parse_url per passar un string i demanar només la ruta, per així que
l'enrutador sempre tengui la informació correcta

*/

$routes = [
    '/'=>'controllers/index.php',
    '/about'=>'controllers/about.php',
    '/notes'=>'controllers/notes.php',
    '/note'=>'controllers/note.php',
    '/contact'=>'controllers/contact.php'
];

function routeToController($uri,$routes){
    if(array_key_exists($uri,$routes)){
        require $routes[$uri];
    }else{
        abort();

    }
}

function abort($code = 404 ){// això és per fer un paràmetre de sèrie si no es passa ni un
    http_response_code($code);
    require "views/{$code}.php";

    die();
}

routeToController($uri,$routes);