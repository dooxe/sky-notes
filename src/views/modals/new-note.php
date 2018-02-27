<!-- Modal for the note -->
<div id="sn-new-note-modal" class="sn-modal modal fade">
    <div class="modal-dialog">
        <div class="modal-content sn-modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-file"></i>
                    Create a new note
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text">Notebook</span>
                        </span>
                        <select class="form-control" id="sel1" ng-model="newNoteNotebookId">
                            <option ng-repeat="notebook in getNotebooks()" value="{{notebook.id}}">
                                {{notebook.title}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text">Note title</span>
                        </span>
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
