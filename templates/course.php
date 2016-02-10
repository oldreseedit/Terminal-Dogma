<div id="singleCourse">

	<div clickable class="pay-button" ng-click="course.addCourse(course.courseInfo.courseID, course.courseInfo.price)">
		<img src="imgs/iscriviti.png">
	</div>
	
    <div class="container">
		<div  ng-repeat="item in course.items" ng-init="index = $index">
			<div class="clearfix" ng-if="course.isNewRow(index)"></div>
	        <div class="no-gridster-item bg-light-grey" ng-class="course.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
	        	<div ng-if="item.id === 'courseBanner'" class="container banner bg-dark-water text-center" >
					<div ng-include="item.templateUrl"></div>
				</div>
	            <div class="container" ng-if="item.id !== 'courseBanner'">
	            	<div class="panel-title bg-lawn">
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