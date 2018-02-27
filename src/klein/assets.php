<?php
//
//
//
$klein->with('api/assets', function() use ($klein){

    //
    //
    //
    $klein->respond('GET','/css', function($request,$response){
        $file = 'skynotes.public.css';
        if(App::isLoggedIn()){
            $file = 'skynotes.private.css';
        }
        $file = App::path("app/css/$file");
        $css = file_get_contents($file);
        $css .= file_get_contents(App::path('app/fonts/fonts.css'));
        $response->header('Content-Type', 'text/css');
        return $css;
    });

    //
    //
    //
    $klein->respond('GET','/js', function($request,$response){
        $file = 'skynotes.public.js';
        if(App::isLoggedIn()){
            $file = 'skynotes.private.js';
        }
        $file = App::path('app/js/'.$file);
        $response->header('Content-Type','text/javascript');
        return file_get_contents($file);
    });

    //
    //
    //
    $klein->respond('GET','/fontawesome/[:name]', function($request,$response){
        $name   = $request->param('name');
        $file   = App::path("app/fonts/fontawesome/$name");
        $response->header('Content-Type','application/x-font-opentype');
        return file_get_contents($file);
    });

    //
    //
    //
    $klein->respond('GET','/font/[:name]/[:id]/[:file]', function($request,$response){
        $name   = $request->param('name');
        $id     = $request->param('id');
        $file   = $request->param('file');
        $file   = App::path("app/fonts/$name/$id/$file");
        $response->header('Content-Type','application/x-font-opentype');
        return file_get_contents($file);
    });
});
?>
