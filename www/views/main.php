<div class="row">
    <div id="sn-menu-container" class="col col-md-4 col-lg-3">
        <div id="sn-notebook-list-panel" class="card card-default">
            <div class="card-header">
                <h5 class="card-title">
                     Notebooks
                </h5>
            </div>
            <div class="card-body">
                <div>
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
                    <table class="table" ng-repeat="notebook in getNotebooks()" style="margin-bottom:40px;">
                        <tr>
                            <th>
                                <i class="fa fa-book" style="margin-right:10px"></i>
                                {{notebook.title}}
                            </th>
                            <th style="text-align:right;width:128px">
                                <button ng-click="showRenameNotebookModal(notebook)" class="btn btn-scondary" title="Save the notebook">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button href="#" ng-click="removeNotebook(notebook)" class="btn btn-secondary btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </th>
                        </tr>
                        <tr ng-repeat="note in getNotesByNotebookId(notebook.id)"
                            ng-class="{'table-active':(currentNote==note)}">
                            <td>
                                <a href="#" ng-click="setCurrentNote(note)">
                                    <i class="fa fa-file" style="margin-right:10px"></i>
                                    {{note.title}}
                                </a>
                            </td>
                            <td style="text-align:right">
                                <button href="#" ng-click="removeNote(note)" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-md-8 col-lg-5">
        <div id="sn-editor-panel" class="card card-default">
            <div class="card-header">
                <h5 class="card-title">
                    Editor
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="input-group" style="margin-bottom:10px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width:125px;">Name</span>
                        </div>
                        <input class="form-control" ng-disabled="!currentNote" type="text"  ng-model="currentNote.title"/>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width:125px;">Notebook</span>
                        </div>
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
    <div class="col col-md-5 col-lg-4">
        <div id="sn-preview-panel" class="card card-default">
            <div class="card-header">
                <h5 class="card-title">
                    Preview
                    <button ng-disable="!currentNote" ng-click="gotoPDF()" title="Generate the pdf of the note" class="btn btn-default pull-right">
                        PDF <i class="fa fa-file-pdf-o"></i>
                    </button>
                    <div class="clearfix"></div>
                </h5>
            </div>
            <div class="card-body">
                <div id="sn-markdown-preview" class="container-fluid">

                </div>
            </div>
        </div>
    </div>
</div>
