var main = angular.module('Main',[
    'ngRoute', // For routing purposes
    'ngMessages', // For validation purposes
    'ngSanitize', // For validation and sanitizing purposes
    'ngCookies', // For setting/retrieving cookies easily
    'ngAnimate', // For animating purposes
    'ui.calendar', // For register calendar
    'ui.bootstrap', // For all bootstrap functions and for ui.calendar
//    'angularShamSpinner', // For pre-loading spinner
    'monospaced.elastic', // For text-area auto-resizing
    'uiGmapgoogle-maps', // For Google Maps integration
    'perfect_scrollbar', // For scrollbar in single div
    'youtube-embed', // For embedding Youtube Videos
    'ngFitText', // My creation for perfectly centering text into div
    'gridster', // For draggable/resizable divs
    'lr.upload', // For uploading purposes
    'inform', // For notifier purposes
    ], function($httpProvider) {

    // FOR CI
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.transformRequest = [function(data) {
        return angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;
    }];
  
});
    
/* Configures Moment plugin to display dates in Italian */
moment.locale('it', {});

/* Configures msd-elastic plugin for textareas */
main.config(['msdElasticConfig', function(config) {
  config.append = '\n';
}]).
/* Configures Google Maps SDK */
config(function(uiGmapGoogleMapApiProvider) {
    uiGmapGoogleMapApiProvider.configure({
        //    key: 'your api key',
        v: '3.20', //defaults to latest 3.X anyhow
        libraries: 'weather,geometry,visualization'
    });
}).
/* Configures Angular Inform */
config(function(informProvider) {

    var myDefaults = {
      /* default time to live for each notification */
      ttl: 4000,
      /* default type of notification */
      type: 'success'
    };

    informProvider.defaults(myDefaults);
});;

/* Check if you are on "responsive" devices */
imOnResponsive = (window.innerWidth > 0) ? (window.innerWidth < 1080) : (screen.width < 1080);
function imOnResponsive(){
    return imOnResponsive;
}
/* Check if you are on "mini" devices */
imOnMini = (window.innerWidth > 0) ? (window.innerWidth < 540) : (screen.width < 540);
function imOnMini(){
    return imOnMini;
}
/* Check if you are on "maxi" devices */
imOnMaxi = (window.innerWidth > 0) ? (window.innerWidth >= 4096) : (screen.width >= 4096);
function imOnMaxi(){
    return imOnMaxi;
}

/*** RUN PHASE ***/
main.run(['$rootScope','$location','$timeout','$http','$cookies','$window','$route','gridsterConfig','inform','$cookies',function($rootScope, $location, $timeout, $http, $cookies, $window, $route, gridsterConfig,inform,$cookies) {
	
	$rootScope.thereIsAvatar = function()
    {
    	return $rootScope.avatarURI ? true : false;
    }
	
	$rootScope.getAvatar = function()
    {
    	if($rootScope.avatarURI) return $rootScope.avatarURI;
    	return "imgs/leaf.png";
    }
	
	$rootScope.setAvatar = function()
	{
		$http.post('avatars/get_avatar', {username: $rootScope.username}).then(
    			function(response)
    			{
    				if(response.data.error)
    				{
    					inform.add(response.data.description,{type:'danger'});
    				}
    				if(response.data)
    				{
    					$rootScope.avatarURI = response.data.avatar;
    				}						
    			},
    			function(error)
    			{
    				console.log(error);
    			}
    	);
	}
	
	$rootScope.getUnseenNotifications = function()
	{
		$http.post('notifications/get_unseen_user_notifications',{username: $rootScope.username}).then(
        		function(response)
        		{
        			if(response.data)
        			{
            			$rootScope.notifications = response.data;
            			$rootScope.numberOfNotifications = $rootScope.notifications.length;
        			}
        		},
        		function(error)
        		{
        			console.log(error);
        		}
        );
	};
    
    $rootScope.miniHeader = function(){
        if($location.path() !== '/') return true;
        else return false;
    };    

    $rootScope.logout = function(){
        $cookies.remove('username',{path:'/'});
        $cookies.remove('token',{path:'/'});
        $cookies.remove('verified',{path:'/'});
        $location.path('/');
        $window.location.reload();
    };

    if($cookies.get('verified') === '1'){
    	
        $rootScope.userVerified = true;
        $rootScope.username = $cookies.get('username');
        
        $rootScope.getUnseenNotifications();
        
        $rootScope.setAvatar();
        
        $http.post('admins/is_admin',{username: $rootScope.username}).then(
        		function(response)
        		{
//        			console.log(response);
        			if(response.data === 'false') $rootScope.admin = false;
        			else $rootScope.admin = true;
        		},
        		function(error)
        		{
        			console.log(error);
        		}
        )        

    	setInterval(function(){$rootScope.getUnseenNotifications()},10000);
    }
    else $rootScope.userVerified = false;    
    
    /* ANGULAR GRIDSTER */
    
    gridsterConfig.swapping = true;
    gridsterConfig.mobileBreakPoint = 600;
    // gridsterConfig.rowHeight = '*3.236';
    gridsterConfig.columns = 12;
    
    // For scrolling at top when view changes
    
    $rootScope.$on('$routeChangeStart', function(event,next)
		{
    		if(next){
    			if(next.$$route){
    				$(window).scrollTop(0);
    			}
    		}
		}
    );    
    
}]);


