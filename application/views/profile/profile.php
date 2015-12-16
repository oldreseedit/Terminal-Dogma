<div id="profile">
    <div class="container">
        <div gridster>
            <div class="gridster-item bg-light-grey" gridster-item="item" ng-repeat="item in gridsterItems" gridster-auto-resize ng-init="index = $index">
                <div class="container">
                    <div class="panel-title" ng-class="item.bgColour">
                        <h4 ng-bind="item.title"></h4>
                    </div>
                    <div class="scrollbar-wrapper">
                    	<div class="scrollbar">
		                    <div class="panel-content">
		                        <div class="container">
	                            	<div ng-include="item.templateUrl"></div>
		                        </div>
		                    </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>