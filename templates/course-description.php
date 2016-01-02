<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-icon equal-height">
                <span ng-class="'icon-'+course.courseDescription.icon" fittext="0.8"></span>
            </div>
            <div class="course-description equal-height">
                <span ng-bind-html="course.courseDescription.description"></span>
            </div>
        </div>
    </div>
    <h5>Programma</h5>
    <div class="course-description-syllabus">
    	<span ng-bind-html="course.courseDescription.syllabus"></span>
    </div>
</div>