<table class="table table-striped text-center">
	<tr ng-repeat="achievement in profile.achievements" ng-class="{'success':achievement.username}">
		<td><span ng-bind="achievement.description"></span></td>
	</tr>
</table>