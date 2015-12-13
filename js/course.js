main.controller('courseController',['utilities','$scope','$http','$routeParams','uiCalendarConfig','$timeout','$route','$cookies',function(utilities,$scope,$http,$routeParams,uiCalendarConfig,$timeout,$route,$cookies){
    var self = this;
    
    /* CONFIG */
    
    self.username = $cookies.get('username');
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    
    self.courseID = $routeParams.courseID;
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
        
        if(!$scope.events) $scope.events = [];
        $scope.events.splice(0,$scope.events.length);
        
        angular.forEach(self.db,function(i){
            
            i.startingDate = moment(i.startingDate);
            i.endingDate = moment(i.endingDate);
            var newLesson = {lessonID: i.lessonID, title: i.courseID, start: i.startingDate, end: i.endingDate, note: i.lessonNote, stick: true};
            if(self.indexOfByKey('lessonID',i.lessonID,$scope.events) < 0) $scope.events.push(newLesson);
            
        });
    };
    
    /* PROPER OBJECTS AND METHODS */
    
    $scope.registerMeasures = function(item)
    {
		$http.post('course/update_block_positions',{username: self.username, activityID: self.courseID, panelID: item.id, measure : item.measures}).then(
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
    				console.log(response.data);
//    				$scope.gridsterItems = JSON.parse(response.data.blockPositions);
    				
    				$scope.measuresLoaded = true;
    			}
    			else
    			{
    				 $scope.gridsterItems = [
	                     {
	                    	 id: 'courseDescription',
	                         title: self.courseName,
	                         bgColour: 'bg-light-olive',
	                         templateUrl: 'templates/course-description.php',
	                         sizeX: 8,
	                         sizeY: 1,
	                         row : 0,
	                         col: 0
	                     },
	                     {
	                    	 id: 'courseTeacher',
	                         title: 'Docente',
	                         bgColour: 'bg-light-lawn',
	                         templateUrl: 'templates/course-teacher.php',
	                         sizeX: 4,
	                         sizeY: 1,
	                         col : 9,
	                         row: 0
	                     },
	                     {
	                    	 id: 'calendar',
	                         title: 'Calendario e orari',
	                         bgColour: 'bg-light-green',
	                         templateUrl: 'templates/calendar.php',
	                         sizeX: 6,
	                         sizeY: 1,
	                         col : 0,
	                         row: 7
	                     },
	                     {
	                    	 id: 'courseNotifications',
	                         title: 'Avvisi',
	                         bgColour: 'bg-light-leaf',
	                         templateUrl: 'templates/course-notifications.php',
	                         sizeX: 6,
	                         sizeY: 1,
	                         col : 7,
	                         row: 7
	                     },
	                     {
	                    	 id: 'courseMaterials',
	                         title: 'Materiale del corso',
	                         bgColour: 'bg-light-water',
	                         templateUrl: 'templates/course-materials.php',
	                         sizeX: 12,
	                         sizeY: 1,
	                         col : 0,
	                         row: 14
	                     }
	                 ];
    			}
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
	   	 if(response.data.error) inform.add(response.data.description,{type:'danger'});
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
    
}]);