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
        <script src="js/sky-notes.angular.js"></script>
        <?php
        if(!$login){
        ?>
        <script src="js/sky-notes-login-controller.js"></script>
        <?php
        }
        else {
        ?>
        <script src="js/sky-notes-notebook.angular.js"></script>
        <script src="js/sky-notes-service.angular.js"></script>
        <script src="js/sky-notes-main.angular.js"></script>
        <?php
        }
        ?>
    </head>
    <body <?php
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
                    require_once('views/main.php');
                }
                else {
                    require_once('views/login.php');
                }
                ?>
            </div>
            <div id="sn-footer">

            </div>
        </div>

        <?php
        if($login){
        ?>
        <!-- Modal for the note -->
        <div id="sn-new-note-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create a new note
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Notebook</span>
                                <select class="form-control" id="sel1" ng-model="newNoteNotebookId">
                                    <option ng-repeat="notebook in getNotebooks()" value="{{notebook.id}}">
                                        {{notebook.title}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Note title</span>
                                <input class="form-control" type="text" ng-model="newNoteTitle"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" ng-click="createNote()">OK</button>
                        <button class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for the notebook -->
        <div id="sn-new-notebook-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <span class="glyphicon glyphicon-book"></span>
                            Create a notebook
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Notebook title</span>
                                <input class="form-control" type="text" ng-model="newNotebookTitle"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" ng-click="createNotebook()">OK</button>
                        <button class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for information about -->
        <div id="sn-about-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center">
                        <h2 class="modal-title">
                            Sky notes
                        </h2>
                    </div>
                    <div class="modal-body" style="text-align:center">
                        <img src="logo/logo-large.png" alt="">
                        <p>
                            <h3>Author</h3>
                            <div style="font-size:1.5em">dooxe</div>
                            <a href="http://dooxe-creative.net/" target="_blank">
                                http://dooxe-creative.net/
                            </a>
                        </p>
                        <p>
                            <h3>Project repository</h3>
                            <a href="https://github.com/dooxe/sky-notes" target="_blank">
                                https://github.com/dooxe/sky-notes
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for information about -->
        <div id="sn-confirm-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">
                            Are you sure ?
                        </h2>
                    </div>
                    <div class="modal-body" ng-bind-html="windowConfirmMessage">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" ng-click="confirm()">OK</button>
                        <button class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for notebook renaming -->
        <div id="sn-rename-notebook-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">
                            Rename a notebook
                        </h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">New notebook title</span>
                                <input class="form-control" type="text" ng-model="renamedNotebook.title"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" ng-click="renameNotebook()">OK</button>
                        <button class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for notebook renaming -->
        <div id="sn-config-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">
                            <i class="fa fa-gears"></i>
                            Configuration
                        </h2>
                    </div>
                    <div class="modal-body">
                        <div class="card card-default" style="margin-bottom:20px">
                            <div class="card-header">
                                <h3 class="card-title">Editor</h3>
                            </div>
                            <div class="card-body">
                                <div class="row" style="margin-left:0;margin-right:0">
                                    <div class="col col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" id="sizing-addon1">
                                                    <span class="input-group-text" style="width:140px">Theme</span>
                                                </div>
                                                <span class="form-control">
                                                    {{config.editorTheme}}
                                                </span>
                                                <div class="input-group-append input-group-btn dropleft" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:48px;font-family:'{{config.fontFamily}}'">
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:350px;height:250px;overflow-y:auto">
                                                        <a href="#" ng-click="setConfigTheme(theme)" class="dropdown-item" ng-repeat="theme in availableTheme" style="margin-bottom:10px;">
                                                            <i class="fa fa-paint-brush"></i>{{theme}}
                                                            <div ui-ace='{theme:theme,onLoad:aceThemeEditorSampleLoaded}' style="height:48px"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" id="sizing-addon2">
                                                    <span class="input-group-text" style="width:140px">Font family</span>
                                                </div>
                                                <span class="form-control" style="font-family:'{{config.fontFamily}}'">
                                                    {{config.fontFamily}}
                                                </span>
                                                <div class="input-group-btn input-group-append dropleft" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:48px;font-family:'{{config.fontFamily}}'">
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="#" class="dropdown-item" ng-repeat="font in availableFonts" ng-click="config.fontFamily=font">
                                                            <span  style="font-family:'{{font}}'" >{{font}}</a>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="width:140px">Editor font size</span>
                                                </div>
                                                <input type="number" class="form-control" ng-model="config.fontSize"
                                                    min="10" max="20" step="0.5"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="width:48px">px</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-sm-6">
                                        <div ui-ace="{ readOnly: true,mode:'markdown', onLoad:sampleEditorLoaded}" style="width:100%;height:200px;font-family:'{{config.fontFamily}}';font-size:{{config.fontSize}}px">
                                            # This is some
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">PDF Generation</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" id="sizing-addon2">
                                                    <span class="input-group-text">Style</span>
                                                </div>
                                                <span class="form-control" style="font-family:'{{config.fontFamily}}'">
                                                    Style
                                                </span>
                                                <div class="input-group-btn dropleft input-group-append" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:48px">
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li class="dropdown-item">
                                                            <a href="#">Modern</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-sm-6">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" ng-click="saveConfig()">OK</button>
                        <button class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </body>
</html>
