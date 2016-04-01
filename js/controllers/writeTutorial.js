main.controller('writeTutorial',['$rootScope', '$routeParams','$server','$scope','$uibModal','$route','inform','FileUploader','$interval',function($rootScope, $routeParams, $server,$scope,$uibModal,$route,inform,FileUploader,$interval){
	var self = this;
	
	self.tutorialTitle = "";
	self.tutorialID = "";
	self.tutorialCourse = "";
	self.tutorialShortDescription = "";
	self.tutorialRequirements = "";
	self.tutorialBody = [];
	self.tutorialTags = "";
	self.tutorialSeealso = "";
	self.tutorialMainImage = "";
	self.tutorialImages = [];
	
	self.mode = "write";
	
	self.ctrlS = function(event){
		if(event.ctrlKey && (event.keyCode == 83 || event.which == 83))
		{
			event.preventDefault();
			self.send();
			$interval.cancel(this.promise);
			self.autosave();
		}
	};
	
	
	if($routeParams.tutorialID)
	{
		self.tutorialID = $routeParams.tutorialID;
		self.mode = "modify";
		
		self.tutorialInfoAjax = $server.post('tutorials/get',{tutorialID: self.tutorialID}).then(
	    		function(response)
	    		{
	    			self.tutorial = response.data;
	    			
	    			self.tutorialTitle = self.tutorial.title;
	    			self.tutorialID = self.tutorial.tutorialID;
	    			self.tutorialCourse = {name: self.tutorial.course};
	    			self.tutorialShortDescription = self.tutorial.description;
	    			self.tutorialRequirements = self.tutorial.requirements;
	    			self.tutorialBody = JSON.parse(self.tutorial.body);
	    			self.tutorialTags = self.tutorial.tags;
	    			self.tutorialSeealso = self.tutorial.seealso;
	    			self.tutorialMainImage = self.tutorial.mainImage;
	    			self.tutorialImages = self.tutorial.images;
	    			
	    			console.log(self.tutorial);
	    			console.log(self.tutorialImages);
	    			
	    			$rootScope.title = self.tutorial.title;
	    			$rootScope.description = self.tutorial.description;
	    			
	    			$rootScope.ogTitle = $rootScope.title;
	    		    $rootScope.ogDescription = $rootScope.description;
	    		});
	}
	
	self.send = function(preview)
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
						mainImage: self.tutorialMainImage,
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
		    			
		    			if(preview) location.href = "/tutorial/" + self.tutorialID;
		    			else inform.add(response.data.description);
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
    
    self.removeImage = function(index)
    {
    	self.tutorialImages.splice(index, 1);
    	console.log(self.tutorialImages);
    	// TODO: index.php/tutorials/remove_image
    }
    
    self.removeStep = function(index)
    {
    	self.tutorialBody.splice(index, 1);
    }
    
    self.addStep = function(index)
    {
    	self.tutorialBody.splice(index, 0, {"title": "Passo " + (index+1), "content": ""});
    }
    
    self.preview = function()
    {
    	self.send("/tutorial/" + self.tutorialID);
    }
    
    self.autosave = function(){
    	self.promise = $interval(function(){
	    	if(self.tutorialTitle !== '')
	    	{
	    		console.log("Saving to DB...");
	    		self.send();
	    	}
	    }, 30000);
    }
    
    self.copyLinkOK = function(image)
    {
    	inform.add("Link correttamente copiato: " + image);
    }
    
    self.copyLinkFailed = function(image)
    {
    	inform.add("Errore durante la copia del link: " + image, {type: 'danger'});
    }
}]);