main.run(['$rootScope',function($rootScope){
	$rootScope.ajaxEvents = [];
}]);

main.factory('ajaxEvents',function(){
	var events = [];
	
	events.set = function(id, status)
	{
		this[id] = status;
	};
	
	events.get = function(id)
	{
		return this[id];
	};
	
	return events;
	
});