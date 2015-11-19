angular.module('Main').run(['$templateCache', function($templateCache) {
  'use strict';

  $templateCache.put('templates/bootstrapInput.php',
    "<div class=\"form-group has-feedback\" ng-class=\"{'has-success': form['{{name}}'].$valid && form['{{name}}'].$dirty && !form['{{name}}'].$error.required, 'has-error': form['{{name}}'].$dirty && form['{{name}}'].$invalid && !form['{{name}}'].$error.required, 'has-warning' : form['{{name}}'].$dirty && form['{{name}}'].$invalid && form['{{name}}'].$error.required}\"><label for=\"{{id}}\" class=\"control-label\" ng-bind=\"label ? label : '{{name}}'\" ng-class=\"{'sr-only' : !label}\"></label><input type=\"{{type}}\" name=\"{{name}}\" id=\"{{id}}\" placeholder=\"{{placeholder}}\" ng-model=\"ngModel\" ng-model-options=\"{allowInvalid : true}\" ng-minlength=\"{{ngMinlength}}\" ng-maxlength=\"{{ngMaxlength}}\" ng-required=\"required ? true : false\" ng-readonly=\"readonly ? true : false\" uib-popover-template=\"popover.templateUrl\" popover-placement=\"bottom\" popover-trigger=\"none\" popover-is-open=\"thereAreErrors\" ng-focus=\"triggerIfDirtyAndInvalid()\" ng-change=\"triggerIfDirtyAndInvalid()\" ng-blur=\"closeValidationPopover()\"> <span class=\"fa form-control-feedback\" ng-class=\"{'fa-check': form['{{name}}'].$valid && form['{{name}}'].$dirty && !form['{{name}}'].$error.required, 'fa-times': form['{{name}}'].$dirty && form['{{name}}'].$invalid && !form['{{name}}'].$error.required, 'fa-exclamation-triangle' : form['{{name}}'].$dirty && form['{{name}}'].$invalid &&  form['{{name}}'].$error.required}\"></span></div>"
  );


  $templateCache.put('templates/bootstrapTextarea.php',
    "<div class=\"form-group\" ng-class=\"{'has-success': form['{{name}}'].$valid && form['{{name}}'].$dirty && !form['{{name}}'].$error.required, 'has-error': form['{{name}}'].$dirty && form['{{name}}'].$invalid && !form['{{name}}'].$error.required, 'has-warning' : form['{{name}}'].$dirty && form['{{name}}'].$invalid && form['{{name}}'].$error.required}\"><label for=\"{{id}}\" class=\"control-label\" ng-bind=\"label ? label : '{{name}}'\" ng-class=\"{'sr-only' : !label}\"></label><textarea msd-elastic rows=\"{{rows}}\" name=\"{{name}}\" id=\"{{id}}\" placeholder=\"{{placeholder}}\" ng-minlength=\"{{ngMinlength}}\" ng-maxlength=\"{{ngMaxlength}}\" ng-model=\"ngModel\" ng-model-options=\"{allowInvalid : true}\" ng-required=\"required ? true : false\" ng-readonly=\"readonly ? true : false\" uib-popover-template=\"popover.templateUrl\" popover-placement=\"bottom\" popover-trigger=\"none\" popover-is-open=\"thereAreErrors\" ng-focus=\"triggerIfDirtyAndInvalid()\" ng-change=\"triggerIfDirtyAndInvalid()\" ng-blur=\"closeValidationPopover()\">\n" +
    "</div>"
  );


  $templateCache.put('templates/calendar.php',
    "<div style=\"margin-bottom: 1vw\"><button class=\"btn btn-success\" ng-click=\"changeView('agendaDay')\">Vista Quotidiana</button> <button class=\"btn btn-success\" ng-click=\"changeView('agendaWeek')\">Vista Settimanale</button> <button class=\"btn btn-success\" ng-click=\"changeView('month')\">Vista Mensile</button></div><div ui-calendar=\"uiConfig.calendar\" ng-model=\"eventSources\" calendar=\"register\" id=\"register\"></div>"
  );


  $templateCache.put('templates/course-material.php',
    "<table class=\"table table-striped\"><tr ng-repeat=\"material in course.materials\"><td><div class=\"container\" id=\"material{{material.materialID}}\"><div class=\"material-title\"><div class=\"container\"><span class=\"middler\"></span> <a ng-href=\"{{material.fileURI}}\" fittext fittext-multiple=\"materialTitles\" fittext-exclusive=\"width\"><span class=\"middler\"></span><span class=\"middle fa fa-3x\" ng-class=\"material.getFA()\"></span><span class=\"middle\" ng-bind=\"material.getTitle()\"></span></a></div></div><div class=\"material-content\"><div class=\"container\"><span fittext-long fittext-long-multiple=\"materialDescriptions\" ng-bind=\"material.note\"></span></div></div></div></td></tr></table>"
  );


  $templateCache.put('templates/courseMaterialAdd.php',
    "<form name=\"addCourseMaterialForm\" id=\"addCourseMaterialForm\" ng-submit=\"admin.addCourseMaterial()\" ng-init=\"admin.getCoursesAndLessons()\" novalidate><select class=\"form-control\" name=\"addCourseMaterialForm\" ng-if=\"admin.lessons\" ng-model=\"admin.addCourseMaterialForm.courseID\"><option></option><option ng-repeat=\"course in admin.courses\" value=\"{{course}}\" ng-bind=\"course\"></option></select><select class=\"form-control\" ng-if=\"admin.addCourseMaterialForm.courseID\" ng-model=\"admin.addCourseMaterialForm.lessonID\"><option></option><option ng-repeat=\"lesson in admin.lessons[admin.addCourseMaterialForm.courseID]\" value=\"{{lesson.lessonID}}\" ng-bind=\"lesson.lessonNote\"></option></select><input form=\"addCourseMaterialForm\" id=\"file\" name=\"file\" type=\"file\" required><bootstrap-textarea form=\"addCourseMaterialForm\" id=\"note\" name=\"note\" type=\"text\" ng-model=\"admin.addCourseMaterialForm.note\" placeholder=\"Descrizione del materiale\" ng-maxlength=\"500\" required></bootstrap-textarea><input class=\"btn btn-success form-group\" type=\"submit\" value=\"Aggiungi materiale\"></form>"
  );


  $templateCache.put('templates/courseMaterialDelete.php',
    "<form name=\"deleteCourseMaterialForm\" id=\"deleteCourseMaterialForm\" ng-submit=\"admin.deleteCourseMaterial()\" ng-init=\"admin.getCoursesAndLessons()\" novalidate><select class=\"form-control\" name=\"deleteCourseMaterialForm\" ng-if=\"admin.lessons\" ng-options=\"course as course for course in admin.courses\" ng-model=\"admin.deleteCourseMaterialForm.courseID\" ng-change=\"admin.getMaterials(admin.deleteCourseMaterialForm.courseID)\"><option></option></select><select class=\"form-control\" name=\"deleteCourseMaterialForm\" ng-if=\"admin.courseMaterials\" ng-options=\"material as material.title for material in admin.courseMaterials\" ng-model=\"admin.deleteCourseMaterial.selected\" ng-change=\"admin.deleteCourseMaterialForm.materialID = admin.deleteCourseMaterial.selected.materialID\"><option></option></select><input class=\"btn btn-error form-group\" type=\"submit\" value=\"Elimina materiale\"></form>"
  );


  $templateCache.put('templates/courseMaterialModify.php',
    "<form name=\"modifyCourseMaterialForm\" id=\"modifyCourseMaterialForm\" ng-submit=\"admin.modifyCourseMaterial()\" ng-init=\"admin.getCoursesAndLessons()\" novalidate><select class=\"form-control\" name=\"modifyCourseMaterialForm\" ng-if=\"admin.lessons\" ng-options=\"course as course for course in admin.courses\" ng-model=\"admin.modifyCourseMaterialForm.courseID\" ng-change=\"admin.getMaterials(admin.modifyCourseMaterialForm.courseID)\"><option></option></select><select class=\"form-control\" name=\"modifyCourseMaterialForm\" ng-if=\"admin.courseMaterials\" ng-options=\"material as material.title for material in admin.courseMaterials\" ng-model=\"admin.modifyCourseMaterial.selected\" ng-change=\"admin.modifyCourseMaterialForm.materialID = admin.modifyCourseMaterial.selected.materialID\"><option></option></select><div ng-if=\"admin.modifyCourseMaterialForm.materialID\"><h3>Cosa vuoi modificare?</h3><div ng-class=\"admin.spacedButtons(0)\"><label><input type=\"radio\" name=\"modifyCourseMaterialOptions\" id=\"file\" value=\"file\" ng-model=\"admin.modifyCourseMaterial.choice\" required> File</label></div><div ng-class=\"admin.spacedButtons(1)\"><label><input type=\"radio\" name=\"modifyCourseMaterialOptions\" id=\"description\" value=\"description\" ng-model=\"admin.modifyCourseMaterial.choice\" required> Descrizione</label></div><div ng-class=\"admin.spacedButtons(2)\"><label><input type=\"radio\" name=\"modifyCourseMaterialOptions\" id=\"lesson\" value=\"lesson\" ng-model=\"admin.modifyCourseMaterial.choice\" required> Lezione associata</label></div></div><input ng-show=\"admin.modifyCourseMaterial.choice === 'file'\" form=\"modifyCourseMaterialForm\" id=\"file\" name=\"file\" type=\"file\" required><div ng-show=\"admin.modifyCourseMaterial.choice === 'description'\"><h3>Vecchia descrizione:</h3><p ng-bind=\"admin.modifyCourseMaterial.selected.note\"></p><h3>Nuova descrizione:</h3><bootstrap-textarea form=\"modifyCourseMaterialForm\" id=\"note\" name=\"note\" type=\"text\" ng-model=\"admin.modifyCourseMaterialForm.note\" required></bootstrap-textarea></div><div ng-show=\"admin.modifyCourseMaterial.choice === 'lesson'\"><h3>Vecchia lezione associata:</h3><p ng-bind=\"admin.findLessonTitle(admin.modifyCourseMaterialForm.courseID,admin.modifyCourseMaterial.selected.lessonID)\"></p><h3>Nuova lezione associata:</h3><select ng-options=\"lesson.lessonID as lesson.lessonNote for lesson in admin.lessons[admin.modifyCourseMaterialForm.courseID]\" ng-model=\"admin.modifyCourseMaterialForm.lessonID\" required></select></div><input class=\"btn btn-warning form-group\" type=\"submit\" value=\"Modifica materiale\"></form>"
  );


  $templateCache.put('templates/error-messages.php',
    "<span class=\"darkest-grey\" ng-message=\"required\">Compila questo campo!</span> <span class=\"darkest-grey\" ng-message=\"minlength\">Questo campo deve contenere almeno {{ngMinlength}} caratteri!</span> <span class=\"darkest-grey\" ng-message=\"maxlength\">Questo campo deve contenere meno di {{ngMaxlength}} caratteri!</span> <span class=\"darkest-grey\" ng-message=\"email\">L'e-mail non è valida!</span><!-- ERRORI PERSONALI --> <span class=\"darkest-grey\" ng-message=\"usernameTaken\">Nome utente non disponibile!</span> <span class=\"darkest-grey\" ng-message=\"loginError\">Il nome utente o la password non combaciano!</span> <span class=\"darkest-grey\" ng-message=\"passwordMismatch\">Le due password non coincidono!</span>"
  );


  $templateCache.put('templates/error-popover.php',
    "<div id=\"error-popover\" ng-show=\"form['{{name}}'].$invalid && form['{{name}}'].$dirty\"><span class=\"fa-stack\"><i class=\"fa fa-stack-2x fa-square\" style=\"color: #f0ad4e\"></i> <i class=\"fa fa-stack-1x white fa-exclamation\"></i></span> <span ng-messages=\"errors\"><span ng-messages-include=\"templates/error-messages.php\"></span></span></div>"
  );


  $templateCache.put('templates/infoWindow.php',
    "<div class=\"container\" ng-controller=\"infoWindowController as info\"><h6 ng-bind=\"info.name\"></h6><h6><span class=\"fa fa-map-marker\"></span> <span ng-bind=\"info.address\"></span></h6><p><span class=\"fa fa-phone\"></span> <span ng-bind=\"info.phone\"></span></p></div>"
  );


  $templateCache.put('templates/paymentDisclaimer.php',
    "<div class=\"container\"><div id=\"payment-disclaimer-modal\"><div class=\"container\"><h2>Disclaimer</h2><p>Cliccando su “Accetta” ti impegni ad effettuare quanto riportato nelle istruzioni finali secondo le modalità mostrate, corrispondendo l'intero importo indifferentemente dal metodo di pagamento.</p><form id=\"paymentDisclaimerForm\" name=\"paymentDisclaimerForm\" ng-submit=\"paymentDisclaimer.submit()\" novalidate><input id=\"payment-disclaimer-submit\" type=\"submit\" value=\"Accetta\"> <input id=\"payment-disclaimer-cancel\" ng-click=\"$dismiss()\" value=\"Annulla\" readonly></form></div></div></div>"
  );


  $templateCache.put('templates/signin.php',
    "<div class=\"container\"><div id=\"signinModal\"><div class=\"container\"><h2>Login</h2><form id=\"signinForm\" name=\"signinForm\" ng-submit=\"signin.submit()\" novalidate><bootstrap-input form=\"signinForm\" id=\"username\" name=\"username\" type=\"text\" ng-model=\"signin.signinForm.username\" placeholder=\"Username\" ng-minlength=\"3\" ng-maxlength=\"30\" required></bootstrap-input><bootstrap-input form=\"signinForm\" name=\"password\" type=\"password\" ng-model=\"signin.signinForm.password\" placeholder=\"Password\" ng-minlength=\"8\" required></bootstrap-input><input id=\"signin-submit\" type=\"submit\" ng-class=\"{'btn-success' : signinForm.$valid, 'btn-grey' : signinForm.$invalid}\" value=\"Accedi\"> <input id=\"signin-cancel\" ng-click=\"$dismiss()\" value=\"Annulla\" readonly></form></div></div></div>"
  );


  $templateCache.put('templates/signup.php',
    "<div class=\"container\"><div id=\"signupModal\"><div class=\"container\"><h2>Modulo di registrazione</h2><form id=\"signupForm\" name=\"signupForm\" ng-submit=\"signup.submit()\" novalidate><bootstrap-input form=\"signupForm\" id=\"username\" name=\"username\" type=\"text\" ng-model=\"signup.signupForm.username\" placeholder=\"Username\" ng-minlength=\"3\" ng-maxlength=\"30\" required></bootstrap-input><bootstrap-input form=\"signupForm\" name=\"name\" type=\"text\" ng-model=\"signup.signupForm.name\" placeholder=\"Nome\" ng-minlength=\"2\" ng-maxlength=\"30\" required></bootstrap-input><bootstrap-input form=\"signupForm\" name=\"surname\" type=\"text\" ng-model=\"signup.signupForm.surname\" placeholder=\"Cognome\" ng-minlength=\"2\" ng-maxlength=\"30\" required></bootstrap-input><bootstrap-input form=\"signupForm\" name=\"mail\" type=\"email\" ng-model=\"signup.signupForm.mail\" placeholder=\"Indirizzo e-mail\" required></bootstrap-input><bootstrap-input form=\"signupForm\" name=\"password\" type=\"password\" ng-model=\"signup.signupForm.password\" placeholder=\"Digita la password che vuoi utilizzare\" ng-minlength=\"8\" required></bootstrap-input><bootstrap-input form=\"signupForm\" id=\"repassword\" name=\"repassword\" type=\"password\" ng-model=\"signup.signupForm.repassword\" placeholder=\"Ridigita la password\" required></bootstrap-input><input id=\"signup-submit\" type=\"submit\" ng-class=\"{'btn-success' : signupForm.$valid, 'btn-grey' : signupForm.$invalid}\" value=\"Iscriviti\"> <input id=\"signup-cancel\" ng-click=\"$dismiss()\" value=\"Annulla\" readonly></form></div></div></div>"
  );

}]);
