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
     
    $scope.uiConfig = {
    		calendar: {
    			lang : "it",
    			displayEventTime : false,
//    			firstDay: '1',
//    			monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
//    			
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
    
    $scope.gridsterItems = [
        {
        	id: 'courseDescription',
            title: self.courseName,
            bgColour: 'bg-light-olive',
            templateUrl: 'templates/course-description.php',
            measures: {
                width: 8,
                height: 0,
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
                height: 0,
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
                height: 0,
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
                height: 0,
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
                height: 0,
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
//    console.log($scope.events);
    $scope.eventSources = [{events: $scope.events, color: 'green'}];    
    
    $timeout(function(){
    	$scope.activateScrollbar = true;
    },3000);
    
}]);