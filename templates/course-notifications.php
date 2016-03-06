<table class="table table-striped">
    <tr ng-repeat="notification in course.notifications">
        <td>
            <div class="container" id="notification{{notification.notificationID}}" size-on-scope>
                <div class="course-notification-date" ng-style="{'height': notification{{notification.notificationID}}Height + 'px'}">
                    <p><span class="middler"></span><span class="middle" ng-bind="notification.publishingTimestamp"></span></p>
                </div>
                <div class="course-notification-text">
                    <p><span ng-bind-html="notification.text"></span></p>
                </div>
            </div>
        </td>
    </tr>
</table>