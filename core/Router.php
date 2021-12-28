<?php
namespace core;

class Router{
    protected array $routes = array();
    public Request $request;
    public Response $response;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
    }

    public function get(string $route, $callback){
        $this->routes['GET'][$route] = $callback;
    }

    public function post(string $route, $callback){
        $this->routes['POST'][$route] = $callback;
    }

    public function resolve(){
        $route = $this->request->path();
        $method = $this->request->method();
        $callback = $this->routes[$method][$route] ?? Null;

        if ($callback === Null){
            $this->response->setStatusCode(404);
            return (new View("_404"))->render();
        }

        if (is_array($callback)){
            [$class, $method] = $callback;
            if (\class_exists($class)){
                $class = new $class();
                Application::APP()->setController($class);
                if (\method_exists($class, $method)){
                    return \call_user_func([$class, $method]);
                }
            }
        }
        
        if (\is_callable($callback)){
            return \call_user_func($callback);
        }

        if (\is_string($callback)){
            return $callback;
        }
        
    }

    
}