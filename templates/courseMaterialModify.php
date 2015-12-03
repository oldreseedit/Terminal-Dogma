<form name="modifyCourseMaterialForm" id="modifyCourseMaterialForm" ng-submit="admin.modifyCourseMaterial()" ng-init="admin.getCoursesAndLessons()" novalidate>
    <select class="form-control" name="modifyCourseMaterialForm" ng-if="admin.lessons" ng-options="course as course for course in admin.courses"  ng-model="admin.modifyCourseMaterialForm.courseID" ng-change="admin.getMaterials(admin.modifyCourseMaterialForm.courseID)">
        <option></option>
    </select>
    <select class="form-control" name="modifyCourseMaterialForm" ng-if="admin.modifyCourseMaterialForm.courseID" ng-options="material as material.title for material in admin.courseMaterials" ng-model="admin.modifyCourseMaterial.selected" ng-change="admin.modifyCourseMaterialForm.materialID = admin.modifyCourseMaterial.selected.materialID">
        <option></option>
    </select>
    <div ng-if="admin.modifyCourseMaterialForm.materialID">
     <div>
     	<h3>Nuovo file da inserire:</h3>
     	<input form="modifyCourseMaterialForm" id="file" name="file" type="file" required></input>
     </div>
    <div>
        <h3>Vecchia descrizione:</h3>
        <p ng-bind="admin.modifyCourseMaterial.selected.note"></p>
        <h3>Nuova descrizione:</h3>
        <bootstrap-textarea form="modifyCourseMaterialForm" id="note" name="note" type="text" ng-model="admin.modifyCourseMaterialForm.note" required="required"></bootstrap-textarea>
    </div>
    <div>
        <h3>Vecchia lezione associata: </h3>
        <p ng-bind="admin.findLessonTitle(admin.modifyCourseMaterialForm.courseID,admin.modifyCourseMaterial.selected.lessonID)"></p>
        <h3>Nuova lezione associata:</h3>
        <select ng-options="lesson.lessonID as lesson.lessonNote for lesson in admin.lessons[admin.modifyCourseMaterialForm.courseID]" ng-model="admin.modifyCourseMaterialForm.lessonID" required>
            
        </select>    
    </div>
    </div>
    
    <input class="btn btn-warning form-group" type="submit" value="Modifica materiale"/>
</form>