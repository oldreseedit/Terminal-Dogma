<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-description">
            	<uib-carousel interval="10000" ng-if="!imOnResponsive">
            		<uib-slide ng-repeat="imageUrl in course.courseInfo.images">
            			<img ng-src="{{imageUrl}}"/>
            		</uib-slide>
            	</uib-carousel>
                <p><span ng-bind-html="course.courseInfo.description"></span></p>
            </div>
        </div>
    </div>
</div>