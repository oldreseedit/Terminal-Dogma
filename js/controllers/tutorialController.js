main.controller('tutorialController',['$server','$scope','$uibModal','$route','inform',function($server,$scope,$uibModal,$route,inform){
	var self = this;
	
	self.tutorialAjax = $server.post('tutorials/get_all_tutorials',{}, true)
		.then(
			function(response)
			{
				self.tutorials = response.data;
//				console.log(self.tutorials);
				
				for(var i=0; i<self.tutorials.length; i+=1)
				{
					self.tutorials[i].tags = self.tutorials[i].tags.split(" ");
					self.tutorials[i].tags = self.tutorials[i].tags.map(function(tag){return tag.split("_").join(" ");});
					self.tutorials[i].url = self.tutorials[i].title.toLowerCase().split(" ").join("-");
					
					self.tutorials[i].time = moment(self.tutorials[i].publishingTimestamp).fromNow();
					self.tutorials[i].exactTime = moment(self.tutorials[i].publishingTimestamp).format("DD MMMM YYYY");
				}
				
				console.log(self.tutorials);
			}
		);
}]);

main.filter('searchFor', function(){
    return function(arr, query){
    	
        if(!query) return arr;
        
        var result = [];
        
        query = query.toLowerCase();
        
        angular.forEach(arr, function(item){
        		var added = false;

        		if(item.title.toLowerCase().indexOf(query) !== -1 ||
	        	   item.description.toLowerCase().indexOf(query) !== -1 ||
	        	   item.course.toLowerCase().indexOf(query) !== -1)
        		{
        			result.push(item);
        			added = true;
        		}
	        	
				for(var i=0; i<item.tags.length; i+=1)
					if(!added)
						if(item.tags[i].toLowerCase().indexOf(query) !== -1)
						{
							result.push(item);
							added = true;
						}
        	});
        
        return result;
    };
});