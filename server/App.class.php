<?php
define('ROOT', dirname(__FILE__)."/..");
//
//
//
class App {
    //
    //
    //
    static function path($path){
        return ROOT."/${path}";
    }

    //
    //
    //
    static function dataPath($path){
        return self::path('data/'.$path);
    }
}

?>
