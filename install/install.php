<?php
//
define('CONFIG_DIR',    'config');
define('CONFIG_FILE',   CONFIG_DIR.'/config.php');

//
//
//
function isLoginValid($login){
    return ($login != '');
}
function isPasswordValid($password){
    return ($password != '');
}

//
//
//
$appPath    = '';
$login      = '';
$salt       = '';
$password   = '';

//
//
//
$update = false;
if($argc > 1){
    for($i = 0; $i < $argc; $i += 1){
        $arg = $argv[$i];
        if($arg === '--update'){
            $update = true;
            break;
        }
    }
}

//
//
//
echo "\n      Welcome to Skynotes installation script !\n\n";

$configFile = CONFIG_FILE;
$haveConfig = false;
if(file_exists($configFile)){
    require_once($configFile);
    $haveConfig = true;
}

//
//
//
if(!$update){
    $login = '';
    while(!isLoginValid($login)){
        $default = '';
        if($haveConfig){
            $default = $config['user']['login'];
        }
        $login = $default;
        echo "Give us a login";
        if($haveConfig){
            echo " [".$login."] ";
        }
        else {
            echo ":";
        }
        echo "\n";
        echo "> ";
        $l = trim(fgets(STDIN));
        if(isLoginValid($l)){
            $login = $l;
        }
    }
    echo "Nice !\n";
    echo "\n";

    //
    $salt = uniqid();
    $password = '';
    while(!isPasswordValid($password)){
        echo "Give us a password (not displayed) ";
        if($haveConfig){
            echo "[nothing = no change]";
        }
        else {
            echo ":";
        }
        echo "\n";
        // Get current style
        $oldStyle = shell_exec('stty -g');
        shell_exec('stty -echo');
        echo "> ";
        $password = rtrim(fgets(STDIN));
        // Reset old style
        shell_exec('stty ' . $oldStyle);
        //
        if($password === ''){
            $password = $config['user']['password'];
        }
    }
    $password = sha1(md5($password.$salt));
    echo "\n";
    echo "OK !\n";
    echo "\n";

    //
    //  Get application path
    //
    echo "Give us the application directory (can be empty) \n";
    echo "Example: if your website is http://my-web-site/skynotes/ type 'skynotes'.\n";
    $defaultAppPath = '';
    if($haveConfig){
        $defaultAppPath = $config['app-path'];
        echo "default = '$defaultAppPath'\n";
    }
    echo "> ";
    $appPath = trim(fgets(STDIN));
    if($appPath === ''){
        $appPath = $defaultAppPath;
    }
    echo "Cool !\n";
    echo "\n";

    //
    if(!file_exists('config')){
        if(!mkdir('config')){
            echo "Impossible to create 'config' directory !\n";
            exit(0);
        }
    }
}
else {
    $appPath = $config['app-path'];
    $login = $config['user']['login'];
    $salt = $config['user']['salt'];
    $password = $config['user']['password'];
}

//
$apiPhp = file_get_contents('install/api.tpl.php');
$apiPhp = str_replace('{{APP_PATH}}',$appPath,$apiPhp);
file_put_contents('api.php',$apiPhp);

//
$htaccess = file_get_contents('install/.htaccess.tpl');
$htaccess = str_replace('{{APP_PATH}}',$appPath,$htaccess);
file_put_contents('.htaccess',$htaccess);

//
$config = file_get_contents('install/config.tpl.php');
$config = str_replace('{{USER}}',    $login,     $config);
$config = str_replace('{{SALT}}',    $salt,      $config);
$config = str_replace('{{PASSWORD}}',$password,  $config);
$config = str_replace('{{APP_PATH}}',$appPath,   $config);
if(!file_put_contents(CONFIG_FILE,$config)){
    echo "Impossible to install file '".CONFIG_FILE."'\n";
    exit(0);
}

//
echo "Ok ! SkyNotes is now configured, please remove 'install' directory.\n";
echo "\n";
?>
