<?php


class Dispatcher
{
    private $request;

    public function dispatch()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);

        $controller = $this->loadController();

        call_user_func_array([$controller, 'processRequest'], $this->request->params);
    }

    /**
     * @return mixed
     */
    public function loadController()
    {
        $name = $this->request->controller . "Controller";
        $file = ROOT . 'Controllers/' . $name . '.php';
        require($file);
        $controller = new $name($_SERVER["REQUEST_METHOD"]);

        return $controller;
    }
}
