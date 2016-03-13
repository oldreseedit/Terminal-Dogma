main.run(['$rootScope','$location', function($rootScope,$location) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
    	if(current.$$route)
    	{
//    		console.log(current);
    		
//            $rootScope.title = (current.$$route.title ? current.$$route.title + " - " : "") + "reSeed";
    		$rootScope.title = ($location.url() == "/" || $location.url().indexOf("/home") == 0) ? current.$$route.title : current.$$route.title + " - reSeed";
            $rootScope.description = current.$$route.description ? current.$$route.description.replace(/<[^>]+>/gm, '') : "";
            $rootScope.ogTitle = ($location.url() == "/" || $location.url().indexOf("/home") == 0) ? current.$$route.title : current.$$route.title + " - reSeed";
            
            // Se stiamo su una pagina del tipo "courses/" modificare ogTitle in "Corso di "
            if($location.url().indexOf("/courses/") == 0) $rootScope.ogTitle = "Corso di " + $rootScope.ogTitle;

            $rootScope.ogDescription = $rootScope.description;
            $rootScope.ogImage = "http://www.reseed.it/" + (current.$$route.image ? current.$$route.image : "imgs/header.jpg");
            $rootScope.ogUrl = 'https://www.reseed.it' + $location.url();
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
    	title : 'reSeed',
    	description: 'Impara. Crea. Pubblica.',
        templateUrl : 'templates/home.php'
    });
    
    $routeProvider.when('/home',{
    	title : 'reSeed',
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
    	description : 'I servizi offerti da reSeed sono molteplici. Vieni a scoprirli.',
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
    
    $routeProvider.when('/pre-pay',{
    	title: 'Rivedi il tuo pagamento',
    	templateUrl : 'templates/pre-pay.php',
    	controller: 'cartController as cart'
    });
    
    $routeProvider.when('/paymentOK/:paymentID/:amount/:paymentCycle/:paymentMedia/:wireTransferCode?/:reason?/:holder?',{
    	title: 'Risultato del tuo pagamento',
    	templateUrl : 'templates/paymentOK.php',
    	controller: 'paymentOKController as payment'
    });
    
    $routeProvider.when('/paymentPending/:paymentID/:amount/:paymentCycle/:paymentMedia/:wireTransferCode?/:reason?/:holder?',{
    	title: 'Risultato del tuo pagamento',
    	templateUrl : 'templates/paymentPending.php',
    	controller: 'paymentPendingController as payment'
    });
    
    $routeProvider.when('/paymentFailed/:errorCode',{
    	title: 'Risultato del tuo pagamento',
    	templateUrl : 'templates/paymentFailed.php',
    	controller: 'paymentFailedController as paypal'
    });
    
    $routeProvider.when('/paymentCancelled',{
    	title: 'Risultato del tuo pagamento',
    	templateUrl : 'templates/paymentCancelled.php',
    });
    
    // Register - Restricted
    
    $routeProvider.when('/register',{
    	title : 'Registro Elettronico',
        templateUrl : 'templates/register.php',
        controller : 'Register as register'
    });
    
    // Register - Restricted
    
    $routeProvider.when('/test',{
    	title : 'Test',
        templateUrl : 'templates/test.php',
    });
    
    // Presentazione ai licei
    
    $routeProvider.when('/school',{
    	title : 'Presentazione',
        templateUrl : 'templates/school.php'
    });
    
    $routeProvider.when('/write-tutorial', {
    	title: 'Scrivi un nuovo tutorial',
    	templateUrl: 'templates/write-tutorial.php',
    	controller: 'writeTutorial as writeTutorial'
    });
    
    $routeProvider.when('/tutorials', {
    	title: 'Tutorial',
    	templateUrl: 'templates/tutorials.php',
    	controller: 'tutorialController as tutorialC'
    });
    
    $routeProvider.when('/tutorial/:tutorialID',{
        templateUrl : 'templates/tutorial.php',
        controller : 'viewTutorialController as tutorialV'
    });
    
    $routeProvider.otherwise({
    	templateUrl : 'templates/error.php',
    });
    
}]);