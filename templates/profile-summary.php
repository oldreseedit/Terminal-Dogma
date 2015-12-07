<div class="container">
	<div class="profile-level-symbol" centered>
		<span class="fa-stack fa-stack-10x clickable" fittext ng-click="avatar.changeAvatar(profile.username,profile.avatar)" ng-controller="avatarController as avatar">
			<img ng-src="{{profile.avatar}}" ng-class="{'avatar': !profile.isDefaultAvatar(), 'avatar-leaf' : profile.isDefaultAvatar() }" />
		</span>
	</div>
	<div class="profile-name-level-xp">
		<p fittext="0.8">
			<span ng-bind="profile.username"></span>
		</p><br />
		<p class="seed-level" fittext="0.5">
			Seed Level: <span ng-bind="profile.expInfo.level"></span>
		</p>
		<div class="profile-xp">
			<div class="container">
				<uib-progressbar class="progress-striped active" value="profile.expInfo.partialExperience" max="profile.expInfo.experienceDifference"  title="Esperienza">
					<span ng-if="profile.expInfo.partialExperience/profile.expInfo.experienceDifference > 0.1">
						<span class="middler"></span><span class="middle" ng-bind="profile.expInfo.partialExperience"></span>/<span class="middle" ng-bind="profile.expInfo.experienceDifference"></span>
					</span>
				</uib-progressbar>
			</div>
		</div>
	</div>
</div>
<div class="profile-info">
	<div class="container">
		<p ng-if="profile.lastAchievement || profile.nextReward">
			<span class="bold" ng-if="profile.lastAchievement">Ultimo Achievement: </span><span ng-bind="profile.lastAchievement"></span><br ng-if="profile.lastAchievement"/>
			<span class="bold" ng-if="profile.nextReward">Prossima Reward: </span><span ng-bind="profile.nextReward"></span><br />
		</p>
		<p ng-if="profile.courses && profile.isMyProfile()" >
			<span class="bold">I tuoi corsi: </span><br />
			<ul>
				<li ng-repeat="course in profile.courses"><a ng-href="#!/courses/{{course.courseID}}"><span ng-bind="course.name"></span></a></li>
			</ul>
		</p>
	</div>
</div>