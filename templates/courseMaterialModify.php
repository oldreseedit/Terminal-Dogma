<form name="modifyCourseMaterialForm" id="modifyCourseMaterialForm" ng-submit="admin.modifyCourseMaterial()" ng-init="admin.getCoursesAndLessons()" novalidate>
    <select class="form-control" name="modifyCourseMaterialForm" ng-if="admin.lessons" ng-options="course as course for course in admin.courses"  ng-model="admin.modifyCourseMaterialForm.courseID" ng-change="admin.getMaterials(admin.modifyCourseMaterialForm.courseID)">
        <option></option>
    </select>
    <select class="form-control" name="modifyCourseMaterialForm" ng-if="admin.modifyCourseMaterialForm.courseID" ng-options="material as material.title for material in admin.courseMaterials" ng-model="admin.modifyCourseMaterial.selected" ng-change="admin.modifyCourseMaterialForm.materialID = admin.modifyCourseMaterial.selected.materialID">
        <option></option>
    </select>
    <div ng-if="admin.modifyCourseMaterialForm.materialID">
        <h3>Cosa vuoi modificare?</h3>
        <div ng-class="admin.spacedButtons(0)">
            <label>
                <input type="radio" name="modifyCourseMaterialOptions" id="file" value="file" ng-model="admin.modifyCourseMaterial.choice" required>
                File
            </label>
        </div>
        <div ng-class="admin.spacedButtons(1)">
            <label>
                <input type="radio" name="modifyCourseMaterialOptions" id="description" value="description" ng-model="admin.modifyCourseMaterial.choice" required>
                Descrizione
            </label>
        </div>
        <div ng-class="admin.spacedButtons(2)">
            <label>
                <input type="radio" name="modifyCourseMaterialOptions" id="lesson" value="lesson" ng-model="admin.modifyCourseMaterial.choice" required>
                Lezione associata
            </label>
        </div>
    </div>
    <input ng-show="admin.modifyCourseMaterial.choice === 'file'" form="modifyCourseMaterialForm" id="file" name="file" type="file" required></input>
    <div ng-show="admin.modifyCourseMaterial.choice === 'description'">
        <h3>Vecchia descrizione:</h3>
        <p ng-bind="admin.modifyCourseMaterial.selected.note"></p>
        <h3>Nuova descrizione:</h3>
        <bootstrap-textarea form="modifyCourseMaterialForm" id="note" name="note" type="text" ng-model="admin.modifyCourseMaterialForm.note" required="required"></bootstrap-textarea>
    </div>
    <div ng-show="admin.modifyCourseMaterial.choice === 'lesson'">
        <h3>Vecchia lezione associata: </h3>
        <p ng-bind="admin.findLessonTitle(admin.modifyCourseMaterialForm.courseID,admin.modifyCourseMaterial.selected.lessonID)"></p>
        <h3>Nuova lezione associata:</h3>
        <select ng-options="lesson.lessonID as lesson.lessonNote for lesson in admin.lessons[admin.modifyCourseMaterialForm.courseID]" ng-model="admin.modifyCourseMaterialForm.lessonID" required>
            
        </select>    
    </div>
    
    <input class="btn btn-warning form-group" type="submit" value="Modifica materiale"/>
</form>