main.controller('expController',['$http','inform',function($http,inform){
	var self = this;
	
	self.addAdmin = function(userID, xp, courseID, description)
	{
		var data= {username: userID, exp: xp};
		if(courseID) data.courseID = courseID;
		if(description) data.description = description;
		
		$http.post('users/add_exp',data).then(function(response)
				{
					if(response.data.error)
					{
						inform.add(response.data.description,{type: 'danger'});
						return;
					}
					else
					{
						inform.add('Hai ' + (xp>0? 'aggiunto ' : 'tolto ') + Math.abs(xp) + ' punti esperienza a ' + userID + '!');
					}
					
				},function(error)
				{
					
				});
		
//		console.log(data);
	};
		
	
}]);