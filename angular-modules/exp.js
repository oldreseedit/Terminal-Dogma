main.controller('expController',['$http',function($http){
	var self = this;
	
	self.add = function(userID, xp, courseID, description)
	{
		
		console.log(userID,xp,courseID,description);
	};
	
}]);