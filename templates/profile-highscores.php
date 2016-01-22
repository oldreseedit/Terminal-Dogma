<table class="table table-striped text-center profile-rewards">
	<tr>
		<td class="bg-grey">Utente</td>
		<td class="bg-grey">Livello</td>
		<td class="bg-grey">Esperienza</td>
	</tr>
	<tr ng-repeat="score in profile.highscores">
		<td><a href="#!/profile/{{score.username}}"><span class="middle" ng-bind="score.username"></span></a></td>
		<td><span ng-bind="score.level" centered></span></td>
		<td><span ng-bind="score.exp" centered></span></td>
	</tr>
</table>