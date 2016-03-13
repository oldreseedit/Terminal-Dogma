<table class="table table-striped text-center profile-high-scores">
	<tr>
		<td colspan="2" class="bg-grey"><p>Utente</p></td>
		<td class="bg-grey"><p>Livello</p></td>
		<td class="bg-grey"><p>Esperienza</p></td>
	</tr>
	<tr ng-repeat="score in profile.highscores">
		<td><img class="resp-img fa-stack high-score-img" ng-src="{{score.avatar}}" /></td>
		<td>
			<p class="high-score-name"><a href="/profile/{{score.username}}"><span class="middle" ng-bind="score.username"></span></a></p>
		</td>
		<td ><p><span ng-bind="score.level"></span></p></td>
		<td ><p><span title="{{score.exp}}" ng-bind="(score.exp | experiencePointsFormatter)"></span></p></td>
	</tr>
</table>