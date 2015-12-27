main.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
}]);

main.config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider){
    
    $locationProvider.hashPrefix('!');
    
    // Home
    
    $routeProvider.when('/',{
        templateUrl : 'home'
    });
    
    // Admin Page - Restricted
    
    $routeProvider.when('/admin',{
    	title : 'Pannello Admin',
        templateUrl : 'admin'
    });
    
    // Payment
    
    $routeProvider.when('/payment',{
    	title : 'Pagamenti',
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
    	title : 'Corsi',
        templateUrl : 'courses'
    });
    
    // Activities
    
    $routeProvider.when('/activities',{
    	title : 'Servizi',
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
    	title : 'Contatti',
        templateUrl : 'contacts'
    });
    
    // Disclaimer
    
    $routeProvider.when('/disclaimer',{
    	title : 'Termini d\'Uso',
        templateUrl : 'disclaimer'
    });
    
    // FAQ
    
    $routeProvider.when('/faq',{
    	title : 'FAQ',
        templateUrl : 'faq'
    });
    
    // Privacy
    
    $routeProvider.when('/privacy',{
    	title : 'Privacy Policy',
        templateUrl : 'privacy'
    });
    
    // Course
    
    $routeProvider.when('/courses/:courseID',{
        templateUrl : function(parameters){return 'course/index/'+parameters.courseID;},
        controller : 'courseController as course',
    });
    

    // Activity
    
    $routeProvider.when('/activities/:activityID',{
//    	title : function(parameters){return parameters.activityID},
        templateUrl : function(parameters){return 'activity/index/'+parameters.activityID;},
        controller : 'activityController as activity'
    });
    
    // Profile
    
    $routeProvider.when('/profile/:userID',{
//        templateUrl : 'profile',
    	title : 'Profilo',
    	templateUrl: function(parameters){return 'profile/index/'+parameters.userID;},
        controller : 'profileController as profile'
    });
    
    // Register - Restricted
    
    $routeProvider.when('/register',{
    	title : 'Registro Elettronico',
        templateUrl : 'register',
        controller : 'Register as register'
    });
    
    $routeProvider.otherwise({
    	templateUrl: 'error'
    });
    
}]);