<!--

-->
<div ng-app="SkyNotes" ng-controller="SkyNotesLoginController" style="text-align:center">
    <div class="card card-default" style="display:inline-block;margin:auto;margin-top:150px">
        <div class="card-header">
            <h3 class="card-title">Login</h3>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width:100px">
                                Login
                            </span>
                        </div>
                        <input class="form-control" style="width:200px" type="text" ng-model="loginData.login" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                        	<i class="fa fa-user"></i>
			</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width:100px">Password</span>
                        </div>
                        <input class="form-control" style="width:200px" type="password" ng-model="loginData.password"/>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div ng-if="error" class="form-group">
                    <div class="alert alert-danger">
                        <strong>Error:</strong> wrong user and/or password.
                    </div>
                </div>
                <div>
                    <button class="btn btn-success" ng-click="tryLogin()"  style="width:100%">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
