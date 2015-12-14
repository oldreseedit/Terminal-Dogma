main.controller('courseController',['utilities','$scope','$http','$routeParams','uiCalendarConfig','$timeout','$route','$cookies','inform',function(utilities,$scope,$http,$routeParams,uiCalendarConfig,$timeout,$route,$cookies,inform){
    var self = this;
    
//    $scope.Math = window.Math;
    
    /* CONFIG */
    
    self.username = $cookies.get('username');
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    
    self.courseID = $routeParams.courseID;
    self.courseName = self.courseID.split(/([0-9]*[A-Z][a-z]*)/).join(' ');
    self.courseName = self.courseName.charAt(0).toUpperCase() + self.courseName.slice(1);
    self.subscribed = false;
//    self.courseName = courseID
    
    $scope.events = [];
    $scope.eventSources = [{events: $scope.events, color: 'green'}];
     
    $scope.uiConfig = {
    		calendar: {
    			lang : "it",
    			displayEventTime : false,
    			minTime : '06:00:00',
    			maxTime : '21:00:00',
    			contentHeight : 'auto',
    			editable : false,
    			selectable : false,
    			unselectAuto : false,
    			header : {
    				left:   'title',
    				center: '',
    				right:  'prev,next'
    			}
    		}
    };
    
    $scope.gridsterItems = [];
    
    /* METHODS */
    
    $scope.changeView = function(viewName){
        uiCalendarConfig.calendars['register'].fullCalendar('changeView',viewName);
    };
    
    /* Finds index of object by key */
    self.indexOfByKey = function(key, value, array){
        for(var i=0; i<array.length;i++){
            if(array[i][key] === value) return i;
        }
        return -1;
    };
    
    /* Gives structure to db via informations retrieved by CodeIgniter */
    self.buildDB = function()
    {
        self.db = self.lessons;
        
        self.firstLesson = self.db.length > 0 ? moment(self.db[Object.keys(self.db)[0]].startingDate).format("dddd D MMMM") : null;
        
        if(!$scope.events) $scope.events = [];
        $scope.events.splice(0,$scope.events.length);
        
        angular.forEach(self.db,function(i){
            
            i.startingDate = moment(i.startingDate);
            i.endingDate = moment(i.endingDate);
            var newLesson = {lessonID: i.lessonID, title: i.courseID, start: i.startingDate, end: i.endingDate, note: i.lessonNote, stick: true};
            if(self.indexOfByKey('lessonID',i.lessonID,$scope.events) < 0) $scope.events.push(newLesson);
        });
    };
    
    self.setStaticProperties = function(item)
    {	
		switch(item.id)
		{
			case 'courseDescription':
				item.title = self.courseName;
				item.bgColour = 'bg-light-olive';
                	item.templateUrl = 'templates/course-description.php';
				break;
			case 'courseTeacher':
				item.title = 'Docente';
				item.bgColour = 'bg-light-lawn';
                	item.templateUrl = 'templates/course-teacher.php';
				break;
			case 'calendar':
				item.title = 'Calendario delle lezioni';
				item.bgColour = 'bg-light-green';
                	item.templateUrl = 'templates/calendar.php';
				break;
			case 'courseNotifications':
				item.title = 'Avvisi';
				item.bgColour = 'bg-light-leaf';
                	item.templateUrl = 'templates/course-notifications.php';
				break;
			case 'courseMaterials':
				item.title = 'Materiale del corso';
				item.bgColour = 'bg-light-water';
                	item.templateUrl = 'templates/course-materials.php';
				break;
		}
    }
    
    /* PROPER OBJECTS AND METHODS */
    
    $scope.registerMeasures = function(item)
    {
		$http.post('course/update_block_positions',{username: self.username, activityID: self.courseID, panelID: item.id, measures : item.measures}).then(
    			function(response)
    			{
//        			console.log(response);
    			},
    			function(error)
    			{
    				console.log(error);
    			}
    	);
    };
    
    $http.post('course/load_block_positions',{username : self.username, courseID : self.courseID}).then(
    		function(response)
    		{    			
    			if(!response.data.error)
    			{
//    				console.log(response.data);
    				var items = response.data.panelMeasures;
    				angular.forEach(items, function(m)
    				{
        				m.block_positions = JSON.parse(m.block_positions);
    				});
    			}
    			else
    			{
    				 var items = [
	                     {
	                    	 id: 'courseDescription',
	                         sizeX: 8,
	                         sizeY: 1,
	                         row : 0,
	                         col: 0
	                     },
	                     {
	                    	 id: 'courseTeacher',
	                         sizeX: 4,
	                         sizeY: 1,
	                         col : 8,
	                         row: 0
	                     },
	                     {
	                    	 id: 'calendar',
	                         sizeX: 6,
	                         sizeY: 1,
	                         col : 0,
	                         row: 10
	                     },
	                     {
	                    	 id: 'courseNotifications',
	                         sizeX: 6,
	                         sizeY: 1,
	                         col : 6,
	                         row: 10
	                     },
	                     {
	                    	 id: 'courseMaterials',
	                         sizeX: 12,
	                         sizeY: 1,
	                         col : 0,
	                         row: 20
	                     },
	                     {
							id: 'banner',
//							templateUrl: 'templates/course-banner.php',
						    sizeX: 12,
						    sizeY: 1,
						    row : 30,
						    col: 0
						}
	                 ];

					$timeout(function(){
						$scope.$broadcast('firstLoad');
					});
    			}
				angular.forEach(items,function(item){
					self.setStaticProperties(item);
					
					$scope.gridsterItems.push(item);
				});;
    		},
    		function(error)
    		{
    			console.log(error);
    		}
    );
    
     // MAIN
    
    $http.post('courses/get',{courseID : self.courseID}).then(function(response) {
        if(response.data.error) inform.add(response.data.description,{type:'danger'});
        else if(response.data)
        {
        	self.courseDescription = response.data;
        	self.courseHasStarted = moment().isAfter(moment(response.data.startingDate));
        	self.hourPrice = Math.round(100 * self.courseDescription.price/self.courseDescription.duration)/100;
        }
    },function(error) {
        console.log(error);
    });
    
    $http.post('teachers/get',{courseID : self.courseID}).then(function(response) {
        if(response.data.error) inform.add(response.data.description,{type:'danger'});
        else if(response.data)
        {
        	self.teacher = response.data;
        }
    },function(error) {
        console.log(error);
    });
    
    $http.post('notifications/get',{courseID : self.courseID}).then(function(response) {
    	 if(response.data.error) inform.add(response.data.description,{type:'danger'});
         else if(response.data)
         {
         	self.notifications = response.data;
         }
    },function(error) {
        console.log(error);
    });
    
    $http.post('course_material/get_all',{courseID : self.courseID}).then(function(response) {
	   	 if(response.data.error)
	   	 {
	   		 inform.add(response.data.description,{type:'danger'});
	   	 }
	     else if(response.data)
	     {
	        var data = response.data;
	        angular.forEach(data,function(m){
	            m.getFA = function(){
	                var fileExtension = m.fileURI.split('.');
	                fileExtension = fileExtension[fileExtension.length-1];
	                if(fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') fileExtension = 'image';
	                if(fileExtension === 'doc' || fileExtension === 'docx') fileExtension = 'word';
	                if(fileExtension === 'ppt' || fileExtension === 'pptx') fileExtension = 'powerpoint';
	                if(fileExtension === 'xls' || fileExtension === 'xlsx') fileExtension = 'excel';
	                if(fileExtension === 'rar') fileExtension = 'zip';
	                if(fileExtension === 'c' || fileExtension === 'java' || fileExtension === 'php' || fileExtension === 'js' || fileExtension === 'html') fileExtension = 'code';
	                return 'fa-file-' + fileExtension + '-o';
	            };
	            m.getTitle = function(){
	                var title = m.fileURI.split('/');
	                title = title[title.length-1].split('.');
	                title = title[0];
	                title = title.replace(/_/g,' ');
	                // console.log(title);
	                return title;
	            };
	        });
	        self.materials = data;
	     }
    },function(error) {
    		console.log(error);
    });
    
    $http.post('lessons/get',{courseID: self.courseID}).then(function(response){
	   	 if(response.data.error) inform.add(response.data.description,{type:'danger'});
	     else if(response.data)
	     {
	     	self.lessons = response.data;
	        
	        self.buildDB();
	     }
    }, function(error){
        console.log(error);
    });
    
    $http.post('payment_interface/get_courses',{username: self.username}).then(
    		function(response)
    		{
    			if(response.data.error) inform.add(response.data.description,{type:'danger'});
    			else if(response.data)
    			{
    				self.tempCourses = response.data;
    			    for(var i=0; i<self.tempCourses.length; i++)
    				   	if(self.tempCourses[i] === self.courseID)
    				   		self.subscribed = true;
    			}
    		},
    		function(error)
    		{
    			console.log(error);
    		}
    	);
    
}]);