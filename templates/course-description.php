<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-description">
				<img alt="{{course.courseID}}" ng-src="imgs/{{course.courseID}}.png" class="course-icon">
                <span ng-bind-html="course.courseDescription.description"></span>
            </div>
        </div>
    </div>
    <h5>Programma</h5>
    <div class="course-description-syllabus">
    	<span ng-bind-html="course.courseDescription.syllabus"></span>
    </div>
</div>