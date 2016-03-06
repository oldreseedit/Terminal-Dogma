<table class="table table-striped text-center profile-high-scores">
	<tr>
		<td colspan="2" class="bg-grey"><p>Utente</p></td>
		<td class="bg-grey"><p>Livello</p></td>
		<td class="bg-grey"><p>Esperienza</p></td>
	</tr>
	<tr ng-repeat="score in profile.highscores">
		<td style="vertical-align: middle"><img class="resp-img fa-stack fa-3x" style="margin-right: 1em" ng-src="{{score.avatar}}" /></td>
		<td align="left" style="vertical-align: middle">
			<p><a href="/profile/{{score.username}}"><span class="middle" ng-bind="score.username"></span></a></p>
		</td>
		<td style="vertical-align: middle"><p><span ng-bind="score.level" centered></span></p></td>
		<td style="vertical-align: middle"><p><span title="{{score.exp}}" ng-bind="(score.exp | experiencePointsFormatter)" centered></span></p></td>
	</tr>
</table>