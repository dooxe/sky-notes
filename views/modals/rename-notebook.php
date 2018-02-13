<!-- Modal for notebook renaming -->
<div id="sn-rename-notebook-modal" class="sn-modal modal fade">
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
                        <span class="input-group-prepend">
                            <span class="input-group-text">New notebook title</span>
                        </span>
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
