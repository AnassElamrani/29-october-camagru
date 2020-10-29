<?php

class Controller {
    
    public function model($model){
        require_once '../app/models/' . $model . '.php';
        // Instantiate model
        return new $model;
    }
    
    public function view($url, $data = []) {
        if(file_exists('../app/views/'.$url.'.php')){
            require_once '../app/views/'.$url.'.php';
        }
        else{
            die('there is now view with this name'.$url);
    }
}
}