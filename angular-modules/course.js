main.controller('courseController',['utilities','$scope','$http','$routeParams','uiCalendarConfig','$timeout',function(utilities,$scope,$http,$routeParams,uiCalendarConfig,$timeout){
    var self = this;
    
    self.courseName = $routeParams.courseID.charAt(0).toUpperCase() + $routeParams.courseID.slice(1);
    self.courseName = self.courseName.split(/(?=[A-Z](?=[a-z]))/).join(" ");
    
    self.componentsReady = [];
    
    /* AJAX CALLS */
    
    self.init = function()
    {    
	    $http.post('courses/get',{courseID : $routeParams.courseID}).then(function(response) {
	        // console.log(response);
	        self.courseDescription = response.data;
	        self.componentsReady['courseDescription'] = true;        
	    },function(error) {
	        console.log(error);
	    });
	    
	    $http.post('teachers/get',{courseID : $routeParams.courseID}).then(function(response) {
	        // console.log(response);
	        self.teacher = response.data;
	        self.componentsReady['teacher'] = true;
	    },function(error) {
	        console.log(error);
	    });
	    
	    $http.post('notifications/get',{courseID : $routeParams.courseID}).then(function(response){
	        self.notifications = response.data;
	        angular.forEach(self.notifications,function(notification){
	            notification.publishingTimestamp = moment(notification.publishingTimestamp).format('DD/MM/YYYY');
	        });
	        self.componentsReady['notifications'] = true;
	        // console.log(response);
	    },function(error){
	        console.log(error);
	    });
	    
	    $http.post('course_material/get_all',$routeParams).then(function(response){
	        // console.log(response);
	        self.materials = response.data;
	        
	        angular.forEach(self.materials,function(m){
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

	        self.componentsReady['materials'] = true;
	        
	    },function(error){
	        console.log(error);
	    });
	    
	    /* CALENDAR */
	    
	    $http.post('lessons/get',$routeParams).then(function(response){
	        // console.log(response);
	        
	        self.raw = response.data;
	        self.intervalName = 'year'; // Available
	        
	        $scope.uiConfig = {
	            calendar:{
	                lang : "it",
	                displayEventTime : false,
	                // scrollTime : '08:00:00',
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
	                },
	                viewRender : function(view, element){
	                    
	                    if(self.isIntervalChanged(view)){
	                        
	                        self.setInterval(view);
	                        
	                        $http.post('lessons/get',{'startingDate': self.currentIntervalStart.format('YYYY-MM-DD HH:mm:ss'), 'endingDate': self.currentIntervalEnd.format('YYYY-MM-DD HH:mm:ss'), courseID: $routeParams.courseID}).
	                        then( function(response){
	                            
	                            self.raw = response.data;
	                            self.buildDB();
	                            
	                        }, function(error){
	                            console.log(error);
	                        });
	                        
	                    }
	                }
	            }
	        };
	        
	        self.buildDB();
	        
	        $scope.eventSources = [{events: $scope.events, color: 'green'}];

	        self.componentsReady['calendar'] = true;
	        
	    },function(error){
	        console.log(error);
	    });
	    
    };
    
    $scope.changeView = function(viewName){
        uiCalendarConfig.calendars['register'].fullCalendar('changeView',viewName);
    };
    
    self.isIntervalChanged = function(view){
        if(!self.currentIntervalStart || !self.currentIntervalEnd){ // Initialization
            
            self.setInterval(view);
            return false;
        }
        
        var end = angular.copy(self.currentIntervalEnd);
            
        if(self.intervalName === 'month') end.subtract(7,'days');
        return (!view.start.isBetween(self.currentIntervalStart,end) && !view.start.isSame(self.currentIntervalStart)) || (!view.end.isBetween(self.currentIntervalStart,end) && !view.end.isSame(end)); 
        
    };
    
    self.setInterval = function(view){
            
            self.currentIntervalStart = angular.copy(view.intervalStart).startOf(self.intervalName);
            self.currentIntervalEnd = angular.copy(self.currentIntervalStart).add(self.getIntervalDays()+self.currentIntervalStart.weekday(),'days');
            var startOfMonth = angular.copy(self.currentIntervalEnd).startOf('month');
            
            self.currentIntervalStart.subtract(self.currentIntervalStart.weekday(),'days');
            self.currentIntervalEnd.add(7-self.currentIntervalEnd.weekday(),'days');
            startOfMonth.subtract(startOfMonth.weekday(),'days');
           
            if(self.currentIntervalEnd.diff(startOfMonth,'days') < 42) self.currentIntervalEnd.add(7,'days');
    };
    
    self.getIntervalDays = function(){
        switch(self.intervalName){
            case 'month' : return 30;
            case 'quarter' : return 90;
            case 'semester' : return 180;
            case 'year' : return 365;
        }
        return -1;
    };
    
    /* METHODS */
    
    /* Gives structure to db via informations retrieved by CodeIgniter */
    self.buildDB = function()
    {
        self.db = self.raw;
        
        if(!$scope.events) $scope.events = [];
        $scope.events.splice(0,$scope.events.length);
        
        if(!self.events) self.events = [];
        self.events.splice(0,$scope.events.length);
        
        angular.forEach(self.db,function(i){
            
            i.startingDate = moment(i.startingDate);
            i.endingDate = moment(i.endingDate);
            
            var newLesson = {lessonID: i.lessonID, title: i.courseID, start: i.startingDate, end: i.endingDate, note: i.lessonNote, stick: true};
            if(self.indexOfByKey('lessonID',i.lessonID,$scope.events) <= -1)
            {
                $scope.events.push(newLesson);
                self.events.push(newLesson);
            }
            
        });
        
        // console.log(self.db);
    };
    
    /* Finds index of object by key */
    self.indexOfByKey = function(key, value, array){
        for(var i=0; i<array.length;i++){
            if(array[i][key] === value) return i;
        }
        return -1;
    };
    
    /* MAIN */
    
    /* PROPER OBJECTS AND METHODS */
    
    self.items = [
        {
        	id: 'courseDescription',
            title: self.courseName,
            bgColour: 'bg-light-olive',
            templateUrl: 'templates/course-description.php',
            measures: {
                width: 8,
                height: 4,
                position: {
                    x : 0,
                    y : 0
                }
            }
        },
        {
        	id: 'teacher',
            title: 'Docente',
            bgColour: 'bg-light-lawn',
            templateUrl: 'templates/course-teacher.php',
            measures: {
                width: 4,
                height: 4,
                position: {
                    x : 9,
                    y : 0
                }
            }
        },
        {
        	id: 'calendar',
            title: 'Calendario e orari',
            bgColour: 'bg-light-green',
            templateUrl: 'templates/calendar.php',
            measures: {
                width: 6,
                height: 6,
                position: {
                    x : 0,
                    y : 5
                }
            }
        },
        {
        	id: 'notifications',
            title: 'Avvisi',
            bgColour: 'bg-light-leaf',
            templateUrl: 'templates/course-notifications.php',
            measures: {
                width: 6,
                height: 6,
                position: {
                    x : 7,
                    y : 5
                }
            }
        },
        {
        	id: 'materials',
            title: 'Materiale del corso',
            bgColour: 'bg-light-water',
            templateUrl: 'templates/course-material.php',
            measures: {
                width: 12,
                height: 4,
                position: {
                    x : 0,
                    y : 12
                }
            }
        }
    ];
    
    self.customItemMap = {
        sizeX: 'item.measures.width',
        sizeY: 'item.measures.height',
        row: 'item.measures.position.y',
        col: 'item.measures.position.x',
        minSizeX: 'item.measures.minWidth',
        minSizeY: 'item.measures.minHeight'
    };
    
    self.isReady = function(id)
    {
    	if(!id)
		{
    		return self.componentsReady.length === self.items.length;
		}
    	if(self.componentsReady[id] === undefined) return false;
    	return self.componentsReady[id];
    }
    
}]);