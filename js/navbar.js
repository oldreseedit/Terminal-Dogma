main.controller('navbarController',['utilities','$timeout','$window','$uibModal','$rootScope','$cookies',function(utilities,$timeout,$window,$uibModal,$rootScope,$cookies){
    var self = this;
    
    self.tabs = [
        {
            url : 'courses',
            content : 'Corsi'
        },
        // {
        //     url : 'activities',
        //     content : 'Servizi'
        // },
        {
            url : 'media',
            content : 'Media'
        },
        {
            url : 'contacts',
            content : 'Contatti'
        }
    ];
    
    self.sizes = utilities.spacedSizes(self.tabs.length);
    
    self.spaced = function($first){
        if($first) return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.outerWidth;
        else return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.spacerWidth;
    };
    
    self.spaceMacrotabs = function($first){
        var sizes = utilities.spacedSizes(3);
        if($first) return "col-" + sizes.elementsWidth + " offset-" + sizes.outerWidth;
        else return "col-" + sizes.elementsWidth + " offset-" + sizes.spacerWidth;
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
    	$window.location.reload();
    };
    
}]);