main.controller('signupController',['utilities','$scope','$http','$timeout','firstCapitalizedFilter','$cookies','$window',function(utilities,$scope,$http,$timeout,capitalized,$cookies,$window){
    var self = this;
    
    self.signupForm = {};
    
    self.submit = function(){
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
            if(form.$invalid) return;
        }
        
        $http.post('users/add',self.signupForm).then(function(response){
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