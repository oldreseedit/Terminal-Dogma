<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-description">
				<img alt="{{course.courseID}}" ng-src="imgs/{{course.courseInfo.icon}}.png" class="course-icon">
                <span ng-bind-html="course.courseInfo.description"></span>
            </div>
        </div>
    </div>
    <h5>Programma</h5>
    <div class="course-description-syllabus">
    	<span ng-bind-html="course.courseInfo.syllabus"></span>
    </div>
</div>