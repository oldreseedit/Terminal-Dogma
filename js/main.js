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
    'youtube-embed', // For embedding Youtube Videos
//    'ngFitText', // My creation for perfectly centering text into div
//    'gridster', // For draggable/resizable divs
    'lr.upload', // For uploading purposes
    'inform', // For notifier purposes
    'angularMoment', // For inline moment
    'ngAnimate', // For animations
    'ngTouch', // For Touch Support
    'teachingToolbox', // It explains itself
    'textAngular', // For TextAngular support
    'angularFileUpload', // For angular-file-upload suppoer
    ], function($httpProvider) {

    // For CI
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.transformRequest = [function(data) {
        return angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;
    }];
    
    // For FB
	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		
		// DEBUG: //connect.facebook.net/it_it/sdk/debug.js
		// LIVE:  //connect.facebook.net/it_it/sdk.js
		js.src = "//connect.facebook.net/it_it/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	
});

/* Configures Moment plugin to display dates in Italian */
moment.locale('it', {}); 

var MQ = MathQuill.getInterface(2);

/*** RUN PHASE ***/
main.run(['$rootScope','$location','$timeout','$server','$cookies','$window','$route','inform','$cookies','fb',function($rootScope, $location, $timeout, $server, $cookies, $window, $route, inform,$cookies,fb) {

	// For MathJax
	window.addEventListener('MathJaxLoaded', function(){
		$rootScope.$broadcast('MathJaxLoaded');
	});
	
	/** FOR RESPONSIVE STYLES **/
  
	$rootScope.imOnResponsive = (window.innerWidth > 0) ? (window.innerWidth < 1080) : (screen.width < 1080);
	
	imOnResponsive = function()
	{
		return $rootScope.imOnResponsive;
	};
	imOnResponsive = $rootScope.imOnResponsive;
	
	/** **/
	
	fb.init();

	$rootScope.ajaxEvents = [];
	
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
		$server.post('avatars/get_avatar', {username: $rootScope.username}).then(
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
		$server.post('notifications/get_unseen_user_notifications',{username: $rootScope.username}).then(
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
        if($location.path() !== '/' && $location.url().indexOf('/home') !== 0) return true;
        else return false;
    };    

    $rootScope.logout = function(){
        $cookies.remove('username',{path:'/'});
        $cookies.remove('token',{path:'/'});
        $cookies.remove('verified',{path:'/'});
        $cookies.remove('cart',{path:'/'});
        $location.path('/');
        $window.location.reload();
    };

    if($cookies.get('verified') === '1'){
    	
        $rootScope.userVerified = true;
        $rootScope.username = $cookies.get('username');
        
        $rootScope.getUnseenNotifications();
        
        $rootScope.setAvatar();
        
        $server.post('admins/is_admin',{username: $rootScope.username}).then(
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