<div class="container text-center">
    <div class="teacher-avatar">
        <img class="circle-img" ng-src="{{course.teacher.avatarURL}}"></img>
    </div>
    <div class="teacher-name">
        <h5 ng-bind="course.teacher.name"></h5>
    </div>
    <div class="teacher-description">
        <p><span ng-bind-html="course.teacher.description"></span></p>
    </div>
</div>