/* For appropriately styling inputs - as elements */
/* bootstrap-input and bootstrap-textarea tag MUST contain 'form' and 'name' attributes. Bootstrap-input obviously needs 'type' too for proper behavior. Other parameters are optional. */
/* NOTE: for 'required' tag to work, it must be written in XHTML syntax as required="required" */

main.directive('bootstrapInput',['$timeout','$filter','$http','$q',function($timeout,$filter,$http,$q){
    return {
        restrict: "E",
        require: 'ngModel',
        scope: {
            'form' : '=',
            'formName' : '@form',
            'name' : '@',
            'type' : '@?',
            'ngModel' : '=?',
            'placeholder' : '@?',
            'label' : '@?',
            'ngMinlength' : '@?',
            'ngMaxlength' : '@?',
            'required' : '@?',
            'readonly' : '@?'
        },
        templateUrl: 'templates/bootstrapInput.php',
        link: function($scope,$element,$attrs,$ctrl){
            
            $scope.id = $attrs.$normalize($scope.formName + '-' + $scope.name);
            $scope.errors = $scope.form[$scope.name].$error;
            $scope.popover = {
                templateUrl: 'templates/error-popover.php'
            };
            
            $scope.thereAreErrors = false;
            $scope.errorMessageFromServer = '';

        	if($scope.name === 'username' && $scope.form.$name === 'signupForm')
        	{
	            $scope.form[$scope.name].$asyncValidators.usernameTakenAsync = function(modelValue,viewValue)
	            {
            		return $http.post('users/exists',{username: viewValue}).then(
                			function(response)
                			{
//                				console.log($scope.form[$scope.name]);
                				if(response.data === 'true') return $q.reject('username esistente');
                				else return true;
                			},
                			function(error)
                			{
                				console.log(error);
                			}
                	);
            	}
        	}
            
            /* Setting validator for username in case I'm in signupController */
            $scope.form[$scope.name].$validators.usernameTaken = function(modelValue, viewValue){
                if($scope.errorMessageFromServer === 'USERNAME_TAKEN') return false;
                return true;
            };
            
            /* Setting validator for username/password mismatch in case I'm in signinController */
            $scope.form[$scope.name].$validators.loginError = function(modelValue, viewValue){
                if($scope.errorMessageFromServer === 'LOGIN_ERROR') return false;
                else return true;
            };
            
            /* Setting validator for invalid username in case I'm in signup/signinController */
            $scope.form[$scope.name].$validators.invalidUsername = function(modelValue, viewValue){
                if($scope.name === 'username' && ($scope.form.$name === 'signupForm' || $scope.form.$name === 'signinForm') && viewValue)
                {
                	var check = viewValue.match(/[@$&£#"]/);
                	if(check) return false;
                }
                return true;
            };
            
            /* Setting validator for password/repassword mismatch in case name of  */
            $scope.form[$scope.name].$validators.passwordMismatch = function(modelValue, viewValue){
                if($scope.name === 'repassword' && modelValue !== angular.element('#signupFormPassword').scope().ngModel) return false;
                else return true;
            };
            
            $scope.triggerIfDirtyAndInvalid = function(){
                $timeout(function(){
                    if($scope.form[$scope.name].$dirty)
                    {
                        if($scope.form[$scope.name].$invalid){
                            $scope.thereAreErrors = true;
                        }
                        else{
                            $scope.thereAreErrors = false;
                        }
                    }
                });
            };
            
            $scope.closeValidationPopover= function(){
                $timeout(function(){
                    $scope.thereAreErrors = false;
                });
            };
            
        }
    };
}]);



main.directive('bootstrapTextarea',['$timeout','$filter',function($timeout,$filter){
    return {
        restrict: "E",
        scope: {
            'form' : '=',
            'formName' : '@form',
            'name' : '@',
            'ngModel' : '=?',
            'placeholder' : '@?',
            'label' : '@?',
            'rows' : '@?',
            'ngMinlength' : '@?',
            'ngMaxlength' : '@?',
            'required' : '@?',
            'readonly' : '@?'
        },
        templateUrl: 'templates/bootstrapTextarea.php',
        link: function($scope,$element,$attrs){
            
            $scope.id = $attrs.$normalize($scope.formName + '-' + $scope.name);
            $scope.errors = $scope.form[$scope.name].$error;
            $scope.popover = {
                templateUrl: 'templates/error-popover.php'
            };
            
            
            $scope.thereAreErrors = false;
            
            $scope.triggerIfDirtyAndInvalid = function(){
                $timeout(function(){
                    if($scope.form[$scope.name].$dirty)
                    {
                        if($scope.form[$scope.name].$invalid){
                            $scope.thereAreErrors = true;
                            // console.log('I triggered validationPopover');
                        }
                        else{
                            $scope.thereAreErrors = false;
                            // console.log('I triggered validationPopoverClose');
                        }
                    }
                });
            };
            
            $scope.closeValidationPopover= function(){
                $timeout(function(){
                    $scope.thereAreErrors = false;
                });
            };
        }
    };
}]);


main.directive('bootstrapCheckbox',['$timeout','$filter',function($timeout,$filter){
    return {
        restrict: "E",
        scope: {
            'form' : '=',
            'formName' : '@form',
            'name' : '@',
            'ngModel' : '=?',
            'placeholder' : '@?',
            'label' : '=',
            'rows' : '@?',
            'required' : '@?',
            'readonly' : '@?'
        },
        templateUrl: 'templates/bootstrapCheckbox.php',
        link: function($scope,$element,$attrs){
            
            $scope.id = $attrs.$normalize($scope.formName + '-' + $scope.name);
            $scope.errors = $scope.form[$scope.name].$error;
            $scope.popover = {
                templateUrl: 'templates/error-popover.php'
            };
            
            
            $scope.thereAreErrors = false;
            
            $scope.triggerIfDirtyAndInvalid = function(){
                $timeout(function(){
                    if($scope.form[$scope.name].$dirty)
                    {
                        if($scope.form[$scope.name].$invalid){
                            $scope.thereAreErrors = true;
                            // console.log('I triggered validationPopover');
                        }
                        else{
                            $scope.thereAreErrors = false;
                            // console.log('I triggered validationPopoverClose');
                        }
                    }
                });
            };
            
            $scope.closeValidationPopover= function(){
                $timeout(function(){
                    $scope.thereAreErrors = false;
                });
            };
        }
    };
}]);

main.directive('fileChange', function() {
	return {
		restrict: 'A',
		scope: {
			method : '&fileChange'
		},
		link: function (scope, element, attrs) {
			element.on('change', function(event){
				 scope.method({file:event.target.files});
			});
		}
	};
});