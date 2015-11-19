<div id="admin" ng-controller="adminController as admin">
    <div class="container">
        <div class="wrapper" ng-repeat="i in admin.numberOfRows">
            <div class="container">
                <div class="tab" ng-repeat="tab in [admin.tabs[2*i],admin.tabs[2*i+1]]" ng-init="index = 2*i+$index" ng-class="admin.spaced(index)" id="{{tab.id}}">
                    <div class="panel panel-default" ng-if="admin.checkIfTabExists(index)">
                        <div class="panel-heading">
                            <h3 class="panel-title" ng-bind="tab.title"></h3>
                        </div>
                        <div class="panel-body">
                            <div class="container">
                                <button class="btn btn-lg btn-success" ng-class="admin.spacedButtons(0)" ng-bind="tab.add.title" ng-click="admin.select(index,'add')"></button>
                                <button class="btn btn-lg btn-warning" ng-class="admin.spacedButtons(1)" ng-bind="tab.modify.title" ng-click="admin.select(index,'modify')"></button>
                                <button class="btn btn-lg btn-danger" ng-class="admin.spacedButtons(2)" ng-bind="tab.remove.title" ng-click="admin.select(index,'remove')"></button>
                                <div class="admin-content" ng-if="admin.selectedTab === index">
                                    <div class="container" ng-include="admin.tabs[admin.selectedTab][admin.selectedFunction].content">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>