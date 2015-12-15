<div id="singleCourse">
    <div class="container">
        <div gridster>
			<div class="gridster-item bg-light-grey" gridster-item="item" ng-repeat="item in gridsterItems" gridster-auto-resize ng-init="index = $index">
                <div class="container">
                	<div ng-if="item.id === 'courseBanner'" class="banner bg-dark-water text-center">
						<div class="container" ng-include="item.templateUrl"></div>
					</div>
                    <div class="panel-title" ng-class="item.bgColour" ng-if="item.id !== 'banner'">
                        <h4 ng-bind="item.title"></h4>
                    </div>
                    <div class="panel-content">
                        <div class="container">
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