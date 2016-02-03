<table class="table table-striped text-center profile-high-scores">
	<tr>
		<td colspan="2" class="bg-grey">Utente</td>
		<td class="bg-grey">Livello</td>
		<td class="bg-grey">Esperienza</td>
	</tr>
	<tr ng-repeat="score in profile.highscores">
		<td><img class="fa-stack" style="margin-right: 10px;" ng-src="{{score.avatar}}" /></td>
		<td align="left">
			<a href="/profile/{{score.username}}"><span class="middle" ng-bind="score.username"></span></a>
		</td>
		<td><span ng-bind="score.level" centered></span></td>
		<td><span title="{{score.exp}}" ng-bind="(score.exp | experiencePointsFormatter)" centered></span></td>
	</tr>
</table>