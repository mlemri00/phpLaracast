<?php
namespace core;
use core\Middleware\Middleware;
use Http\controllers\classes\NotesController;

class Router{
    protected $classes;
    public function __construct()
    {   //Aqui posam totes les classes que volem implementar al controller
        $this->classes=[
          'notes'=>new NotesController()
        ];
    }

    protected $routes =[];
    public function add($method,$uri,$controller){
        $this->routes[]=[
            'uri'=>$uri,
            'controller'=>$controller,
            'method'=>$method,
            'middleware'=>null,
        ];
        return $this;
    }

    public function get($uri,$controller){
        return $this->add("GET",$uri,$controller);
    }

    public function post($uri,$controller ){
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
        $apiRequest = false;
        foreach ($this->routes as $route){

            if (str_contains($uri,"api/")){
                $uri = str_replace("api/","",$uri);
                $apiRequest=true;

            }
            if ($route['uri']===$uri && $route['method']=== strtoupper($method)){
                Middleware::resolve($route['middleware'],$apiRequest);

                 if (str_contains($route['controller'], "@")){

                     $function = explode("@",$route['controller'],2);

                     foreach(array_keys($this->classes) as $classKey){
                         if ($function[0]===$classKey){
                            [$this->classes[$classKey],$function[1]]($apiRequest);
                         }
                     }
                 }else {
                     return require base_path('Http/controllers/' . $route['controller']);
                 }
            }
        }
        $this->abort(404);
    }





    protected function abort($code = 404 ){// això és per fer un paràmetre de sèrie si no es passa ni un
        http_response_code($code);
        require base_path("views/{$code}.php");

        die();
    }

    private function getClassInstance($class, $method){

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