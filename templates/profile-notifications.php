<ul class="list-group">
	<li class="profile-notification list-group-item" ng-repeat="notification in profile.notifications" ng-class="{'list-group-item-success':!profile.isSeen(notification)}" ng-mouseover="profile.seeNotification(notification)">
		<span class="bold" ng-bind="profile.getTitleOfNotification(notification)"></span><br />
		<span ng-bind="notification.text"></span>
	</li>
</ul>