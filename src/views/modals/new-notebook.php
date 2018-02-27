<!-- Modal for the notebook -->
<div id="sn-new-notebook-modal" class="sn-modal modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-book"></i>
                    Create a notebook
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text">Notebook title</span>
                        </span>
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
