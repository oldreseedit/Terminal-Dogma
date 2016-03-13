<table class="table table-striped text-center">
	<tr ng-repeat="achievement in profile.achievements" >
		<td><span class="fa-stack fa-2x grey"><i class="fa fa-circle-thin  fa-stack-2x" ng-class="{'green':achievement.username}"></i><i class="fa fa-trophy fa-stack-1x" ng-class="{'green':achievement.username}"></i></span></td>
		<td><p ng-bind="achievement.description"></p></td>
	</tr>
</table>