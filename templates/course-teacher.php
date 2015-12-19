<div class="container text-center">
    <div class="teacher-avatar" spinner="course.teacherAjax">
    	<spinner-place class="fa-4x"></spinner-place>
        <img class="circle-img" spinner-final ng-src="{{course.teacher.picture}}"></img>
    </div>
    <div class="teacher-name">
        <h5 ng-bind="course.teacher.name"></h5>
    </div>
    <div class="teacher-description">
        <p><span ng-bind-html="course.teacher.description"></span></p>
    </div>
</div>