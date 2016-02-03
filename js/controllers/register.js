main.controller('Register',['$server','inform','$route','$scope','uiCalendarConfig','$uibModal',function($server,inform,$route,$scope,uiCalendarConfig,$modal){
    
    var self = this;
    
    /* CONFIGURATIONS */
    
    /* Configures events and general settings for plugin Angular UI Calendar */
    
    self.intervalName = 'year'; // Available
    // self.intervalName = 'semester'; // Not available, other IFs to consider
    // self.intervalName = 'quarter'; // Not available, other IFs to consider
    // self.intervalName = 'month'; // Available
    
    $scope.uiConfig = {
        calendar:{
            lang : "it",
            displayEventTime : false,
            // scrollTime : '08:00:00',
            minTime : '06:00:00',
            maxTime : '21:00:00',
            contentHeight : 'auto',
            editable : true,
            selectable : false,
            unselectAuto : false,
            header : {
                left:   'title',
                center: '',
                right:  'prev,next'
            },
            
            // displayEventEnd : true, // Shows in the calendar not only the starting hours but end hours too.
            
            eventClick: function(calEvent, jsEvent, view){
                if(self.changes.studentsChanges.length || self.changes.lessonNote !== undefined)
                {
                    alert("Ci sono cambiamenti nella lezione selezionata. Prima di cambiare lezione, salvare i cambiamenti.");
                    return;
                }
                
                self.selectedLessonID = calEvent.lessonID;
                self.changes.lessonID = self.selectedLessonID;
            },
            dayClick: function(date, jsEvent, view){
                if(self.changes.studentsChanges.length || self.changes.lessonNote !== undefined)
                {
                    inform.add("Ci sono cambiamenti nella lezione selezionata. Prima di cambiare lezione, salvare i cambiamenti.",{type:'warning'});
                    return;
                }
                else{
                    self.selectedLessonID = undefined;
                    self.renderSelection(date,view);
                }
            },
            select : function(start, end, jsEvent, view){
                
                if(self.changes.studentsChanges.length || self.changes.lessonNote !== undefined)
                {
                    inform.add("Ci sono cambiamenti nella lezione selezionata. Prima di cambiare lezione, salvare i cambiamenti.",{type:'warning'});
                    return;
                }
                
                self.selected = start;
                self.selectedStartingHour = moment(angular.copy(start));
                self.selectedEndingHour = moment(angular.copy(start)).add(1,'hour');
            },
            unselect : function(view, jsEvent){
                self.selected = undefined;
            },
            viewRender : function(view, element){
                
                if( self.changes && (self.changes.studentsChanges.length || self.changes.lessonNote !== undefined))
                {
                    inform.add("Ci sono cambiamenti nella lezione selezionata. Prima di cambiare lezione, salvare i cambiamenti.",{type:'warning'});
                    return;
                }
                
                if(self.isIntervalChanged(view)){
                    
                    self.setInterval(view);
                    
                    $server.post('lessons/get',{'startingDate': self.currentIntervalStart.format('YYYY-MM-DD HH:mm:ss'), 'endingDate': self.currentIntervalEnd.format('YYYY-MM-DD HH:mm:ss')}).
                    then( function(response){
                        
                        self.setDefaults();
                        self.raw = response.data;
                        self.buildDB();
                        
                    }, function(error){
                        console.log(error);
                    });
                    
                }
            },
            eventResize : function(event, delta, revertFunc, jsEvent, ui, view){
                
                $server.post('lessons/update',{
                    lessonID : event.lessonID,
                    endingDate : event.end.format('YYYY-MM-DD HH:mm:ss')
                }).
                then( function(response){
                    self.db[event.lessonID].endingDate = event.end;
                }, function(error){
                    revertFunc();
                });
                
            },
            eventDrop : function(event, delta, revertFunc, jsEvent, ui, view ){
                $server.post('lessons/update',{
                    lessonID : event.lessonID,
                    startingDate : event.start.format('YYYY-MM-DD HH:mm:ss'),
                    endingDate : event.end.format('YYYY-MM-DD HH:mm:ss')
                }).
                then( function(response){
                    self.db[event.lessonID].startingDate = event.start;
                    self.db[event.lessonID].endingDate = event.end;
                }, function(error){
                    revertFunc();
                });
            }
        }
    };
    
    $scope.changeView = function(viewName){
        if(self.changes.studentsChanges.length || self.changes.lessonNote !== undefined)
        {
            inform.add("Ci sono cambiamenti nella lezione selezionata. Prima di cambiare lezione, salvare i cambiamenti.",{type:'warning'});
            return;
        }
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
    
    self.renderSelection = function(date,view){
        
        if(view.name !== 'month'){
            var startingHour = angular.copy(date).startOf('hour');
            var endingHour = angular.copy(startingHour).add(1,'hour');
            uiCalendarConfig.calendars['register'].fullCalendar('select', startingHour, endingHour);
        }
        else{
            var isNot2AM = angular.copy(date).add(7,'hours');
            uiCalendarConfig.calendars['register'].fullCalendar('select', isNot2AM);
        }
        
    };
    
    /* METHODS */
    
    /* Gives structure to db via informations retrieved by CodeIgniter */
    self.buildDB = function()
    {
        self.db = self.raw;
        
        self.changes = { studentsChanges : [] };
        self.coursesList = [];
        
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
            
            if(self.coursesList.indexOf(i.courseID) < 0) self.coursesList.push(i.courseID);
            
        });
    
        self.checkedCourses = [];
        angular.forEach(self.coursesList,function(i){
            self.checkedCourses[i] = true;
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
    
    self.checkChanges = function(){
        
        self.changes.studentsChanges = self.changes.studentsChanges.filter(function(i){
            return i.attendance !== undefined || i.note !== undefined;
        });
        // console.log(self.changes);
        
    };
    
    /* Updates the list of changes in preparation of DB changes to send */
    
    self.toggleAttendance = function(index){
        
        self.db[self.selectedLessonID].studentList[index].attendance = 1 - self.db[self.selectedLessonID].studentList[index].attendance;
        
        var attendanceID = self.db[self.selectedLessonID].studentList[index].attendanceID;
        var userID = self.db[self.selectedLessonID].studentList[index].userID;
        var attendance = self.db[self.selectedLessonID].studentList[index].attendance;
        var userInChange = self.changes.studentsChanges.filter(function(i){
            return i.userID === userID;
        });
        
        if(userInChange.length === 0) self.changes.studentsChanges.push({attendanceID : attendanceID, userID : userID, attendance : attendance});
        
        var indexInChanges = self.indexOfByKey('userID',userID,self.changes.studentsChanges);
        
        if(attendance !== self.db[self.selectedLessonID].studentList[index].originalAttendance){
            self.changes.studentsChanges[indexInChanges].attendance = attendance;
        }
        else{
            delete self.changes.studentsChanges[indexInChanges].attendance;
        }
        
        self.checkChanges();
        
    };
    
    self.modifyNote = function(index,check){
        if(check) return;
        
        var attendanceID = self.db[self.selectedLessonID].studentList[index].attendanceID;
        var userID = self.db[self.selectedLessonID].studentList[index].userID;
        var note = self.db[self.selectedLessonID].studentList[index].note;
        var userInChange = self.changes.studentsChanges.filter(function(i){
            return i.userID === userID;
        });
        
        if(userInChange.length === 0)   self.changes.studentsChanges.push({attendanceID: attendanceID, userID : userID, note : note});
        
        var indexInChanges = self.indexOfByKey('userID',userID,self.changes.studentsChanges);
        var indexInDB = self.indexOfByKey('userID',userID,self.db[self.selectedLessonID].studentList);
        
        if(note !== self.db[self.selectedLessonID].studentList[indexInDB].originalNote){
            self.changes.studentsChanges[indexInChanges].note = note;
        }
        else{
            delete self.changes.studentsChanges[indexInChanges].note;
        }
        
        self.checkChanges();
    };
    
    self.modifyLessonNote = function(check){
        if(check) return;
        
        if(self.db[self.selectedLessonID].lessonNote !== self.db[self.selectedLessonID].originalLessonNote){
            self.changes.lessonNote = self.db[self.selectedLessonID].lessonNote;
        }
        else{
            delete self.changes.lessonNote;
        }
        
        self.checkChanges();
    };
    
    self.restoreOldNote = function(index,oldNote){
        self.db[self.selectedLessonID].studentList[index].note = oldNote;
    };
    
    self.restoreOldLessonNote = function(oldNote){
        self.db[self.selectedLessonID].lessonNote = oldNote;
    };
    
    self.restoreOriginalNote = function(index){
        self.db[self.selectedLessonID].studentList[index].note = self.db[self.selectedLessonID].studentList[index].originalNote;
    };
    
    self.restoreOriginalLessonNote = function(){
        self.db[self.selectedLessonID].lessonNote = self.db[self.selectedLessonID].originalLessonNote;
        self.modifyLessonNote(0);
    };
    
    self.getStudentList = function(){
        return self.selectedLessonID ? self.db[self.selectedLessonID].studentList : [];
    };
    
    /* Method for left selection */
    
    self.updateEvents = function(){
        for(var i = 0; i<self.events.length; i++){
            
            var index = self.indexOfByKey('lessonID',self.events[i].lessonID,$scope.events);
            
            if(self.checkedCourses[self.events[i].title] !== true && index !== -1){
                $scope.events.splice(index,1);
            }
            if(self.checkedCourses[self.events[i].title] === true && index===-1){
                $scope.events.push(self.events[i]);
            }
        }
        
        // Removes right column too, if it matches the toggled element
        if(self.selectedLessonID !== undefined){
            if(self.checkedCourses[self.db[self.selectedLessonID].courseID] === false) self.setDefaults();
        }
    };
    
    self.submitChanges = function(){
        
        if(self.changes.studentsChanges.length === 0 && self.changes.lessonNote === undefined) return;
        
        $server.post('lessons/update_batch',self.changes).
        then(function(response){
        	
        	notifies = response.data;
        	var error = false;
			angular.forEach(notifies,function(notify)
				{
					if(notify.error)
					{
						inform.add(notify.description,{type: 'danger' });
						error = true;
					}
				}		
			);
			if(!error) inform.add('Cambiamenti memorizzati con successo!');			
        	
            // Replaces original values with current ones
            self.db[self.selectedLessonID].originalLessonNote = self.db[self.selectedLessonID].lessonNote;
            
            angular.forEach(self.db[self.selectedLessonID].studentList,function(i){
                i.originalNote = i.note;
                i.originalAttendance = i.attendance;
            });
            
            self.removeChanges();
            
        }, function(error) {
            console.log(error);
            
        });
        
    };
    
    self.removeChanges = function(){
        self.changes = {studentsChanges: [], lessonID : self.selectedLessonID};
    };
    
    self.addNewLesson = function(){
        if(!self.courseIDInput){
            alert('Devi selezionare un corso!');
            return;
        }
        if(moment(self.selectedStartingHour).isAfter(moment(self.selectedEndingHour)) || moment(self.selectedEndingHour).isSame(moment(self.selectedStartingHour)))
        {
            alert("L'ora di inizio non può coincidere o essere successiva all'ora di fine!");
            return;
        }
        
        // console.log(self.selectedStartingHour);
        
        $server.post('lessons/add',{
            startingDate : moment(self.selectedStartingHour).format('YYYY-MM-DD HH:mm:ss'),
            endingDate : moment(self.selectedEndingHour).format('YYYY-MM-DD HH:mm:ss'),
            courseID : self.courseIDInput,
            note : self.noteInput
        }).then( function(response){
            
            // console.log(response);
            
        	if(response.data.error) inform.add(response.data.description,{type: 'danger'});
        	else inform.add('Lezione aggiunta con successo!');
        	
            // Adds lesson to DB
            var keys = Object.keys(self.db);
            var lastLessonID = Number(keys[keys.length-1]) +1;
            
            self.db[lastLessonID] = {
                courseID : self.courseIDInput,
                endingDate : moment(self.selectedEndingHour),
                startingDate : moment(self.selectedStartingHour),
                lessonID : self.selectedLessonID,
                lessonNote : self.noteInput,
                originalLessonNote : self.noteInput,
                studentList : []
            };
            
            // Updates events
            
            self.events.push({lessonID: lastLessonID, title: self.db[lastLessonID].courseID, start: self.db[lastLessonID].startingDate, end: self.db[lastLessonID].endingDate, note: self.db[lastLessonID].lessonNote});
            self.updateEvents();
            
        },function(error){
            console.log(error);
        });
    };
    
    self.removeLesson = function(){
        
        var modalInstance = $modal.open({
            templateUrl: 'removeLessonModal',
            controller: 'modalController',
            resolve: {
                data: function () {
                    return self.db[self.selectedLessonID].startingDate.format('D MMMM YYYY');
                }
            }
        });
        
        modalInstance.result.
        then(function(responseFromModal) {
            if(responseFromModal) {
                $server.post('lessons/delete',{lessonID : self.selectedLessonID}).
                then(function(response){
                    
                	if(response.data.error) inform.add(response.data.description,{type:'danger'});
                	else inform.add('Lezione rimossa con successo');
                    delete self.db[self.selectedLessonID];
                    
                    // Removes from $scope.events and self.events (TODO)
                    var index = self.indexOfByKey('lessonID',self.selectedLessonID,$scope.events);
                    var indexInSelf = self.indexOfByKey('lessonID',self.selectedLessonID,self.events);
                    
                    $scope.events.splice(index,1);
                    self.events.splice(indexInSelf,1);
                    self.setDefaults();
                    
                }, function(error){
                    console.log(error);
                });
            }
        }, function() {
            
        });
    };
    
    self.setDefaults = function(){
        
        self.selectedLessonID = undefined;
        self.changes.lessonID = self.selectedLessonID;
        self.courseIDInput = undefined;
        self.noteInput = undefined;
        
    };
    
    /* MAIN */
    
    self.headings = ['Nome','Presente','Note','XP']; // headings for right panel
    
    $scope.events = [];
    $scope.eventSources = [{events: $scope.events, color: 'green'}];
    
    var date = new Date();
    
    var startingDate = moment(date).startOf('year');
    var endingDate = angular.copy(startingDate).add(365,'days');
    var startOfMonth = angular.copy(endingDate).startOf('month');
    startingDate.subtract(startingDate.weekday(),'days');
    endingDate.add(7-endingDate.weekday(),'days');
    startOfMonth.subtract(startOfMonth.weekday(),'days');
    if(endingDate.diff(startOfMonth,'days') < 42) endingDate.add(7,'days');
    
    startingDate = startingDate.format('YYYY-MM-DD HH:mm:ss');
    endingDate = endingDate.format('YYYY-MM-DD HH:mm:ss');
    
    $server.post('lessons/get',{'startingDate': startingDate, 'endingDate': endingDate}).
    then(function(response){
    	self.raw = response.data;
        self.buildDB();
    }, function(error){
        console.log(error);
    });
    
    self.init = function(){
        // var coursesList = ['studioMax','gameDesign','gameMaker'];
        // angular.forEach(coursesList,function(course){
        //     var startingHour = (course === 'studioMax' ? moment('2015-11-03 09:00','YYYY-MM-DD HH:mm') : (course === 'gameDesign' ? moment('2015-11-04 09:00','YYYY-MM-DD HH:mm') : moment('2015-11-07 09:00','YYYY-MM-DD HH:mm')));
        //     var endingHour = (course === 'studioMax' ? moment('2015-11-03 13:00','YYYY-MM-DD HH:mm') : (course === 'gameDesign' ? moment('2015-11-04 13:00','YYYY-MM-DD HH:mm') : moment('2015-11-07 13:00','YYYY-MM-DD HH:mm')));
        //     for(var i=0; i<12; i++){
        //         $server.post('lessons/add',{
        //             startingDate : startingHour.format('YYYY-MM-DD HH:mm:ss'),
        //             endingDate : endingHour.format('YYYY-MM-DD HH:mm:ss'),
        //             courseID : course,
        //             note : (i + 1) + '° Lezione'
        //         }).then(function(response){
        //             console.log(response);
        //         },function(error){
        //             console.log(error);
        //         });
        //         startingHour.add(1,'week');
        //         endingHour.add(1,'week');
        //         if(startingHour.format('DD-MM') === '08-12') {startingHour.add(1,'week'); endingHour.add(1,'week');}
        //         if(startingHour.isBetween('2015-12-21','2015-01-11')) {startingHour.add(1,'week'); endingHour.add(1,'week');}
        //     }
        // });
    };
    
    // console.log(self.db);
    
}]);