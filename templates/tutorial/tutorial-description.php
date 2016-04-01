<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-description">
            	<img ng-if="!tutorialV.tutorial.mainImage" class="tutorial-icon" height="128px" ng-src="imgs/no-image.png">
				<img ng-if="tutorialV.tutorial.mainImage" style="margin: 0 auto; display: block;" ng-src="{{tutorialV.tutorial.mainImage}}">
				<compile-html src="tutorialV.tutorial.description"></compile-html>
            </div>
        </div>
    </div>
</div>