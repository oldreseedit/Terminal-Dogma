<form name="addCourseMaterialForm" id="addCourseMaterialForm" ng-submit="admin.addCourseMaterial()" ng-init="admin.getCoursesAndLessons()" novalidate>
    <select class="form-control" name="addCourseMaterialForm" ng-if="admin.lessons" ng-model="admin.addCourseMaterialForm.courseID">
        <option></option>
        <option ng-repeat="course in admin.courses" value="{{course}}" ng-bind="course"></option>
    </select>
    <select class="form-control" ng-if="admin.addCourseMaterialForm.courseID" ng-model="admin.addCourseMaterialForm.lessonID">
        <option></option>
        <option ng-repeat="lesson in admin.lessons[admin.addCourseMaterialForm.courseID]" value="{{lesson.lessonID}}" ng-bind="lesson.lessonNote"></option>
    </select>
    <input form="addCourseMaterialForm" id="file" name="file" type="file" required></input>
    <bootstrap-textarea form="addCourseMaterialForm" id="note" name="note" type="text" ng-model="admin.addCourseMaterialForm.note" placeholder="Descrizione del materiale" ng-maxlength="500" required="required"></bootstrap-textarea>
    <input class="btn btn-success form-group" type="submit" value="Aggiungi materiale"/>
</form>