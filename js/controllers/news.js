main.controller('newsController',['$server',function($server){
	var self = this;
	
	self.news = [];
	
	self.getAjax = $server.post('/news/get_latest_news').then(
			function(response)
			{
				console.log(response.data);
				angular.forEach(response.data, function(n){
						n['type'] = 'news';
						self.news[n['newsID']] = n;
					}
				);
				
				self.getAjax = $server.post('/events/get_latest_events').then(
						function(response)
						{
							console.log(response.data);
							angular.forEach(response.data, function(e){
								e['type'] = 'event';
								self.news[e['eventID']] = e;
							}
						);
						}
				);
			}
	);
	
	self.getIconClass = function(event)
	{
		if(!event) return;
		if(event.type === 'event') return 'fa-calendar';
		if(event.type === 'news') return 'fa-newspaper-o';
	};
	
	
}]);