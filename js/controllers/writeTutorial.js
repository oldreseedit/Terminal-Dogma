main.controller('writeTutorial',['$rootScope', '$routeParams','$server','$scope','$uibModal','$route','inform','FileUploader',function($rootScope, $routeParams, $server,$scope,$uibModal,$route,inform,FileUploader){
	var self = this;
	
	self.tutorialTitle = "";
	self.tutorialID = "";
	self.tutorialCourse = "";
	self.tutorialShortDescription = "";
	self.tutorialRequirements = "";
	self.tutorialBody = "";
	self.tutorialTags = "";
	self.tutorialSeealso = "";
	self.tutorialImages = [];
	
	self.mode = "write";
	
	if($routeParams.tutorialID)
	{
		self.tutorialID = $routeParams.tutorialID;
		self.mode = "modify";
		
		self.tutorialInfoAjax = $server.post('tutorials/get',{tutorialID: self.tutorialID}).then(
	    		function(response)
	    		{
	    			self.tutorial = response.data;
//	    			console.log(self.tutorial);
	    			
	    			self.tutorialTitle = self.tutorial.title;
	    			self.tutorialID = self.tutorial.tutorialID;
	    			self.tutorialCourse = {name: self.tutorial.course};
	    			self.tutorialShortDescription = self.tutorial.description;
	    			self.tutorialRequirements = self.tutorial.requirements;
	    			self.tutorialBody = self.tutorial.body;
	    			self.tutorialTags = self.tutorial.tags;
	    			self.tutorialSeealso = self.tutorial.seealso;
	    			self.tutorialImages = self.tutorial.images;
	    			
	    			$rootScope.title = self.tutorial.title;
	    			$rootScope.description = self.tutorial.description;
	    			
	    			$rootScope.ogTitle = $rootScope.title;
	    		    $rootScope.ogDescription = $rootScope.description;
	    		});
	}
	
	self.send = function()
	{
		var pending = self.uploader.getNotUploadedItems();
		for(var i=0; i<pending.length; i++)
		{
			self.uploader(pending[i]);
		}
		
		if(self.mode == "write")
		{
			$server.post('tutorials/add',
					{
						tutorialID: self.tutorialID,
						title: self.tutorialTitle,
						id: self.tutorialID,
						course: self.tutorialCourse.name,
						description: self.tutorialShortDescription,
						requirements: self.tutorialRequirements,
						body: self.tutorialBody,
						tags: self.tutorialTags,
						seealso: self.tutorialSeealso,
						images: self.tutorialImages
					}, true).then(
		    		function(response)
		    		{
//		    			console.log(response);
		    			
		    			inform.add(response.data.description);
		    			// self.tutorialID = response.data.tutorialID;
		    			
		    			self.mode = "modify";
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
//    			console.log(self.courses);
    		}
        );
	
	self.uploader = new FileUploader({url: 'index.php/tutorials/upload_image'});
	
	self.uploader.onAfterAddingFile = function(fileItem) {
		fileItem.formData.push({
			title: self.tutorialTitle
		});
    };
    
    self.uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
        
        var message = response.description;
        if(response.error) message += " (file: "+fileItem.file.name+")";
        
    	inform.add(message, {type: response.error ? 'danger' : 'success'});
    	
    	if(!response.error)
    		self.tutorialImages.push(response.url);
    };
    
    $scope.$watch(function(){return self.tutorialTitle;}, function(newValue, oldValue) {
    	if(self.mode == "write")
    		self.tutorialID = self.tutorialTitle.toLowerCase().split(" ").join("-");
    });
    
    self.removeImage = function()
    {
    	self.tutorialImages = "";
    	console.log(self.tutorialImages);
    }
}]);