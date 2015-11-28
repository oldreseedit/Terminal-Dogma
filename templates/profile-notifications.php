<div class="profile-notifications" ng-repeat="notification in profile.notifications">
	<span class="bold" ng-bind="profile.getTitleOfNotification(notification)" ng-class="{'green':notification.seen,'dark-green':!notification.seen}"></span><br />
	<span ng-bind="notification.text"></span>
</div>