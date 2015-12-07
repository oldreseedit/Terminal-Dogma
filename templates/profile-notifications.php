<ul class="list-group" ng-if="profile.isMyProfile()">
	<li class="profile-notification list-group-item" ng-repeat="notification in profile.notifications" ng-class="{'list-group-item-success':!profile.isSeen(notification)}" ng-mouseover="profile.seeNotification(notification)">
		<span class="bold" ng-bind="profile.getTitleOfNotification(notification)"></span><br />
		<span ng-bind="notification.text"></span>
	</li>
</ul>
<p class="text-center fa-lg" ng-if="!profile.isMyProfile()">
	<span>Non puoi vedere le notifiche di un altro utente!</span>
</p>