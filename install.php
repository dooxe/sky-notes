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
    echo "Give us a login: ";
    $stdin = fopen('php://stdin', 'r');
    $login = trim(fgets(STDIN));
}

//
$password = '';
while(!isPasswordValid($password)){
    echo "Give us a password: ";
    $stdin = getPassword(true);
    $password = trim(fgets(STDIN));
}

//
if(!file_exists('.security')){
    if(!mkdir('.security')){
        echo "Impossible to create '.security' directory !\n";
        exit(0);
    }
}
$salt = uniqid();
$password = sha1(md5($password.$salt));
$script = "<?php\n\$users = array('".$login."'=>array('salt'=>'".$salt."','password'=>'".$password."'));\n?>";
file_put_contents('.security/users.php', $script);
?>
