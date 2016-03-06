<p class="text-center" ng-if="!profile.isMyProfile()">
	<span>Non puoi vedere le notifiche di un altro utente!</span>
</p>
<p class="text-center" ng-if="profile.isMyProfile() && profile.notifications.length == 0">
	Non ci sono notifiche da mostrare.
</p>
<ul class="list-group" ng-if="profile.isMyProfile() && profile.notifications.length > 0">
	<li class="profile-notification list-group-item" ng-repeat="notification in profile.notifications" ng-class="{'list-group-item-success':!profile.isSeen(notification)}" ng-mouseover="profile.seeNotification(notification)">
		<p><span class="bold" ng-bind="profile.getTitleOfNotification(notification)"></span><br />
		<span ng-bind="notification.text"></span></p>
	</li>
</ul>