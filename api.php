<?php
//
//
//  TODO Save the notebook (api/notebooks/save)
//

if(!file_exists('.security/users.php')){
    echo "Please proceed to SkyNote installation step.";
    exit(0);
}
require_once '.security/users.php';
//------------------------------------------------------------------

// Composer dependencies
require_once __DIR__ . '/vendor/autoload.php';
//
require_once __DIR__ . '/server/Note.class.php';
require_once __DIR__ . '/server/Notebook.class.php';
//------------------------------------------------------------------

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
$klein->respond('POST', 'api/login', function ($request, $response) use ($klein,$users) {
    $data = json_decode(file_get_contents('php://input'));
    $login = $data->login;
    $password = $data->password;
    if(!array_key_exists($login,$users)){
        $response->code(403);
        return 'Login '.$login.'not existing ...';
    }
    $userData = $users[$login];

    $passToTest = sha1(md5($password.$userData['salt']));
    if($passToTest === $userData['password']){
        session_start();
        $_SESSION['login'] = $login;
        return '';
    }
    else{
        $response->code(403);
        return 'Wrong password ...';
    }
});

$klein->respond('POST', 'api/logout', function () use ($klein) {
    session_start();
    unset($_SESSION['login']);
    session_destroy();
    return '';
});

session_start();
//
//  Route no more request if not logged in
//
if(!isset($_SESSION['login'])){
    $klein->dispatch($request);
    exit(0);
}

//------------------------------------------------------------------------------
//  NOTEBOOK API
//------------------------------------------------------------------------------
$klein->with('api/notebooks', function () use ($klein) {
    //
    $klein->respond('POST', '/new', function($request, $response){
        $data = (array)json_decode(file_get_contents('php://input'));
        $title = $data['title'];
        $notebook = Notebook::create($title);
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
        return json_encode(Note::load($id));
    });
    //
    $klein->respond('DELETE', '/[:id]', function($request, $response){
        $id = $request->param('id');
        if(Notebook::delete($id)){
            return '';
        }
        return '';
    });
});

//------------------------------------------------------------------------------
//  NOTE API
//------------------------------------------------------------------------------
$klein->with('api/notes', function () use ($klein) {
    //
    $klein->respond('POST', '/new', function($request, $response){
        $info = (array)json_decode(file_get_contents('php://input'),true);
        $notebookId = $info['notebookId'];
        $note = Note::create($notebookId,$info['title']);
        $note->save();
        return json_encode($note);
    });
    //
    $klein->respond('POST', '/save', function($request, $response){
        $contents = json_decode(file_get_contents('php://input'),true);
        $n = Note::fromArray($contents);
        $n->save();
        return true;
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
    //
    $klein->respond('DELETE', '/[:id]', function($request, $response){
        $id = $request->param('id');
        if(Note::delete($id)){
            return '';
        }
        return 'not deleted ...';
    });
});

// Pass our request to our dispatch method
$klein->dispatch($request);
?>
