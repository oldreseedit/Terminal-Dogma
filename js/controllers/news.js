main.controller('newsController',['$server','$scope','$cookies',function($server,$scope,$cookies){
	var self = this;
	
	self.news = [];
	
	self.getAjax = $server.post('/news/get_latest_news', {top: 2}).then(
			function(response)
			{
				angular.forEach(response.data, function(n){
						n['type'] = 'news';
						self.news.unshift(n);
				});
				self.newsByRow = self.getNewsByRow();
//					console.log(self.news);
			}
	);
	
	self.getAjax = $server.post('/events/get_latest_events', {top: 2}).then(
			function(response)
			{
				self.topEvent = null;
				
				angular.forEach(response.data, function(e){
					e['type'] = 'event';
					self.news.push(e);
					
					if(e.type === 'event' && self.topEvent == null)
					{
						self.topEvent = e;
					}
				});
				self.newsByRow = self.getNewsByRow();
			}
	);
	
	self.getNewsByRow = function()
	{
		var rows = [];
		for(var i=0; i < (self.news.length - self.news.length%3)/3; i++ )
		{
			rows.push([self.news[i],self.news[i+1],self.news[i+2]]);
		}
		var temp = [];
		for(i = self.news.length - self.news.length%3; i < self.news.length; i++)
		{
			temp.push(self.news[i]);
		}
		rows.push(temp);
		return rows;
	};
	
	self.getIconClass = function(event)
	{
		if(!event) return;
		if(event.type === 'event') return 'fa-calendar';
		if(event.type === 'news') return 'fa-newspaper-o';
	};
	
	self.getDate = function(event)
	{
		if(!event) return;
		if(moment(event.startingDate).format('DDMMYYYY') === moment(event.endingDate).format('DDMMYYYY')) // If they are the same day
		{
			return moment(event.startingDate).format('DD.MM.YYYY') + ' - Dalle ' +moment(event.startingDate).format('HH:mm') + ' alle ' + moment(event.endingDate).format('HH:mm');
		}
		else
		{
			//TODO: vedremo
		}
	};
	
}]);