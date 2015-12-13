<style>
.banner {
  line-height: 5vw;
  margin: 0 12px;
}

.banner p {
	color: black;
	font-weight: bold;
}

.banner emph {
	color: white;
}
</style>

<div id="singleCourse">
    <div class="container">
    	<div class="container banner bg-dark-water">
    		<p>Il corso <emph>non</emph> è ancora partito.</p>
    	</div>
        <div gridster>
            <div class="gridster-item bg-light-grey" gridster-item="course.customItemMap" ng-repeat="item in gridsterItems" gridster-auto-resize  ng-init="index = $index">
                <div class="container">
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