<div class="row">
    <div id="sn-menu-container" class="col col-md-4 col-lg-3">
        <div id="sn-notebook-list-panel" class="card card-default">
            <div class="card-header">
                <h5 class="card-title">
                     Notebooks
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <button href="#" class="btn btn-secondary pull-right" title="Create a new note"
                        ng-click="showNewNoteModal()">
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-file" style="margin-left:10px"></i>
                    </button>
                    <button href="#" class="btn btn-secondary pull-right" style="margin-right:10px" title="Create a new notebook"
                        ng-click="showNewNotebookModal()">
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-book" style="margin-left:10px"></i>
                    </button>
                <div class="clearfix"></div>
                </div>
                <div id="sn-notebook-list">
                	<div ng-repeat="notebook in getNotebooks()" style="margin-bottom:20px;" class="card card-default">
                		<div class="card-header">
                    		<h5 class="card-title">
                                <span class="title-text">
                        			<i class="fa fa-book" style="margin-right:10px"></i>
                        			{{notebook.title}}
                                </span>
                                <div class="pull-right">
                                    <button ng-click="showRenameNotebookModal(notebook)" class="btn btn-secondary" title="Save the notebook">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button href="#" ng-click="removeNotebook(notebook)" class="btn btn-secondary btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                    		</h5>
                            <div class="clearfix"></div>
                		</div>
                		<div class="card-body" style="padding:0">
                		<div class="list-group">
                			<a class="list-group-item note" href="#" ng-repeat="note in getNotesByNotebookId(notebook.id)"
                            ng-class="{'active':(currentNote==note)}" ng-click="setCurrentNote(note)" style="border-radius:0">
                                    <i class="fa fa-file" style="margin-right:10px"></i>
                                    {{note.title}}
                                    <span class="pull-right">
                                    <button href="#" ng-click="removeNote(note)" class="btn btn-danger">
		                                <i class="fa fa-trash"></i>
		                            </button>
		                            </span>
		                            <div class="clearfix"></div>
                             </a>
                		</div>
                		</div>
                	</div>
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
    <div class="col col-md-5 col-lg-4 d-md-none d-lg-block">
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
