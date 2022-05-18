<?php

namespace app\core;

class Application
{
    public Router $router;
    public request $request;
    public response $response;
    public static Application $app;
    public static string $ROOT_DIR;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo   $this->router->resolve();
    }
}
