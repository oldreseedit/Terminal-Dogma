<div class="container text-center">
	<div ng-if="!course.teacher">Il docente per questo corso non è stato ancora deciso.</div>
	<div ng-if="course.teacher">
		<div class="teacher-icon">
		    <div class="teacher-avatar" spinner="course.teacherAjax">
		    	<spinner-place class="fa-4x"></spinner-place>
		        <img class="circle-img" spinner-final ng-src="{{course.teacher.picture}}"></img>
		    </div>
		    <div class="teacher-name">
		        <h6 ng-bind="course.teacher.name"></h6>
		    </div>
		</div>
	    <div class="teacher-description">
	        <p><span ng-bind-html="course.teacher.description"></span></p>
	    </div>
	</div>
</div>