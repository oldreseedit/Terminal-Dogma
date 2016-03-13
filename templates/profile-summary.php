<div class="container profile-summary">
	<div class="profile-level-symbol" spinner="profile.avatarAjax">
		<spinner-place></spinner-place>
		<span class="fa-stack clickable" ng-click="avatar.changeAvatar(profile.username,profile.avatar)" ng-controller="avatarController as avatar" spinner-final>
			<img ng-src="{{profile.avatar}}" ng-class="{'avatar': !profile.isDefaultAvatar(), 'avatar-leaf' : profile.isDefaultAvatar() }" />
		</span>
	</div>
	<div class="profile-name-level-xp">
		<p class="name">
			<span class="water" ng-bind="profile.username"></span>
		</p><br />
		
		<p class="seed-level">
			Seed Level: <span ng-bind="profile.expInfo.level"></span>
		</p>
		
		<div class="profile-xp">
			<div class="container">
				<uib-progressbar class="progress-striped active" value="profile.expInfo.partialExperience" max="profile.expInfo.experienceDifference"  title="Esperienza">
					<span ng-if="profile.expInfo.partialExperience/profile.expInfo.experienceDifference > 0.1">
						<span class="middler"></span><p class="inline no-padding white"><span class="middle" ng-bind="profile.expInfo.partialExperience"></span>/<span class="middle" ng-bind="profile.expInfo.experienceDifference"></span></p>
					</span>
				</uib-progressbar>
			</div>
		</div>
	</div>
</div>
<div class="profile-info">
	<div class="container">
		<p ng-if="profile.lastAchievement || profile.nextReward">
			<span class="bold" ng-if="profile.lastAchievement">Ultimo Achievement: </span><span ng-bind="profile.lastAchievement"></span><br ng-if="profile.nextReward"/>
			<span class="bold" ng-if="profile.nextReward">Prossima Reward: </span><span ng-bind="profile.nextReward"></span><br />
		</p>
		<div ng-if="profile.courses.length > 0 && profile.isMyProfile()">
			<p class="bold">I tuoi corsi: </p>
			<ul>
				<li ng-repeat="course in profile.courses">
					<p>
					<a ng-href="/courses/{{course.courseID}}">
						<span ng-bind="course.name"></span>
					</a>
					</p>
				</li>
			</ul>
		</div>
	</div>
</div>