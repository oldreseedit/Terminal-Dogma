main.controller('expController',['$http','inform',function($http,inform){
	var self = this;
	
	self.add = function(userID, xp, courseID, description)
	{
		var data= {userID: userID, exp: xp};
		if(courseID) data.courseID = courseID;
		if(description) data.description = description;
		
		$http.post('users/add_exp',data).then(function(response)
				{
//					if(data.error) 
					console.log(response.data);
					
				},function(error)
				{

				});
		
		console.log(data);
	};
		
	
}]);