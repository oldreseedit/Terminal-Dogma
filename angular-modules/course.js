main.controller('courseController',['utilities','$scope','$http','$routeParams','uiCalendarConfig','$timeout','$route',function(utilities,$scope,$http,$routeParams,uiCalendarConfig,$timeout,$route){
    var self = this;
    
    /* CONFIG */
    
    self.courseName = $routeParams.courseID.charAt(0).toUpperCase() + $routeParams.courseID.slice(1);
    self.courseName = self.courseName.split(/(?=[A-Z](?=[a-z]))/).join(" ");
    
    self.courseID = $routeParams.courseID;
    self.courseDescription = $route.current.locals.courseDescription;
    self.teacher = $route.current.locals.teacher;
    self.notifications = $route.current.locals.notifications;
    self.materials = $route.current.locals.materials;
    self.lessons = $route.current.locals.lessons;
    self.intervalName = 'year'; // Available
        
    $scope.uiConfig = {
    		calendar: {
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

    					$http.post('lessons/get',{'courseID': self.courseID, 'startingDate': self.currentIntervalStart.format('YYYY-MM-DD HH:mm:ss'), 'endingDate': self.currentIntervalEnd.format('YYYY-MM-DD HH:mm:ss'), courseID: $routeParams.courseID}).
    					then( function(response){

    						self.lessons = response.data;
    						self.buildDB();

    					}, function(error){
    						console.log(error);
    					});

    				}
    			}
    		}
    };
    
    /* METHODS */
    
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
            if(self.indexOfByKey('lessonID',i.lessonID,$scope.events) <= -1) $scope.events.push(newLesson);
            
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
    
    self.getMargin = function(a,b)
    {
    	return {
    		'margin-top' : (a-b)/2 + 'px'
    	};
    };
    
    /* MAIN */
    
    self.buildDB();
    console.log($scope.events);
    $scope.eventSources = [{events: $scope.events, color: 'green'}];
    
    
}]);