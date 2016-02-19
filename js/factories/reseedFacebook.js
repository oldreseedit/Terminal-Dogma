main.factory('fb',['$route',function(){
	
	var ready = false;
	
	var Init = function()
	{
		window.fbAsyncInit = function()
		{
			FB.init({
				appId      : '192780584418480',
				xfbml      : true,
				version   : 'v2.5'
			});
			ready = true;
		};
	};
	
	var Publish = function()
	{
		FB.ui({
			method: 'share',
			href: 'https://www.google.it/'
		});
	};
	
	var init = function(){
		return new Init();
	}
	
	var publish = function(){
		return new Publish();
	}
	
	return  {
		init : init,
		publish : publish
	};
	
}]);