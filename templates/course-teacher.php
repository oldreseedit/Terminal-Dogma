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
		    <div class="team-social-buttons" ng-controller="teamController as team">
				<div class="container">
					<a ng-repeat="icon in team.getTeacherInfo(course.teacher.name).socialNetworks" ng-href="{{icon.url}}" target="_blank">
						<div class="fa-stack" ng-class="team.spacedIcons($first)" ng-style="team.getFontSize()">
							<i class="fa fa-stack-2x fa-circle" ng-class="team.getColors(icon,hover)"></i>
							<i class="fa fa-stack-1x" ng-class="team.getColorsInverse(icon,hover)" ng-mouseover="hover=true;" ng-mouseleave="hover=false;"></i>
						</div>
					</a>
				</div>
			</div>
		</div>
	    <div class="teacher-description">
	        <p><span ng-bind-html="course.teacher.description"></span></p>
	    </div>
	</div>
</div>