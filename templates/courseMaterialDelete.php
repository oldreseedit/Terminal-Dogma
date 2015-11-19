<form name="deleteCourseMaterialForm" id="deleteCourseMaterialForm" ng-submit="admin.deleteCourseMaterial()" ng-init="admin.getCoursesAndLessons()" novalidate>
    <select class="form-control" name="deleteCourseMaterialForm" ng-if="admin.lessons" ng-options="course as course for course in admin.courses"  ng-model="admin.deleteCourseMaterialForm.courseID" ng-change="admin.getMaterials(admin.deleteCourseMaterialForm.courseID)">
        <option></option>
    </select>
    <select class="form-control" name="deleteCourseMaterialForm" ng-if="admin.courseMaterials" ng-options="material as material.title for material in admin.courseMaterials" ng-model="admin.deleteCourseMaterial.selected" ng-change="admin.deleteCourseMaterialForm.materialID = admin.deleteCourseMaterial.selected.materialID">
        <option></option>
    </select>
    <input class="btn btn-danger form-group" type="submit" value="Elimina materiale"/>
</form>