<table class="table table-striped text-center profile-rewards">
	<tr>
		<td class="bg-grey"></td>
		<td class="bg-grey">Level</td>
		<td class="bg-grey">Reward</td>
	</tr>
	<tr ng-repeat="reward in profile.rewards">
		<td>
			<span class="fa-stack fa-2x grey">
				<i class="fa fa-bookmark-o  fa-stack-2x" ng-class="{'dark-green':reward.username}"></i>
				<i class="fa fa-star fa-stack-1x" ng-class="{'dark-green':reward.username}"></i>
			</span>
		</td>
		<td><span class="middler"></span><span class="middle" ng-bind="reward.level"></span></td>
		<td><span class="middler"></span><span class="middle" ng-bind="reward.description"></span></td>
	</tr>
</table>