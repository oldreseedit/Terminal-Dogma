<form name="addNotificationForm" id="addNotificationForm" ng-submit="admin.addNotification()" ng-init="admin.getCourses()" novalidate>
    <select class="form-control" name="addNotificationForm" ng-if="admin.courses" ng-model="admin.addNotificationForm.courseID">
        <option></option>
        <option ng-repeat="course in admin.courses" value="{{course}}" ng-bind="course"></option>
    </select>
    <!--<bootstrap-input form="addNotificationForm" id="title" name="title" type="text" ng-model="admin.addNotificationForm.title" placeholder="Titolo della notifica" ng-maxlength="30" required="required"></bootstrap-input>-->
    <bootstrap-textarea ng-if="admin.addNotificationForm.courseID" form="addNotificationForm" id="text" name="text" type="text" ng-model="admin.addNotificationForm.text" placeholder="Testo della notifica" ng-maxlength="500" required="required"></bootstrap-textarea>
    <input class="btn btn-success form-group" type="submit" value="Aggiungi notifica"/>
</form>