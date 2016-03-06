<table class="table table-striped text-center profile-rewards">
	<tr>
		<td class="bg-grey"></td>
		<td class="bg-grey"><p>Level</p></td>
		<td class="bg-grey"><p>Reward</p></td>
	</tr>
	<tr ng-repeat="reward in profile.rewards">
		<td>
			<span class="fa-stack fa-2x grey">
				<i class="fa fa-bookmark-o  fa-stack-2x" ng-class="{'dark-green':reward.username}"></i>
				<i class="fa fa-star fa-stack-1x" ng-class="{'dark-green':reward.username}"></i>
			</span>
		</td>
		<td><p><span class="middler"></span><span class="middle" ng-bind="reward.level"></span></p></td>
		<td><p><span ng-bind="reward.description" centered></span></p></td>
	</tr>
</table>