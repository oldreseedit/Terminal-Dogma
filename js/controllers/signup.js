main.controller('signupController',['utilities','$scope','$server','$timeout','firstCapitalizedFilter','$cookies','$window','inform',function(utilities,$scope,$server,$timeout,capitalized,$cookies,$window,inform){
    var self = this;
    
    self.signupForm = {};
    self.disclaimerLink = "Ho letto ed accetto i <a target=\"_blank\" href=\"/disclaimer\">Termini d'uso</a>";
    
    self.submit = function(){
    	
    	if(!self.signupForm.disclaimerAccepted) inform.add('Devi necessariamente leggere ed accettare i Termini d\'uso per poterti iscrivere!',{type:'warning'});
    	
        var form = angular.element('#signupForm').scope().signupForm;
        if(form.$invalid) {
            angular.forEach(form,function(i){
                if(i) if(i.hasOwnProperty('$validate')){
                    i.$setDirty();
                    if(i.$error.usernameTaken){
                        angular.element('#signupForm'+capitalized(i.$name)).scope().errorMessageFromServer = '';
                    }
                    i.$validate();
                }
            });
            if(form.$invalid || !self.signupForm.disclaimerAccepted ) return;
        }
        
        $server.post('users/add',self.signupForm).then(function(response){
            console.log(response);
            if(response.data.error){
                angular.forEach(response.data.parameters,function(parameter){
                    var element = angular.element('#signupForm'+capitalized(parameter));
                    element.scope().errorMessageFromServer = response.data.errorCode;
                    element.scope().form[parameter].$validate();
                    element.scope().triggerIfDirtyAndInvalid();
                });
            }
            else{
                var expireDate = moment.unix(response.data.expire).toDate();
                $cookies.put('username',response.data.username,{path:'/',expires:expireDate});
                $cookies.put('token',response.data.token,{path:'/',expires:expireDate});
                $scope.$close();
                $timeout(function(){$window.location.reload();});
            }
            
            
        },function(error){
             console.log(error);
        });
        
    };
    
}]);