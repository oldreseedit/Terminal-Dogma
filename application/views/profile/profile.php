<div id="profile">
    <div class="container">
        <div gridster>
            <div class="gridster-item bg-light-grey" gridster-item="profile.customItemMap" ng-repeat="item in gridsterItems" ng-init="index = $index" ng-controller="gridsterResizeController">
                <div class="container" ng-if="ready">
                    <div class="profile-panel-title" ng-class="item.bgColour">
                        <h4 ng-bind="item.title"></h4>
                    </div>
                    <div class="profile-panel-content">
                        <div class="container" gridster-content>
                            <perfect-scrollbar class="scrollbar-wrapper" suppressScrollX="true">
	                            <div class="scrollbar">
	                            	<div class="container">
	                                    <div ng-include="item.templateUrl"></div>
                                    </div>
	                            </div>
                            </perfect-scrollbar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>