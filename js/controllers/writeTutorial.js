main.controller('writeTutorial',['$server','$scope','$uibModal','$route','inform',function($server,$scope,$uibModal,$route,inform){
	var self = this;
	
	self.tutorialTitle = "";
	self.tutorialCourse = "";
	self.tutorialShortDescription = "";
	self.tutorialRequirements = "";
	self.tutorialBody = "";
	self.tutorialTags = "";
	self.tutorialSeealso = "";
	self.tutorialID = "";
	
	self.send = function()
	{
		if(self.tutorialID == "")
		{
			$server.post('tutorials/add',
					{
						title: self.tutorialTitle,
						course: self.tutorialCourse.name,
						description: self.tutorialShortDescription,
						requirements: self.tutorialRequirements,
						body: self.tutorialBody,
						tags: self.tutorialTags,
						seealso: self.tutorialSeealso
					}, true).then(
		    		function(response)
		    		{
//		    			console.log(response);
		    			
		    			inform.add(response.data.description);
		    			self.tutorialID = response.data.tutorialID;
		    		}
		        );
		}
		else
		{
			$server.post('tutorials/update',
					{
						tutorialID: self.tutorialID,
						title: self.tutorialTitle,
						course: self.tutorialCourse.name,
						description: self.tutorialShortDescription,
						requirements: self.tutorialRequirements,
						body: self.tutorialBody,
						tags: self.tutorialTags,
						seealso: self.tutorialSeealso
					}, true).then(
		    		function(response)
		    		{
//		    			console.log(response);
		    			
		    			inform.add(response.data.description);
		    		}
		        );
		}
	}
	
	$server.post('courses/get_all_names').then(
    		function(response)
    		{
    			self.courses = response.data;
    		}
        );
}]);