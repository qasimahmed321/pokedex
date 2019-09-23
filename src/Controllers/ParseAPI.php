<?php


namespace Controllers;

class ParseAPI
{

    public function verify_return($ret, $http){
        if($ret != "\"An error has occured.\""){
            return json_decode($ret, true);
        }else{
            $http[0]->render($http[1], "error.html.twig");
        }
        return false;
    }

}
