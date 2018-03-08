<?php
//------------------------------------------------------------------------------
// LOAD
//------------------------------------------------------------------------------
$klein->respond('GET', 'api/config', function($request,$response){
    /* AJAX check  */
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    	/* special ajax here */
        $response->code(404);
    	return '';
    }
    $file = App::path('data/config.json');
    if(file_exists($file)){
        return file_get_contents($file);
    }
    return '{}';
});

//------------------------------------------------------------------------------
//  SAVE
//------------------------------------------------------------------------------
$klein->respond('POST', 'api/config', function($request,$response){
	$json = json_decode(file_get_contents('php://input'));
	file_put_contents(App::path('data/config.json'), json_encode($json->config));
	return json_encode($json);
});
?>
