<?php
$klein->respond('POST', 'api/logout', function () use ($klein) {
    session_start();
    unset($_SESSION['login']);
    session_destroy();
    return '';
});
?>
