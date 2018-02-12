<?php
//
//
//  TODO Save the notebook (api/notebooks/save)
//

if(!file_exists('config/config.php')){
    echo "Please proceed to SkyNote installation step.";
    exit(0);
}
require_once 'config/config.php';
//------------------------------------------------------------------

//
define('DOMPDF_ENABLE_AUTOLOAD', false);
require_once __DIR__ . '/vendor/dompdf/dompdf/dompdf_config.inc.php';

// Composer dependencies
require_once __DIR__ . '/vendor/autoload.php';
//
require_once __DIR__ . '/server/Note.class.php';
require_once __DIR__ . '/server/Notebook.class.php';
//------------------------------------------------------------------

// Klein application path
define('APP_PATH', '/{{APP_PATH}}/');

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
$klein->respond('POST', 'api/login', function ($request, $response) use ($klein,$config) {
    $data = json_decode(file_get_contents('php://input'));
    $login = $data->login;
    $password = $data->password;
    if($config['user']['login'] !== $login){
        $response->code(403);
        return 'Login '.$login.'not existing ...';
    }
    $userData = $config['user'];
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
//
//------------------------------------------------------------------------------
$klein->respond('GET', 'api/config', function($request,$response){
    $file = 'data/config.json';
    if(file_exists($file)){
        return file_get_contents($file);
    }
    return '{}';
});
$klein->respond('POST', 'api/config', function($request,$response){
    $json = json_decode(file_get_contents('php://input'));
    file_put_contents('data/config.json', json_encode($json->config));
    return $json;
});

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
    $klein->respond('POST', '/save', function($request, $response){
        $json = file_get_contents('php://input');
        $notebookArray = json_decode($json,true);
        $notebook = Notebook::fromArray($notebookArray);
        return $notebook->save();
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
    $klein->respond('GET', '/[:id]/generate/[pdf:format]',
    function($request, $response){
        $id = $request->param('id');
        $format = $request->param('format');
        $note = Note::load($id);
        if($format === 'pdf'){
            // MARKDOW -> HTML
            $markdown = $note->content;
            $markdownParser = new \Michelf\MarkdownExtra();
            $html = $markdownParser->transform($markdown);
            // HTML -> DOM
            $dom = \HTML5::loadHTML($html);
            $links = htmlqp($dom, 'a');
            foreach ($links as $link) {
                $href = $link->attr('href');
                if (substr($href, 0, 1) == '/' && substr($href, 1, 1) != '/') {
                    $link->attr('href', $domain_name . $href);
                }
            }
            $html = \HTML5::saveHTML($dom);
            $html = str_replace('<html>','<html><head><link rel="stylesheet" type="text/css" href="css/pdf.css"/></head>',$html);
            // DOM -> PDF
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $response->header('Content-Type','application/pdf');
            //$response->file('',$note->title.'.pdf');
            return $dompdf->output();
        }
        return '';
    });
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
