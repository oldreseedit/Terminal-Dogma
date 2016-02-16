main.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
    	if(current.$$route)
    	{
            $rootScope.title = (current.$$route.title ? current.$$route.title + " - " : "") + "reSeed";
            
//            console.log($rootScope.title, current.$$route.title);
            
            $rootScope.ogimage = current.$$route.image ? current.$$route.image : "https://reseed.it/imgs/header.jpg";
            $rootScope.description = current.$$route.description.replace(/<[^>]+>/gm, '');
            $rootScope.ogUrl = 'https://www.reseed.it' + current.$$route.originalPath;
            // ogImg
    	}
    	else
    	{
    		$rootScope.title = 'Pagina Inesistente';
    		$rootScope.description = 'Eh, se non esiste non esiste.';
    	}
    });
}]);

main.config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider){
    
    $locationProvider.html5Mode(true);
    
    // Home
    
    $routeProvider.when('/',{
    	description: 'Impara. Crea. Pubblica.',
        templateUrl : 'templates/home.php'
    });
    
    // Admin Page - Restricted
    
    $routeProvider.when('/admin',{
    	title : 'Pannello Admin',
        templateUrl : 'templates/admin.php'
    });
    
    // Courses
    
    $routeProvider.when('/courses',{
    	title : 'Corsi',
    	description: 'I corsi di reSeed pongono l’accento sul lato pratico dell’insegnamento e sono improntati al “<i>learn by doing</i>”',
        templateUrl : 'templates/courses.php'
    });
    
    // Activities
    
    $routeProvider.when('/activities',{
    	title : 'Servizi',
        templateUrl : 'templates/activities.php'
    });
//    
//    // Media
//    
//    $routeProvider.when('/media',{
//        templateUrl : 'templates/media.php'
//    });
    
    // Contacts
    
    $routeProvider.when('/contacts',{
    	title : 'Contatti',
    	description: 'Hai bisogno di informazioni? Ti serve qualche chiarimento? Hai una voglia incontenibile di seguire un corso ma hai un dubbio? Per qualsiasi domanda non esitare a contattarci!',
        templateUrl : 'templates/contacts.php'
    });
    
    // Disclaimer
    
    $routeProvider.when('/disclaimer',{
    	title : 'Termini d\'Uso',
    	description: 'Di seguito vengono illustrati i Termini d\'uso di reSeed.',
        templateUrl : 'templates/disclaimer.php'
    });
    
    // FAQ
    
    $routeProvider.when('/faq',{
    	title : 'FAQ',
    	description: 'Hai qualche domanda? Consulta le nostre F.A.Q.!',
        templateUrl : 'templates/faq.php'
    });
    
    // Privacy
    
    $routeProvider.when('/privacy',{
    	title : 'Privacy Policy',
    	description: 'Noi di reSeed teniamo alla tua privacy.',
        templateUrl : 'templates/privacy.php'
    });
    
    // Course
    
    $routeProvider.when('/courses/:courseID',{
        templateUrl : 'templates/course.php',
        controller : 'courseController as course',
    });
    

    // Activity
    
    $routeProvider.when('/activities/:activityID',{
//    	title : function(parameters){return parameters.activityID},
        templateUrl : 'templates/activity.php',
        controller : 'activityController as activity'
    });
    
    // Profile
    
    $routeProvider.when('/profile/:userID',{
        templateUrl : 'templates/profile.php',
    	title : 'Profilo',
        controller : 'profileController as profile'
    });
    
    $routeProvider.when('/preferences',{
    	title: 'Pannello Utente',
    	templateUrl : 'templates/preferences.php',
    	controller: 'preferencesController as preferences'
    });
    
    $routeProvider.when('/cart',{
    	title: 'Carrello di reSeed',
    	templateUrl : 'templates/cart.php',
    	controller: 'cartController as cart'
    });
    
    // Register - Restricted
    
    $routeProvider.when('/register',{
    	title : 'Registro Elettronico',
        templateUrl : 'templates/register.php',
        controller : 'Register as register'
    });
    
    // Presentazione ai licei
    
    $routeProvider.when('/school',{
    	title : 'Presentazione',
        templateUrl : 'templates/school.php'
    });
    
    $routeProvider.otherwise({
    	templateUrl : 'templates/error.php',
    });
    
}]);