/*** ROUTES ***/

main.config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider){
    
    $locationProvider.hashPrefix('!');
    
    // Home
    
    $routeProvider.when('/',{
        templateUrl : 'home'
    });
    
    // Admin Page - Restricted
    
    $routeProvider.when('/admin',{
        templateUrl : 'admin'
    });
    
    // Payment
    
    $routeProvider.when('/payment',{
        templateUrl : 'payment'
    });
    
    // Payment-not-registered
    
    $routeProvider.when('/paymentNotRegistered',{
        templateUrl : 'paymentNotRegistered'
    });
    
    // Cancel_payment
    
    $routeProvider.when('/cancel_payment',{
        templateUrl : 'cancel_payment'
    });
    
    // Confirm_payment
    
    $routeProvider.when('/confirm_payment',{
        templateUrl : 'confirm_payment'
    });
    
    // Courses
    
    $routeProvider.when('/courses',{
        templateUrl : 'courses'
    });
    
    // Activities
    
    $routeProvider.when('/activities',{
        templateUrl : 'activities'
    });
//    
//    // Media
//    
//    $routeProvider.when('/media',{
//        templateUrl : 'media'
//    });
    
    // Contacts
    
    $routeProvider.when('/contacts',{
        templateUrl : 'contacts'
    });
    
    // Disclaimer
    
    $routeProvider.when('/disclaimer',{
        templateUrl : 'disclaimer'
    });
    
    // FAQ
    
    $routeProvider.when('/faq',{
        templateUrl : 'faq'
    });
    
    // Privacy
    
    $routeProvider.when('/privacy',{
        templateUrl : 'privacy'
    });
    
    // Course
    
    $routeProvider.when('/courses/:courseID',{
        templateUrl : function(parameters){return 'course/index/'+parameters.courseID;},
        controller : 'courseController as course',
    });
    

    // Activity
    
    $routeProvider.when('/activities/:activityID',{
        templateUrl : function(parameters){return 'activity/index/'+parameters.activityID;},
        controller : 'activityController as activity'
    });
    
    // Profile
    
    $routeProvider.when('/profile/:userID',{
//        templateUrl : 'profile',
    	templateUrl: function(parameters){return 'profile/index/'+parameters.userID;},
        controller : 'profileController as profile'
    });
    
    // Register - Restricted
    
    $routeProvider.when('/register',{
        templateUrl : 'register',
        controller : 'Register as register'
    });
    
    
    // Error 500
    
    $routeProvider.when('/500',{
        templateUrl : '500',
    });
    
    $routeProvider.otherwise({redirectTo:'/500'});
    
}]);

/*** SERVICES ***/

main.service('utilities',[utilities]);

main.filter('firstCapitalized',function(){
    return function(input){
        input = input || '';
        var output = input.charAt(0).toUpperCase() + input.substring(1,input.length);
        // console.log(output);
        
        return output;
    };
});

/*** DIRECTIVES ***/

/* for retrieving sizes - as attribute */

