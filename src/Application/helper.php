<?php

if(!function_exists("redirect")){
    function redirect($path){
        $url = BASE_URL . $path;
        header("Location: $url");
    }
}