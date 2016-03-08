main.controller('navbarController',['utilities','$timeout','$window','$uibModal','$rootScope','$cookies','$location','$scope','cartService', function(utilities,$timeout,$window,$uibModal,$rootScope,$cookies,$location,$scope,cartService){
    var self = this;

    $scope.cart = cartService;
    
    self.tabs = [
        {
            url : 'courses',
            content : 'Corsi',
            title : "Vedi tutti i nostri corsi"
        },
//         {
//             url : 'activities',
//             content : 'Servizi'
//         },
//        {
//            url : 'media',
//            content : 'Media'
//        },
        {
            url : 'contacts',
            content : 'Contatti',
            title : "Ottieni maggiori informazioni su reSeed"
        }
    ];
    
    self.goTo = function(url)
    {
    	$scope.$emit('remove-navbar');
    	$location.path(url);
    };
    
    /* SIGNUP AND SIGNIN */
    
    self.signup = function(){
        var modalInstance = $uibModal.open({
            templateUrl: 'templates/signup.php',
            controller: 'signupController as signup',
            animation: true,
            backdrop: 'static',
            size: 'lg',
            
        });
        
        modalInstance.result.then(function(){
            
        },function(){
            
        });
    };
    
    self.signin = function(){ 
        var modalInstance = $uibModal.open({
            templateUrl: 'templates/signin.php',
            controller: 'signinController as signin',
            animation: true,
            backdrop: 'static',
            size: 'lg',
            
        });
        
        modalInstance.result.then(function(){
            
        },function(){
            
        });
    };
    
    self.signout = function(){
    	$cookies.remove('username',{path:'/'});
    	$cookies.remove('verified',{path:'/'});
    	$cookies.remove('token',{path:'/'});
    	$location.path('/');
    	$window.location.reload();
    };
    
}]);