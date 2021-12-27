<?php

namespace core;

use core\Exceptions\RequiredFileNotFound;

class Application
{
    private static string $Layout = "auth";
    private static string $root_dir;
    private static string $views_dir;
    private static Application $app;
    private static ?Controller $controller = null;
    
    public View $view;
    public Request $request;
    public Router $router;
    public Database $database;
    public Response $response;
    public Session $session;

    private ErrorLogger $error_logger;


    public static function ROOT_DIR()
    {
        return self::$root_dir;
    }

    public static function APP()
    {
        return self::$app;
    }

    public static function VIEWS_DIR()
    {
        return self::$views_dir;
    }

    public function __construct(string $root_dir, array $config, string $views_dir = "views")
    {
        $this->auto_loader();
        self::$app = $this;
        self::$root_dir = $root_dir;
        self::$views_dir = rtrim($root_dir, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . ltrim($views_dir, \DIRECTORY_SEPARATOR);

        $this->view = new View();
        $this->session = new Session();
        $this->response = new Response();
        $this->router = new Router();
        $this->request = new Request();
        $this->error_logger = new ErrorLogger(self::ROOT_DIR() . \DIRECTORY_SEPARATOR . "errors");
        $this->database = new Database($config['db'] ?? Null);
    }

    protected function auto_loader()
    {
        spl_autoload_register([$this, 'auto_load']);
    }

    private function auto_load($class_name)
    {
        $class_path = \str_replace('\\', \DIRECTORY_SEPARATOR, $class_name) . ".php";
        $path = \rtrim(self::$root_dir, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . $class_path;
        if (\is_file($path))
            require_once($path);
        else
            throw new RequiredFileNotFound($path);
    }

    public function getController(): Controller{
        return self::$controller;
    }

    public function setController(Controller $controller): Controller{
        self::$controller = $controller;
        return self::$controller;
    }

    public function layout(){
        return self::$Layout;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
