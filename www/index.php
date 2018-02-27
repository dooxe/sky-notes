<?php
session_start();
$login = null;
if(isset($_SESSION['login'])){
    $login = $_SESSION['login'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SkyNotes</title>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="logo/logo.png" />
        <!---->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!---->
        <link rel="stylesheet" type="text/css" href="api/assets/css"/>
        <script src="api/assets/js"></script>
    </head>
    <body id="skynotes" <?php
    if($login){
    ?>
    ng-app="SkyNotes" ng-controller="snMainController"
    <?php
    }
    ?>>
        <div id="sn-main">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <a class="navbar-brand" href="#" style="vertical-align:middle">
                    <img src="logo/logo-large.png" style="margin-left:10px" width="48" height="48" class="d-inline-block align-top" alt="">
                    <span style="display:inline-block;padding-top:8px;margin-left:10px">
                        SkyNotes - <i>keep your notes in the sky</i>
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="nav navbar-nav">
                        <?php
                        if($login){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#sn-config-modal"
                                style="font-size:24px" title="Configuration">
                                <i class="fa fa-lg fa-gears"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" style="font-size:24px" title="Disconnect" ng-click="logout()">
                                <i class="fa fa-lg fa-power-off"></i>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#sn-about-modal"
                                style="font-size:24px" title="About skynotes">
                                <i class="fa fa-lg fa-info-circle"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="sn-body" class="container-fluid">
                <?php
                if($login){
                    require_once('../src/views/main.php');
                }
                else {
                    require_once('../src/views/login.php');
                }
                ?>
            </div>
        </div>
        <?php
            require_once('../src/views/modals.php');
        ?>
    </body>
</html>
