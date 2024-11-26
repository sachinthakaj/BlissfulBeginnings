<?php

class Router
{
    private static $router;

    private function __construct(private array $routes = [])
    {
    }

    public static function getRouter(): self {

        if(!isset(self::$router)) {

            self::$router = new self();
        }

        return self::$router;
    }
    public function get(string $uri, string $action): void {

        $this->register($uri, $action, "GET");
    }
    
    public function post(string $uri, string $action): void {
    
        $this->register($uri, $action, "POST");
    }
    
    public function put(string $uri, string $action): void {
    
        $this->register($uri, $action, "PUT");
    }
    
    public function delete(string $uri, string $action): void{
    
        $this->register($uri, $action, "DELETE");
    }
    
    protected function register(string $uri, string $action, string $method): void {
    
            if(!isset($this->routes[$method])) $this->routes[$method] = [];
    
            list($controller, $function) = $this->extractAction($action);

            $this->routes[$method][$uri] = [
                'controller' => $controller,
                'method' => $function
            ];
    }
    
    protected function extractAction(string $action, string $seperator = '@'): array {
    
           $sepIdx = strpos($action, $seperator);
    
           $controller = substr($action, 0, $sepIdx);
           $function = substr($action, $sepIdx + 1, strlen($action));
    
           return [$controller, $function];
    }
    public function route(string $method, string $uri): bool {
        $result = dataGet($this->routes, $method .".". $uri);
        if(!$result) {
            header("HTTP/1.1 404 Not Found");
            require_once('../../core/404page.html');
            return false;
        }

        $controller = $result['controller'];
        $function = $result['method'];
        if(class_exists($controller)) {

            $controllerInstance = new $controller();

            if(method_exists($controllerInstance, $function)) {
                $controllerInstance = new $controller();

                $controllerInstance->$function($result['params']);
                return true;

            } else {
                
                abort("No method {$function} on class {$controller}", 500);
            }
        }

        return false;
}
}