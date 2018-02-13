<!-- Modal for information about -->
<div id="sn-confirm-modal" class="sn-modal modal fade">
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
