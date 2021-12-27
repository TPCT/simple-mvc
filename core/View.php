<?php 
namespace core;

class View{
    private string $title = '';

    public function renderView(string $view, $params = []){
        $viewContent = $this->renderViewContent($view, $params);
        $layoutContent = $this->renderLayoutContent();
        if ($layoutContent !== Null){
           return \str_replace('{{content}}', $viewContent, $layoutContent);
        }
        return $viewContent;
    }

    public function renderLayoutContent(){
        $layout = Application::APP()->layout();
        if (Application::APP()->getController()){
            $layout = Application::APP()->getController()->layout();
        }
        if ($layout){
            \ob_start();
                include_once(Application::VIEWS_DIR() . \DIRECTORY_SEPARATOR . "layouts" . \DIRECTORY_SEPARATOR . $layout . ".php");
            return \ob_get_clean();
        }
        return Null;
    }

    public function renderViewContent(string $view, $params = []){
        \ob_start();
        \extract($params);
        include_once(Application::VIEWS_DIR() . \DIRECTORY_SEPARATOR . "{$view}.php");
        return \ob_get_clean();
    }
}