<div id="register" ng-init="register.init()">
    <div class="container">
        <div class="col-10 offset-8">
            <div class="container text-left">
                <h2> Corsi </h2>
                <div class="checkbox checkbox-success noselect" ng-repeat="course in register.coursesList">
                    <input type="checkbox" id="{{course}}" class="styled" ng-model="register.checkedCourses[course]" ng-change="register.updateEvents()" ng-disabled="register.changes.studentsChanges.length || register.changes.lessonNote !== undefined" checked>
                    <label for="{{course}}" ng-bind="course"></label>
                </div>
            </div>
        </div>
        
        <div class="col-35 offset-2" style="margin-top:1vw" ng-include="'templates/calendar.php'">
        </div>
        
        <div class="col-35 offset-2" style="margin-top:1vw">
            <div class="panel panel-default" style="font-size:1vw">
                
                <div class="panel-heading">
                    <div ng-show="register.selectedLessonID">
                        <h5 ng-bind="register.db[register.selectedLessonID].startingDate.format('dddd D MMMM')"></h5>
                        <p ng-bind="register.db[register.selectedLessonID].courseID"></p>
                        <p><span ng-bind="register.db[register.selectedLessonID].startingDate.format('HH:mm')"></span> - <span ng-bind="register.db[register.selectedLessonID].endingDate.format('HH:mm')"></span></p>
                    </div>
                    <div ng-show="!register.selectedLessonID && register.selected">
                        <h5 ng-bind="register.selected.format('dddd D MMMM YYYY')"></h5>
                    </div>
                </div>
                
                <div class="panel-body">
                    <div ng-show="!register.selectedLessonID && register.selected">
                        <div class="container">
                            <div id="timepickers">
                                <span>Ora d'inizio</span><uib-timepicker ng-model="register.selectedStartingHour" show-meridian="false"></uib-timepicker>
                                <uib-timepicker ng-model="register.selectedEndingHour" show-meridian="false"></uib-timepicker><span>Ora di fine</span>
                            </div>
                            <div>
                                <label for="courseID">Corso:
                                <select ng-model="register.courseIDInput" name="courseID" ng-options="course for course in register.coursesList" required>
                                    <option label="" value=""></option>
                                </select></label>
                                <div class="clearfix"></div>
                                <label for="note">Nota per la lezione: <input type="text" name="note" ng-model="register.noteInput"/></label>
                            </div>
                            <div id="addLesson">
                                <button class="btn" ng-show="!register.selectedLessonID" ng-click="register.addNewLesson()" ng-class="{'bg-light-green' : check}"><span class="fa fa-lg fa-plus"></span></button><span class="clickable" ng-mouseover="check = true;" ng-mouseleave="check = false;"> Aggiungi lezione</span>
                            </div>
                        </div>
                    </div>
                    
                    <div ng-show="register.selectedLessonID">
                        <div class="container">
                            <h5>Note:</h5>
                            <div id="lessonNote">
                                <span ng-bind="register.db[register.selectedLessonID].lessonNote" ng-show="!modifyingLesson"></span><input ng-model="register.db[register.selectedLessonID].lessonNote" ng-show="modifyingLesson"></input>
                                <span ng-show="register.selectedLessonID" class="fa clickable float-right" ng-class="modifyingLesson ? 'fa-check light-green' : 'fa-pencil'" ng-click="modifyingLesson = !modifyingLesson; oldLessonNote = register.db[register.selectedLessonID].lessonNote; register.modifyLessonNote(modifyingLesson)" style="line-height: 2vw"></span>
                                <span ng-show="modifyingLesson" class="fa fa-times clickable float-right red" ng-click="modifyingLesson = !modifyingLesson; register.restoreOldLessonNote(oldLessonNote)" style="line-height: 2vw"></span>
                                <span ng-show="modifyingLesson" class="fa fa-repeat clickable float-right purple-blue" ng-click="modifyingLesson = !modifyingLesson; register.restoreOriginalLessonNote()" style="line-height: 2vw"></span>
                            </div>
                            
                            <table class="table table-striped">
                                <tr><th class="text-center" ng-repeat="heading in register.headings" ng-bind="heading"></th></tr>
                                <tr class="noselect" ng-repeat="student in register.getStudentList()" ng-init="index = $index">
                                    <td ng-bind="student.name + ' ' + student.surname"></td>
                                    <td>
                                        <span class="fa fa-lg clickable" ng-class="student.attendance ? 'fa-check light-green' : 'fa-times red'" ng-click="register.toggleAttendance(index)"></span>
                                    </td>
                                    <td>
                                        <span ng-bind="student.note" ng-show="!modifying"></span><input ng-model="student.note" ng-show="modifying"></input>
                                        <span class="fa clickable float-right" ng-class="modifying ? 'fa-check light-green' : 'fa-pencil'" ng-click="modifying = !modifying; oldNote = student.note; register.modifyNote(index,modifying)" style="line-height: 1vw"></span>
                                        <span ng-show="modifying" class="fa fa-times clickable float-right red" ng-click="modifying = !modifying; register.restoreOldNote(index,oldNote)" style="line-height: 1vw"></span>
                                        <span ng-show="modifying" class="fa fa-repeat clickable float-right purple-blue" ng-click="modifying = !modifying; register.restoreOriginalNote(index)" style="line-height: 1vw"></span>
                                    </td>
                                </tr>
                            </table>
                            <button ng-click="register.submitChanges()" ng-class="register.changes.studentsChanges.length || register.changes.lessonNote !== undefined ? 'btn-success' : 'disabled'" class="btn col-30 offset-35" id="saveLesson">Salva</button>
                            <div class="clearfix"></div>
                            <button ng-click="register.removeLesson()" class="btn btn-danger col-30 offset-35" id="removeLesson">Rimuovi lezione</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/ng-template" id="removeLessonModal">
    <div class="modal-header">
        <h3 class="modal-title">Rimozione della lezione</h3>
    </div>
    <div class="modal-body">
        <p>Sei certo di voler cancellare la lezione in data <span ng-bind="data"></span>?</p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" type="button" ng-click="ok()">Sì</button>
        <button class="btn btn-primary" type="button" ng-click="cancel()">Assolutamente no!</button>
    </div>
</script>