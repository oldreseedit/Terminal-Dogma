<div id="singleCourse">
    <div class="container">
        <div gridster>
            <div class="gridster-item bg-light-grey" gridster-item="course.customItemMap" id="gridsterItem{{index}}" ng-repeat="item in course.items" ng-init="index = $index">
                <div class="container" ng-if="course.gridsterIsReady">
                    <div class="course-panel-title" ng-class="item.bgColour">
                        <h4 ng-bind="item.title"></h4>
                    </div>
                    <div class="course-panel-content">
                        <div class="container" id="gridsterItem{{index}}View">
<!--                             <perfect-scrollbar class="scrollbar-wrapper" suppressScrollX="true"> -->
<!--                             <div class="scrollbar"> -->
                                    <div ng-include="item.templateUrl"></div>
<!--                             </div> -->
<!--                             </perfect-scrollbar> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>