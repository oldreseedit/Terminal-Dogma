<table class="table table-striped text-center">
	<tr>
		<td class="bg-grey">Level</td>
		<td class="bg-grey">Reward</td>
	</tr>
	<tr ng-repeat="reward in profile.rewards">
		<td ng-bind="reward.level"></td>
		<td ng-bind="reward.content"></td>
	</tr>
</table>