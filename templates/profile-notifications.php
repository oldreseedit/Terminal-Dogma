<div class="profile-notifications">
    <div class="container">
        <h4>Notifiche</h4>
        <div ng-repeat="notification in self.notifications">
            <span ng-bind="notification.title" ng-class="{'green':notification.read}"></span>
            <span ng-bind="notification.content"></span>
        </div>
    </div>
</div>