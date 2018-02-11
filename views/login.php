<!--

-->
<div ng-app="SkyNotes" ng-controller="SkyNotesLoginController" style="text-align:center">
    <div class="card card-default" style="display:inline-block;margin:auto;margin-top:150px;">
        <div class="card-header">
            <div class="card-title">Login</div>
        </div>
        <div class="card-body">
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
