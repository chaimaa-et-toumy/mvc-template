<?php

namespace app\core;

class Router
{
    // $router = [
    //     'get' => [
    //         '/' => callback , 
    //         'contact'
    //     ]
    //     'post' => [
    //         '/' => callback , 
    //         'contact']  
    // ]
    public Request $request;
    public Response $response;

    protected array $routes = []; // vide 
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    //  know current url + ta7di url path + methode
    public function resolve()
    {

        $path = $this->request->getPath();
        $method = $this->request->getMethode();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);  // status 404 in console (network)

            return $this->renderView("_404");
        }
        if (is_string($callback)) {
            $this->renderView($callback);
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        return call_user_func($callback, $this->request);
        // var_dump($path);
        // var_dump($callback);

    }


    public function renderView($view, $params = [])
    {

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{contenu}}', $viewContent, $layoutContent);
    }
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{contenu}}', $viewContent, $layoutContent);
    }
    protected function layoutContent()
    {
        ob_start(); //function creates an output buffer
        include_once  Application::$ROOT_DIR . "/views/layouts/main.php";
        // var_dump(ob_start());
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        // var_dump($name);

        ob_start();
        // var_dump($params);
        include_once  Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
