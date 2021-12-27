<?php
namespace core;

class Response{
    public function setStatusCode(int $code){
        \http_response_code($code);
    }

    public function redirect(string $route, array $params, int $code=302){
        $_SESSION['redirection_data'] = $params;
        header("Location: {$route}", true, $code);
        exit();
    }

    public function returnRedirectionDate(){
        $data = $_SESSION['redirection_data'] ?? [];
        if (isset($_SESSION['redirection_data']))
            unset($_SESSION['redirection_data']);
        return $data;
    }
}