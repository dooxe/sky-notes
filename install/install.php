<?php
//
//
//
require_once 'server/get-password.php';

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
echo "\n      Welcome to Skynotes installation script !\n\n";

//
$login = '';
while(!isLoginValid($login)){
    echo "Give us a login: \n";
    echo "> ";
    $login = trim(fgets(STDIN));
}
echo "\n";

//
$password = '';
while(!isPasswordValid($password)){
    echo "Give us a password (not displayed): \n";
    // Get current style
    $oldStyle = shell_exec('stty -g');
    shell_exec('stty -echo');
    echo "> ";
    $password = rtrim(fgets(STDIN));
    // Reset old style
    shell_exec('stty ' . $oldStyle);
}
echo "\n";
echo "\n";

//
//  Get application path
//
echo "Give us the application directory (can be empty).\n";
echo "Example: if your website is http://my-web-site/skynotes/ type 'skynotes'.\n";
echo "> ";
$appPath = trim(fgets(STDIN));
echo "\n";

//
if(!file_exists('.security')){
    if(!mkdir('.security')){
        echo "Impossible to create '.security' directory !\n";
        exit(0);
    }
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
$salt = uniqid();
$password = sha1(md5($password.$salt));
$users = file_get_contents('install/users.tpl.php');
$users = str_replace('{{USER}}',    $login,     $users);
$users = str_replace('{{SALT}}',    $salt,      $users);
$users = str_replace('{{PASSWORD}}',$password,  $users);
file_put_contents('.security/users.php',$users);

//
echo "Ok ! Everything installed, please remove 'install' directory.\n";
echo "\n";
?>
