/* AJAX CALLS FOR SPINNERS */
main.config(['$httpProvider', function($httpProvider){
	$httpProvider.interceptors.push(['$rootScope','ajaxEvents',function($rootScope,ajaxEvents){
		return {
			'request': function(config){
				var id = config.url + JSON.stringify(config.data);
				ajaxEvents.set(id,true);
				return config;
			},
			'response': function(response){
				var id = response.config.url + JSON.stringify(response.config.data);
				ajaxEvents.set(id,false);
//				console.log(ajaxEvents);
				return response;
			}
		};
	}]);
}]);