<?php
define('DIR', dirname(__FILE__).'/modals');
if($login){
    require_once(DIR.'/config.php');
    require_once(DIR.'/confirm.php');
    require_once(DIR.'/new-note.php');
    require_once(DIR.'/new-notebook.php');
    require_once(DIR.'/rename-notebook.php');
}
require_once(DIR.'/about.php');
?>
