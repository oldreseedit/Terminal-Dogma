<div class="profile-level-symbol">
	<img src="imgs/leaf.png" class="resp-img" />
</div>
<div class="profile-name-level-xp">
	<span ng-bind="profile.username" fittext="0.8"></span>
	<p>
		Seed Level: <span ng-bind="profile.expInfo.level"></span>
	</p>
	<div class="profile-xp">
		<div class="container">
			<uib-progressbar class="progress-striped active" type="success" value="profile.expInfo.partialExperience" max="profile.expInfo.missingExpForNextLevel"
				type="profile.xpBarTypes()" title="Esperienza"> <span
				ng-bind="profile.expInfo.partialExperience"></span>/<span ng-bind="profile.expInfo.missingExpForNextLevel"></span>
			</uib-progressbar>
		</div>
	</div>
</div>
<div class="profile-info">
	<div class="container">
		<p ng-if="profile.lastAchievement || profile.nextReward">
			<span class="bold" ng-if="profile.lastAchievement">Ultimo Achievement: </span><span ng-bind="profile.lastAchievement"></span><br />
			<span class="bold" ng-if="profile.nextReward">Prossima Reward: </span><span ng-bind="profile.nextReward"></span><br />
		</p>
		<p ng-if="profile.courses">
			<span class="bold">I tuoi corsi: </span><br />
			<ul>
				<li ng-repeat="course in profile.courses"><a ng-href="#!/courses/{{course.courseID}}"><span ng-bind="course.name"></span></a></li>
			</ul>
		</p>
	</div>
</div>