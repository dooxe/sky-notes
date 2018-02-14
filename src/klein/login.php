<?php
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
?>
