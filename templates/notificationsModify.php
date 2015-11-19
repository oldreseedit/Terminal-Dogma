<form name="modifyNotificationForm" id="modifyNotificationForm" ng-submit="admin.modifyNotification()" ng-init="admin.getCourses()" novalidate>
    <select class="form-control" name="modifyNotificationForm" ng-if="admin.courses" ng-options="course as course for course in admin.courses"  ng-model="admin.modifyNotificationForm.courseID" ng-change="admin.getNotifications(admin.modifyNotificationForm.courseID)">
        <option></option>
    </select>
    <select class="form-control" name="modifyNotificationForm" ng-if="admin.modifyNotificationForm.courseID" ng-options="notification as notification.text for notification in admin.notifications" ng-model="admin.modifyNotification.selected" ng-change="admin.modifyNotificationForm.notificationID = admin.modifyNotification.selected.notificationID">
        <option></option>
    </select>
    <div ng-if="admin.modifyNotificationForm.notificationID">
        <h3>Vecchia notifica:</h3>
        <p ng-bind="admin.modifyNotification.selected.text"></p>
        <h3>Nuova notifica:</h3>
        <bootstrap-textarea form="modifyNotificationForm" id="text" name="text" type="text" ng-model="admin.modifyNotificationForm.text" required="required"></bootstrap-textarea>
    </div>
    
    <input class="btn btn-warning form-group" type="submit" value="Modifica notifica"/>
</form>