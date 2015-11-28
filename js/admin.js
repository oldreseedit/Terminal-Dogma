main.controller('adminController',['utilities','$http','$timeout','$sce','$scope','upload',function(utilities, $http, $timeout, $sce, $scope, upload){
    var self = this;
    
    self.addCourseMaterialForm = {};
    self.modifyCourseMaterialForm = {};
    self.deleteCourseMaterialForm = {};
    
    self.addNotificationForm = {};
    self.modifyNotificationForm = {};
    self.deleteNotificationForm = {};
    
    self.tabs = [
        {
            id: 'admin-courses',
            title: 'GESTIONE CORSI',
            add: {
                title : 'Aggiungi',
                content : 'Beh, qui compariranno le info per aggiungere un nuovo corso'
            },
            modify: {
                title : 'Modifica',
                content : 'Beh, qui compariranno le info per modificare un corso esistente'
            },
            remove: {
                title : 'Elimina',
                content : 'Beh, qui compariranno le info per rimuovere un corso esistente'
            }
        },
        {
            id: 'admin-news',
            title: 'GESTIONE NEWS',
            add: {
                title : 'Aggiungi',
                content : 'Beh, qui compariranno le info per aggiungere una nuova news'
            },
            modify: {
                title : 'Modifica',
                content : 'Beh, qui compariranno le info per modificare una news esistente'
            },
            remove: {
                title : 'Elimina',
                content : 'Beh, qui compariranno le info per rimuovere una news esistente'
            }
        },
        {
            id: 'admin-events',
            title: 'GESTIONE EVENTI',
            add: {
                title : 'Aggiungi',
                content : 'Beh, qui compariranno le info per aggiungere un nuovo evento'
            },
            modify: {
                title : 'Modifica',
                content : 'Beh, qui compariranno le info per modificare un evento esistente'
            },
            remove: {
                title : 'Elimina',
                content : 'Beh, qui compariranno le info per rimuovere un evento esistente'
            }
        },
        {
            id: 'admin-material',
            title: 'GESTIONE MATERIALE DEL CORSO',
            add: {
                title : 'Aggiungi',
                content : 'templates/courseMaterialAdd.php'
            },
            modify: {
                title : 'Modifica',
                content : 'templates/courseMaterialModify.php'
            },
            remove: {
                title : 'Elimina',
                content : 'templates/courseMaterialDelete.php'
            }
        },
        {
            id: 'admin-notifications',
            title: 'GESTIONE NOTIFICHE',
            add: {
                title : 'Aggiungi',
                content : 'templates/notificationsAdd.php'
            },
            modify: {
                title : 'Modifica',
                content : 'templates/notificationsModify.php'
            },
            remove: {
                title : 'Elimina',
                content : 'templates/notificationsDelete.php'
            }
        }
    ];
    
    /* For proper selection */
    self.selectedTab = -1;
    
    self.select = function(index, subIndex){
        if(self.selectedTab === index && self.selectedFunction === subIndex) self.selectedTab = -1;
        else {
            self.selectedTab = index;
            self.selectedFunction = subIndex;
        }
    };
    
    /* For proper visualization */
    self.numberOfRows = [];
    for(var i=0;i<self.tabs.length/2;i++){
        self.numberOfRows.push(i);
    }
    
    self.checkIfTabExists = function(index){
        return index < self.tabs.length;
    };
    
    self.sizes = utilities.spacedSizes(2);
    self.sizesOfButtons = utilities.spacedSizes(3);
    self.spaced = function($index){
        if($index % 2 === 0) return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.outerWidth;
        else return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.spacerWidth;
    };
    self.spacedButtons = function($index){
        if($index === 0) return "col-" + self.sizesOfButtons.elementsWidth + " offset-" + self.sizesOfButtons.outerWidth;
        else return "col-" + self.sizesOfButtons.elementsWidth + " offset-" + self.sizesOfButtons.spacerWidth;
    };
    
    
    /* METHODS FOR QUERYING CI */
    
    self.getCoursesAndLessons = function(){
        $http.post('lessons/get_lessons_by_course').then(function(response){
            // console.log(response);
            self.lessons = response.data;
            self.courses = Object.keys(self.lessons);
        },function(error){
            console.log(error);
        });
    };
    
    self.getCourses = function(){
        $http.post('lessons/get_courses').then(function(response){
            console.log(response);
            self.courses = response.data;
        },function(error){
            console.log(error);
        });
    };
    
    self.addCourseMaterial = function(){
        
        var data = self.addCourseMaterialForm;
        data.file = angular.element('[name="file"]');
        // console.log(data);
        
        upload({
          url: 'course_material/add',
          method: 'POST',
          data: data
        }).then(
          function (response) {
              
            console.log(response.data); 
          },
          function (response) {
              console.error(response); 
          }
        );
        
        // console.log(self.addCourseMaterialForm);
    };
    
    self.getMaterials = function(courseID){
        $http.post('course_material/get_all',{courseID : courseID}).then(function(response){
            // console.log(response);
            self.courseMaterials = response.data;
            
            angular.forEach(self.courseMaterials,function(m){
                var title = m.fileURI.split('/');
                title = title[title.length-1].split('.');
                title = title[0];
                title = title.replace(/_/g,' ');
                m.title = title;
            });
            
            // console.log(self.courseMaterials);
            
        },function(error){
            console.log(error);
        });
    };
    
    self.findLessonTitle = function(courseID,lessonID){
        var note = '';
        angular.forEach(self.lessons[courseID],function(lesson){
            if(lesson.lessonID === lessonID) note = lesson.lessonNote; 
        });
        return note;
    };
    
    self.modifyCourseMaterial = function(){
        
        var data = self.modifyCourseMaterialForm;
        data.file = angular.element('[name="file"]');
        // console.log(data);
        
        upload({
          url: 'course_material/modify',
          method: 'POST',
          data: data
        }).then(
          function (response) {
            console.log(response.data); 
          },
          function (response) {
              console.error(response); 
          }
        );
        
        console.log(self.modifyCourseMaterialForm);
    };
    
    self.deleteCourseMaterial = function(){
        
        $http.post('course_material/delete',self.deleteCourseMaterialForm).then(
            function(response) {
               console.log(response); 
            },
            function(error) {
                console.log(error);
            }
        );
        
        console.log(self.deleteCourseMaterialForm);
    };
    
    self.getNotifications = function(courseID){
        
        $http.post('notifications/get',{courseID: courseID}).then(function(response){
            console.log(response);
            self.notifications = response.data;
        },function(error){
            console.log(error);
        });
        
    };
    
    self.addNotification = function(){
        
        $http.post('notifications/add',self.addNotificationForm).then(function(response){
            console.log(response);
        },function(error){
            console.log(error);
        });
        
        console.log(self.addCourseMaterialForm);
    };
    
    self.modifyNotification = function(){
        
        $http.post('notifications/update',self.modifyNotificationForm).then(function(response){
            console.log(response);
        },function(error){
            console.log(error);
        });
        
        console.log(self.modifyCourseMaterialForm);
    };
    
    self.deleteNotification = function(){
        
        $http.post('notifications/delete',self.deleteNotificationForm).then(function(response){
            console.log(response);
        },function(error){
            console.log(error);
        });
        
        console.log(self.deleteCourseMaterialForm);
    };
    
    
}]);