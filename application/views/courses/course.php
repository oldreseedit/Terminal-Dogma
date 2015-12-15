<div id="singleCourse">
    <div class="container">
        <div gridster>
			<div class="gridster-item bg-light-grey" gridster-item="item" ng-repeat="item in gridsterItems" gridster-auto-resize ng-init="index = $index">
                <div ng-if="item.id === 'courseBanner'" class="container banner bg-dark-water text-center">
					<div class="container" ng-include="item.templateUrl"></div>
				</div>
                <div class="container" ng-if="item.id !== 'courseBanner'">
                    <div class="panel-title" ng-class="item.bgColour">
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