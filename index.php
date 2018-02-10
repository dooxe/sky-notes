<?php
if(file_exists('.security/users.php')){
    require_once('.security/users.php');
}
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
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap-theme.min.css"/>
        <!---->
        <link rel="stylesheet" type="text/css" href="node_modules/font-awesome/css/font-awesome.min.css"/>
        <!---->
        <link href="https://fonts.googleapis.com/css?family=Dhurjati|Dosis|Share+Tech+Mono|Space+Mono|Titillium+Web" rel="stylesheet"/>
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
            <nav id="sn-navbar" class="navbar navbar-default navbar-fixed-top navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <a class="navbar-brand" href="#">
                            <span>
                                <img src="logo/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                            </span>
                            <span>
                                Sky notes - <i>keep your notes in the sky</i>
                            </span>
                        </a>
                        <ul class="nav navbar-nav pull-right">
                            <?php
                            if($login){
                            ?>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#sn-config-modal"
                                    style="font-size:24px" title="Configuration">
                                    <i class="fa fa-gears"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="glyphicon glyphicon-off"
                                    style="font-size:24px" title="Disconnect" ng-click="logout()">
                                </a>
                            </li>
                            <?php
                            }
                            ?>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#sn-about-modal" class="glyphicon glyphicon-info-sign"
                                    style="font-size:24px" title="About skynotes">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="sn-body" class="container-fluid">
                <?php
                if($login){
                ?>
                <div class="row">
                    <div id="sn-menu-container" class="col col-md-3">
                        <div id="sn-notebook-list-panel" class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    Notebooks
                                </h2>
                            </div>
                            <div class="panel-body">
                                <div class="navbar">
                                    <button href="#" class="btn pull-right" title="Create a new note"
                                        ng-click="showNewNoteModal()">
                                        <span class="glyphicon glyphicon-plus"></span>
                                         New note
                                         <span class="glyphicon glyphicon-file"></span>
                                    </button>
                                    <button href="#" class="btn pull-right" style="margin-right:10px" title="Create a new notebook"
                                        ng-click="showNewNotebookModal()">
                                        <span class="glyphicon glyphicon-plus"></span>
                                         New notebook
                                         <span class="glyphicon glyphicon-list-alt"></span>
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                                <div id="sn-notebook-list">
                                    <div ng-repeat="notebook in getNotebooks()" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h2 class="panel-title">
                                                <span class="glyphicon glyphicon-book"></span>
                                                {{notebook.title}}
                                                <div class="pull-right">
                                                <!-- NUMBER OF NOTES IN NOTEBOOK -->
                                                <span class="badge badge-primary badge-pill" title="{{getNumNotebooksByNotebookId(notebook.id)}} in this notebook">{{getNumNotebooksByNotebookId(notebook.id)}}</span>
                                                    <!-- SAVE NOTEBOOK -->
                                                    <a href="#" ng-click="showRenameNotebookModal(notebook)" class="badge badge-primary badge-pill" title="Save the notebook">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a>
                                                    <!-- REMOVE NOTEBOOK -->
                                                    <a href="#" ng-click="removeNotebook(notebook)" class="badge badge-primary badge-pill btn-danger">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </a>
                                                </div>
                                            </h2>
                                        </div>
                                        <div class="sn-notebook-notes panel-body">
                                            <table id="sn-note-list-table" class="table">
                                                <tr ng-repeat="note in getNotesByNotebookId(notebook.id)"
                                                    ng-class="{active:(currentNote==note)}"
                                                >
                                                    <td style="width:100%">
                                                        <a href="#" ng-click="setCurrentNote(note)">
                                                            <span class="glyphicon glyphicon-file"></span>
                                                            {{note.title}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button href="#" ng-click="removeNote(note)" class="btn btn-danger">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sn-editor-container" class="col col-md-9">
                        <div class="row">
                            <div class="col col-md-6">
                                <div id="sn-editor-panel" class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2 class="panel-title">
                                            Editor
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="input-group" style="margin-bottom:10px;">
                                                <span class="input-group-addon">Name</span>
                                                <input class="form-control" ng-disabled="!currentNote" type="text"  ng-model="currentNote.title"/>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">Notebook</span>
                                                <select class="form-control" ng-disabled="!currentNote" id="noteNotebookSelect" ng-model="currentNote.notebookId" ng-change="saveCurrentNote()">
                                                    <option ng-repeat="notebook in getNotebooks()" value="{{notebook.id}}">
                                                        {{notebook.title}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="sn-ace-editor" ui-ace="{
                                              useWrapMode : true,
                                              mode: 'markdown',
                                              onLoad: aceLoaded,
                                              onChange: aceChanged
                                            }"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div id="sn-preview-panel" class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2 class="panel-title">
                                            Preview
                                            <button ng-disable="!currentNote" ng-click="gotoPDF()" title="Generate the pdf of the note" class="btn btn-default pull-right">
                                                PDF <i class="fa fa-file-pdf-o"></i>
                                            </button>
                                            <div class="clearfix"></div>
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <div id="sn-markdown-preview" class="container-fluid">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                else {
                ?>
                <div ng-app="SkyNotes" ng-controller="SkyNotesLoginController" style="text-align:center">
                    <div class="panel panel-default" style="display:inline-block;margin:auto;margin-top:150px;">
                        <div class="panel-heading">
                            <div class="panel-title">Login</div>
                        </div>
                        <div class="panel-body">
                            <form>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="width:100px">Login</div>
                                        <input class="form-control" style="width:200px" type="text" ng-model="loginData.login" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="width:100px">Password</div>
                                        <input class="form-control" style="width:200px" type="password" ng-model="loginData.password"/>
                                    </div>
                                </div>
                                <div ng-if="error" class="form-group">
                                    <div class="alert alert-danger">
                                        <strong>Error:</strong> wrong user and/or password.
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-success" ng-click="tryLogin()">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
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
            <div class="modal-dialog" style="width:800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">
                            <i class="fa fa-gears"></i>
                            Configuration
                        </h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-sm-6">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon" id="sizing-addon1">Editor font</span>
                                        <span class="form-control" style="font-family:'{{config.fontFamily}}'">
                                            {{config.fontFamily}}
                                        </span>
                                        <div class="input-group-btn" role="group">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family:'{{config.fontFamily}}'">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li class="dropdown-item" ng-repeat="font in availableFonts">
                                                    <a href="#" style="font-family:'{{font}}'" ng-click="config.fontFamily=font">{{font}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Editor font size
                                        </span>
                                        <input type="number" class="form-control" ng-model="config.fontSize"
                                            min="10" max="20" step="0.5"
                                        />
                                        <span class="input-group-addon">
                                            px
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-sm-6">
                                <div ui-ace="{ readOnly: true,mode:'markdown'}" style="width:100%;height:200px;font-family:'{{config.fontFamily}}';font-size:{{config.fontSize}}px"># This is some
Example content.</div>
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
        <script>$('#sn-config-modal').modal('show');</script>
        <?php
        }
        ?>
    </body>
</html>
