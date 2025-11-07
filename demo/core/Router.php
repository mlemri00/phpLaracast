<?php
namespace core;
use core\Middleware\Auth;
use core\Middleware\Guest;
use core\Middleware\Middleware;

class Router{

    protected $routes =[];


    public function add($method,$uri,$controller){
        $this->routes[]=[
            'uri'=>$uri,
            'controller'=>$controller,
            'method'=>$method,
            'middleware'=>null
        ];
        return $this;
    }
    public function get($uri,$controller){
        return $this->add("GET",$uri,$controller);
    }

    public function post($uri,$controller){
        return $this->add("POST",$uri,$controller);

    }

    public function delete($uri,$controller){
        return $this->add("DELETE",$uri,$controller);

    }

    public function patch($uri,$controller){
        return $this->add("PATCH",$uri,$controller);

    }

    public function put($uri,$controller){
        return $this->add("GET",$uri,$controller);

    }
    public function only($key){
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }



    public function route($uri,$method){
        foreach ($this->routes as $route){

            if ($route['uri']===$uri && $route['method']=== strtoupper($method)){

                Middleware::resolve($route['middleware']);




                return require base_path($route['controller']);
            }
        }
        $this->abort();
    }
    protected function abort($code = 404 ){// això és per fer un paràmetre de sèrie si no es passa ni un
        http_response_code($code);
        require base_path("views/{$code}.php");

        die();
    }








}





/*//el _SERVER és variable global que té una llista de variables,
 el REQUEST... és per demanar al servidor lURI, utilitzam la funció
parse_url per passar un string i demanar només la ruta, per així que
l'enrutador sempre tengui la informació correcta


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


$routes = require(base_path('routes.php'));

function routeToController($uri,$routes){
    if(array_key_exists($uri,$routes)){
        require base_path($routes[$uri]);
    }else{
        abort();

    }
}


routeToController($uri,$routes);

*/