<div id="singleActivity">
    <div class="container">
        <div gridster="gridsterOpts">
            <div class="gridster-item bg-light-grey" gridster-item="course.customItemMap" ng-repeat="item in gridsterItems" ng-init="index = $index" ng-controller="gridsterResizeController">
                <div class="container" ng-if="ready">
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