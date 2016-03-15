main.controller('tutorialController',['$server','$scope','$uibModal','$route','inform',function($server,$scope,$uibModal,$route,inform){
	var self = this;
	
//	self.tutorialTitle = "";
//	self.tutorialCourse = "";
//	self.tutorialShortDescription = "";
//	self.tutorialRequirements = "";
//	self.tutorialBody = "";
//	self.tutorialTags = "";
//	self.tutorialSeealso = "";
//	self.tutorialID = "";
	
	self.tutorialAjax = $server.post('tutorials/get_all_tutorials',{}, true)
		.then(
			function(response)
			{
				self.tutorials = response.data;
				for(var i=0; i<self.tutorials.length; i+=1)
				{
					self.tutorials[i].tags = self.tutorials[i].tags.split(" ");
					self.tutorials[i].url = self.tutorials[i].title.toLowerCase().split(" ").join("-");
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