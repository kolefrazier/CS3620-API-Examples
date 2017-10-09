<?php
/**
 * Created by PhpStorm.
 * User: k-fra
 * Date: 10/8/2017
 * Time: 10:49 PM
 */

class API //FRONT CONTROLLER
{
    protected $endpoint = '';
    protected $verb = '';

    public function processRequest($request)
    {
        $request = rtrim($request, "/");
        $uri = explode('/', $request);
        $this->endpoint = array_shift($uri);
        $this->verb = $_SERVER['REQUEST_METHOD'];

        $controllerName = "Controllers\\";
        $controllerName .= ucwords($this->endpoint);
        $controllerName .= "Controller";

        if(class_exists($controllerName))
        {
            $controller = new $controllerName;
            if(method_exists($controller, $this->verb))
            {
                $returnVal = $controller->{$this->verb}($uri);
                echo json_encode($returnVal); //THIS IS THE ONLY PLACE YOU ECHO IN A CONTROLLER
            } else {
                http_response_code(405); //METHOD NOT ALLOWED
            }
        } else {
            http_response_code(404); //NOT FOUND
        }
    }
}