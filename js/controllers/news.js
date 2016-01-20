main.controller('newsController',['$server',function($server){
	var self = this;
	
	self.news = [];
	
	self.getAjax = $server.post('/news/get').then(
			function(response)
			{
				console.log(response.data);
				
				self.getAjax = $server.post('/events/get').then(
						function(response)
						{
							console.log(response.data);
						}
				);
			}
	);
	
	self.getIconClass = function(event)
	{
		if(event.type === 'event') return 'fa-calendar';
		if(event.type === 'news') return 'fa-newspaper-o';
	};
	
	
}]);