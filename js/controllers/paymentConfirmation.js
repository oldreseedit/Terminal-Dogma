main.controller('paymentConfirmationController',['utilities','$cookies','$http',function(utilities,$cookies,$http){
    var self = this;
    
    self.paymentConfirmed = $cookies.get('pendingPayment') === '1';
    self.choices = $cookies.getObject('choices');
    if(self.choices) var numberOfCourses = (self.choices.gameDesign === '1' ? 1 : 0) + (self.choices.gameMaker === '1' ? 1 : 0) + (self.choices.studioMax === '1' ? 1 : 0);
    self.username = $cookies.get('username');
    
    if(self.paymentConfirmed && self.choices && self.username){
        
        var courses = [];
        if(self.choices.gameDesign === '1') courses.push('gameDesign');
        if(self.choices.gameMaker === '1') courses.push('gameMaker');
        if(self.choices.studioMax === '1') courses.push('3DStudioMax');
        
        $http.post('payment_interface/add',{username: $cookies.get('username'), courseID : courses, paymentChoice : self.choices.paymentChoice, rate : self.choices.rate}).then(function(response){
            if(response.data.error){
                self.message='Sembra che ci sia stato un errore nell\'iscrizione. Contatta al più presto un amministratore all\'indirizzo e-mail info@reseed.it';
            }
            else {
                self.message='La tua iscrizione a ' + (self.choices.gameDesign === '1' ? 'Game Design' : '') + (numberOfCourses===3 ? ', ' : '') + (numberOfCourses===2 && self.choices.gameDesign === '1' ? ' e ' : '') + (self.choices.gameMaker === '1' ? 'Game Maker' : '') + (numberOfCourses>1 && self.choices.studioMax === '1' ? ' e ' : '') + (self.choices.studioMax === '1' ? '3D Studio Max' : '') + ' è stata effettuata con successo.';
                self.secondMessage='Ci vediamo alla prima lezione!';
            }
        }, function(error){
            console.log(error);
        });
    }
    else {
        if(!self.username){
            self.message='Devi essere loggato per accedere a questa pagina.';
        }
        else{
            self.message='Sembra che tu stia cercando di fare il furbetto.';
            self.secondMessage='Ma noi siamo più furbi di te!';
        }
    }
    
    $cookies.remove('pendingPayment',{path:'/'});
    $cookies.remove('choices',{path:'/'});
    
}]);