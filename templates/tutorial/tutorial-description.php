<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-description">
            	<img ng-if="!tutorialV.tutorial.images" class="tutorial-icon" height="128px" ng-src="imgs/no-image.png">
				<img ng-if="tutorialV.tutorial.images" style="margin: 0 auto; display: block;" ng-src="{{tutorialV.tutorial.images}}">
                <p><span ng-bind-html="tutorialV.tutorial.description"></span></p>
            </div>
        </div>
    </div>
</div>