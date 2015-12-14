<div id="singleCourse">
    <div class="container">
        <div gridster>
		<div class="gridster-item bg-light-grey" gridster-item="item" ng-repeat="item in gridsterItems" gridster-auto-resize ng-init="index = $index">
				<div ng-if="item.id === 'banner'" class="container banner bg-dark-water text-center">
<!-- 					<div ng-include="item.templateUrl"></div> -->
						<p centered>
							<span><span ng-bind="course.courseDescription.duration"></span> ore, </span>
							<span><emph><span ng-bind="course.hourPrice"></span> €</emph> l'ora.</span>
							<span>Il corso </span>
							<span ng-if="course.courseHasStarted">è partito </span>
							<span ng-if="!course.courseHasStarted">partirà </span>
							<emph><time title="precisamente: il {{course.courseDescription.startingDate | amCalendar}}" am-time-ago="course.courseDescription.startingDate"></time></emph>
							<span>.</span>
							<span ng-if="!course.courseHasStarted && course.firstLesson">La prima lezione si terrà 
								<emph><time ng-bind="course.firstLesson"></time></emph>
							</span>
							<span ng-if="!course.courseHasStarted && !course.firstLesson">La data della prima lezione non è stata ancora decisa.</span>
						</p>
				</div>
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