main.directive('sizeOnController', ['$timeout','$window','$document',function($timeout,$window,$document){
    return {
        restrict: 'A',
        link: function($scope, $element, $attrs) {
            var controller = $element.controller();
            
            $timeout(function(){
                controller[$attrs.$normalize($attrs.id) +'Width'] = $element.prop('offsetWidth');
                controller[$attrs.$normalize($attrs.id) +'Height'] = $element.prop('offsetHeight');
            });
            
            angular.element($window).bind('resize', function() {
                controller[$attrs.$normalize($attrs.id) +'Width'] = $element.prop('offsetWidth');
                controller[$attrs.$normalize($attrs.id) +'Height'] = $element.prop('offsetHeight');
            });
        }
    };
}]);

main.directive('sizeOnScope', ['$timeout','$window','$document',function($timeout,$window,$document){
    return {
        restrict: 'A',
        link: function($scope, $element, $attrs) {
            
            var writer = function(){
            
                $timeout(function(){
                    $scope[$attrs.$normalize($attrs.id) +'Width'] = $element.prop('offsetWidth');
                    $scope[$attrs.$normalize($attrs.id) +'Height'] = $element.prop('offsetHeight');
                    $scope['sizesReady'] = true;
                });
                
            };
            
            writer();
            
            $scope.$watch(
                function(scope){
                    return $element.prop('offsetHeight');
                }, 
                function(newValue,oldValue,scope){
                    writer();
                }
            );
            
            $scope.$watch(
                function(scope){
                    return $element.prop('offsetWidth');
                }, 
                function(newValue,oldValue,scope){
                    writer();
                }
            );
            
            angular.element($window).bind('resize', function() {
                writer();
            });
        }
    };
}]);

/* for flipping purposes - as element */

main.directive('flipper',function() {
	return {
		restrict: "E",
		template: "<div class='flipper' ng-transclude ng-class='{flipped : flipped}'></div>",
		transclude: true,
		scope: {
			flipped: "="
		}
	};
});

main.directive("front", function() {
	return {
		restrict: "E",
		template: "<div class='front' ng-transclude></div>",
		transclude: true
	};
});

main.directive("back", function() {
	return {
		restrict: "E",
		template: "<div class='back' ng-transclude></div>",
		transclude: true
	};
});

/* For appropriately styling inputs - as elements */
/* bootstrap-input and bootstrap-textarea tag MUST contain 'form' and 'name' attributes. Bootstrap-input obviously needs 'type' too for proper behavior. Other parameters are optional. */
/* NOTE: for 'required' tag to work, it must be written in XHTML syntax as required="required" */

main.directive('bootstrapInput',['$timeout','$filter',function($timeout,$filter){
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
            
            /* Setting validator for username in case I'm in signupController */
            $scope.form[$scope.name].$validators.usernameTaken = function(modelValue, viewValue){
                if($scope.errorMessageFromServer === 'USERNAME_TAKEN') return false;
                else return true;
            };
            
            /* Setting validator for username/password mismatch in case I'm in signinController */
            $scope.form[$scope.name].$validators.loginError = function(modelValue, viewValue){
                if($scope.errorMessageFromServer === 'LOGIN_ERROR') return false;
                else return true;
            };
            
            /* Setting validator for invalid username in case I'm in signinController */
            $scope.form[$scope.name].$validators.invalidUsername = function(modelValue, viewValue){
                if($scope.errorMessageFromServer === 'INVALID_FIELD') return false;
                else return true;
            };
            
            /* Setting validator for password/repassword mismatch in case I'm in signupController */
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

main.directive('centered',function() {
	return {
		restrict: 'A',
		scope: true,
		link: function(scope, element, attrs) {
			
			var height, parentHeight, parentPadding;
			
			var measure = function()
			{
				height = element[0].offsetHeight;
				parentHeight = element.parent().outerHeight();
				parentPadding = parseInt(element.parent().css('padding-top'),10);
			}			
			
			var center = function()
			{
				element[0].style.top =((parentHeight-height)/2 - parentPadding) + 'px';
			}

			element[0].style.position = 'relative';
			measure();
			center();
			
			scope.$watch(
					function()
					{
						return element.parent().height();
					},
					function()
					{
						measure();
						center();				
					}
			);
			
			scope.$watch(
					function()
					{
						return element.parent().width();
					},
					function()
					{
						measure();
						center();				
					}
			);
			
			scope.$watch(
					function()
					{
						return element[0].offsetHeight;
					},
					function()
					{
						measure();
						center();				
					}
			);
			
			scope.$watch(
					function()
					{
						return element[0].offsetWidth;
					},
					function(newValues)
					{
						measure();
						center();				
					}
			);
			
			
		}
	}
});