<table class="table table-striped">
    <tr ng-repeat="notification in course.notifications">
        <td>
            <div class="container" id="notification{{notification.notificationID}}" size-on-scope>
                <div class="course-notification-date" ng-style="{'height': notification{{notification.notificationID}}Height + 'px'}">
                    <span class="middler"></span><span class="middle" ng-bind="notification.publishingTimestamp"></span>
                </div>
                <div class="course-notification-text">
                    <span ng-bind-html="notification.text"></span>
                </div>
            </div>
        </td>
    </tr>
</table>