<?php
namespace core;

abstract class Controller{
    protected string $Layout = 'main';
    protected Request $request;

    public function layout(){
        return $this->Layout;
    }

    public function setLayout($layout){
        $this->Layout = $layout;
    }

    public function render($view, $params){
        return Application::APP()->router->renderView($view, $params);
    }
}