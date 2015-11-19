<form name="deleteNotificationForm" id="deleteNotificationForm" ng-submit="admin.deleteNotification()" ng-init="admin.getCourses()" novalidate>
    <select class="form-control" name="deleteNotificationForm" ng-if="admin.courses" ng-options="course as course for course in admin.courses"  ng-model="admin.deleteNotificationForm.courseID" ng-change="admin.getNotifications(admin.deleteNotificationForm.courseID)">
        <option></option>
    </select>
    <select class="form-control" name="deleteNotificationForm" ng-if="admin.notifications" ng-options="notification as notification.text for notification in admin.notifications" ng-model="admin.deleteNotification.selected" ng-change="admin.deleteNotificationForm.notificationID = admin.deleteNotification.selected.notificationID">
        <option></option>
    </select>
    <input class="btn btn-danger form-group" type="submit" value="Elimina notifica"/>
</form>