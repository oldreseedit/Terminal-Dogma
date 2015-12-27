main.controller('contactsController',['utilities','uiGmapGoogleMapApi','$timeout','$server','inform',function(utilities,uiGmapGoogleMapApi,$timeout,$server,inform){
    var self = this;
    
    self.sizes = utilities.spacedSizes(2);
    
    self.getClass = function($index){
        if(imOnResponsive) return "col-100";
        if($index % 2 === 0) return ["col-" + self.sizes.elementsWidth, "offset-" + self.sizes.outerWidth];
        else return ["col-" + self.sizes.elementsWidth, "offset-" + self.sizes.spacerWidth];
    };
    
    self.contactsForm = {};
    
    self.infoUrl = 'templates/infoWindow.php';
    
    self.map = {
        center: {
            latitude: 41.924125,
            longitude: 12.57059
        }, 
        zoom: 17,
        options: {
            // draggable: false,
            // keyboardShortcuts: false,
            // scrollwheel: false,
            // scaleControl: false,
            // zoomControl: false,
            // streetViewControl: false,
            // panControl: false
        },
        control: {},
        refresh: function(){
            self.map.refresh(self.map.center);
        }
    };
    
    self.marker = {
        id : 'reseedOffice',
        coords : {
            latitude: 41.924125,
            longitude: 12.57059
        },
        options : {
            place: {
                location : {
                    lat: 41.924125,
                    lng: 12.57059
                },
                placeId: 'ChIJuQerCpxjLxMRWlTiSXZlTcA'
            }
        }
    };
    
    self.mapIsReady = false;
    
    uiGmapGoogleMapApi.then(function(maps){
        $timeout(function(){self.mapIsReady = true;});
    });
    
    self.submit = function(){
        var form = angular.element('#contactForm').scope().contactForm;
        if(form.$invalid) return;
        
        var toServer = {};
        angular.copy(self.contactsForm, toServer);
        toServer.message = 'Messaggio inviato da: <b>' + toServer.name + '</b>.<br /><br /><i>' + toServer.message + '</i><br /><br />Rispondi a: ' + toServer.from; 
        
        self.mailAjax = $server.post('mailer/send_mail',toServer).then(function(response){
        	inform.add('E-mail inviata correttamente!');
        });
        
    };
    
    self.closeAlertMessage = function(){
        self.alertMessage = '';
        self.alertType = '';
    };
    
}]);