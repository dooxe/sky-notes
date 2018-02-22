<?php
//------------------------------------------------------------------
//
//------------------------------------------------------------------
require_once '../src/classes/lib.php';

//------------------------------------------------------------------
//
//------------------------------------------------------------------
if(!file_exists('../config/config.php')){
    echo "Please proceed to SkyNote installation step.";
    exit(0);
}
require_once '../config/config.php';

//------------------------------------------------------------------
//
//------------------------------------------------------------------
require_once __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;

//------------------------------------------------------------------
//  Klein routing
//------------------------------------------------------------------
// Klein application path
$appPath = $config['app-path'];
define('APP_PATH', "/${appPath}/");

//
$klein = new \Klein\Klein();
$request = \Klein\Request::createFromGlobals();

// Grab the server-passed "REQUEST_URI"
$uri = $request->server()->get('REQUEST_URI');

// Set the request URI to a modified one (without the "subdirectory") in it
$request->server()->set('REQUEST_URI', substr($uri, strlen(APP_PATH)));

//
require_once(App::path('src/klein/login.php'));

//------------------------------------------------------------------------------
//  Route no more request if not logged in
//------------------------------------------------------------------------------
session_start();
if(!isset($_SESSION['login'])){
    $klein->dispatch($request);
    exit(0);
}

//
require_once(App::path('src/klein/logout.php'));
require_once(App::path('src/klein/config.php'));
require_once(App::path('src/klein/notebooks.php'));
require_once(App::path('src/klein/notes.php'));
require_once(App::path('src/klein/fonts.php'));
require_once(App::path('src/klein/themes.php'));

// Pass our request to our dispatch method
$klein->dispatch($request);
?>
