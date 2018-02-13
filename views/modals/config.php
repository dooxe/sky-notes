<!-- Modal for notebook renaming -->
<div id="sn-config-modal" class="sn-modal modal fade">
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
