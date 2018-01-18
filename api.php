<?php
// Composer dependencies
require_once __DIR__ . '/vendor/autoload.php';
//
require_once __DIR__ . '/server/Note.class.php';
require_once __DIR__ . '/server/Notebook.class.php';

// Klein application path
define('APP_PATH', '/sky-notes/');

//
$klein = new \Klein\Klein();
$request = \Klein\Request::createFromGlobals();

// Grab the server-passed "REQUEST_URI"
$uri = $request->server()->get('REQUEST_URI');

// Set the request URI to a modified one (without the "subdirectory") in it
$request->server()->set('REQUEST_URI', substr($uri, strlen(APP_PATH)));

//------------------------------------------------------------------------------
//  NOTEBOOK API
//------------------------------------------------------------------------------
$klein->with('api/notebooks', function () use ($klein) {
    //
    $klein->respond('GET', '/create', function($request, $response){
        $notebook = Notebook::create();
        $notebook->save();
        return json_encode($notebook);
    });
    //
    $klein->respond('GET', '/save', function($request, $response){
        /*
        $notebookid = $request->param('notebookId');
        $id = md5(uniqid(rand(), true));
        $note = array("id"=>$id, "title"=>"", "content"=>"","notebookId"=>$notebookid);
        $filename = getNotePath($note);
        file_put_contents($filename, json_encode($note));
        */
    });
    //
    $klein->respond('GET', '/get/all', function($request, $response){
        return json_encode(Notebook::getAll());
    });
    //
    $klein->respond('GET', '/get/id/[:id]', function($request, $response){
        $id = $request->param('id');
        return json_encode(Notebook::load($id));
    });
});

//------------------------------------------------------------------------------
//  NOTE API
//------------------------------------------------------------------------------
$klein->with('api/notes', function () use ($klein) {
    //
    $klein->respond('POST', '/create', function($request, $response){
        $notebookId = $request->param('notebookId');
        $note = Note::create($notebookId);
        $note->save();
        return json_encode($note);
    });
    //
    $klein->respond('GET', '/save', function($request, $response){
        /*
        $notebookid = $request->param('notebookId');
        $id = md5(uniqid(rand(), true));
        $note = array("id"=>$id, "title"=>"", "content"=>"","notebookId"=>$notebookid);
        $filename = getNotePath($note);
        file_put_contents($filename, json_encode($note));
        */
    });
    //
    $klein->respond('GET', '/get/all', function($request, $response){
        return json_encode(Note::getAll());
    });
    //
    $klein->respond('GET', '/get/id/[:id]', function($request, $response){
        $id = $request->param('id');
        return json_encode(Note::load($id));
    });
});
// Pass our request to our dispatch method
$klein->dispatch($request);
?>
