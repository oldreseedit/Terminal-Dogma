<ul class="list-group">
	<li class="profile-notification" ng-repeat="notification in profile.notifications" ng-class="{'list-group-item-success white':!profile.isSeen(notification)}">
		<span class="bold" ng-bind="profile.getTitleOfNotification(notification)"></span><br />
		<span ng-bind="notification.text"></span>
	</li>
</ul>