<div id="singleCourse">
    <div class="container">
		<div  ng-repeat="item in course.items" ng-init="index = $index">
			<div class="clearfix" ng-if="course.isNewRow(index)"></div>
	        <div class="no-gridster-item bg-light-grey" ng-class="course.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
	        	<div ng-if="item.id === 'courseBanner'" class="container banner bg-dark-water text-center" >
					<div ng-include="item.templateUrl"></div>
				</div>
	            <div class="container" ng-if="item.id !== 'courseBanner'">
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