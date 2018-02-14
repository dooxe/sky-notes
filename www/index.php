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
        <title>Sky notes</title>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="logo/logo.png" />
        <!---->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Load Angular -->
        <script src="node_modules/angular/angular.js"></script>
        <!-- Load Angular sanitize-->
        <script src="node_modules/angular-sanitize/angular-sanitize.js"></script>
        <!-- load ace -->
        <script src="node_modules/ace-builds/src-min-noconflict/ace.js"></script>
        <!-- load ace language tools -->
        <script src="node_modules/ace-builds/src-min-noconflict/ext-language_tools.js"></script>
        <!-- load ace-angular -->
        <script src="node_modules/angular-ui-ace/src/ui-ace.js"></script>
        <!---->
        <script src="node_modules/showdown/dist/showdown.min.js"></script>
        <!---->
        <script src="node_modules/showdown-table/dist/showdown-table.min.js"></script>
        <!---->
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <!---->
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <!---->
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap-theme.min.css"/>
        <!---->
        <link rel="stylesheet" type="text/css" href="node_modules/font-awesome/css/font-awesome.min.css"/>
        <!---->
        <link href="https://fonts.googleapis.com/css?family=Inconsolata|Anonymous+Pro|Menlo|Ubuntu+Mono|Source+Code+Pro|Monospace|Dhurjati|Dosis|Share+Tech+Mono|Space+Mono|Titillium+Web" rel="stylesheet"/>
        <!---->
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <script src="js/showdown.angular.js"></script>
        <?php
        if($login){
        ?>
        <script src="js/sky-notes.angular.js"></script>
        <script src="js/sky-notes-notebook.angular.js"></script>
        <script src="js/sky-notes-service.angular.js"></script>
        <script src="js/sky-notes-main.angular.js"></script>
        <link rel="stylesheet" type="text/css" href="css/document.css" />
        <?php
        }
        else {
        ?>
        <script src="js/sky-notes.angular.js"></script>
        <script src="js/sky-notes-login-controller.js"></script>
        <?php
        }
        ?>
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
                <a class="navbar-brand" href="#">
                    <span>
                        <img src="logo/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    </span>
                    <span>
                        Sky notes - <i>keep your notes in the sky</i>
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
                    require_once('../views/main.php');
                }
                else {
                    require_once('../views/login.php');
                }
                ?>
            </div>
        </div>
        <?php
            require_once('../views/modals.php');
        ?>
    </body>
</html>
