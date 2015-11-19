main.controller('signinController',['utilities','$scope','$http','$timeout','firstCapitalizedFilter','$cookies','$window',function(utilities,$scope,$http,$timeout,capitalized,$cookies,$window){
    var self = this;
    
    self.signinForm = {};
    
    self.submit = function(){
        var form = angular.element('#signinForm').scope().signinForm;
        if(form.$invalid) {
            angular.forEach(form,function(i){
                if(i) if(i.hasOwnProperty('$validate')){
                    i.$setDirty();
                    if(i.$error.loginError){
                        angular.element('#signinForm'+capitalized(i.$name)).scope().errorMessageFromServer = '';
                    }
                    i.$validate();
                }
            });
            if(form.$invalid) return;
        }
        
        $http.post('users/login',self.signinForm).then(function(response){
            // console.log(response);
            if(response.data.error){
                angular.forEach(response.data.parameters,function(parameter){
                    var element = angular.element('#signinForm'+capitalized(parameter));
                    element.scope().errorMessageFromServer = response.data.errorCode;
                    element.scope().form[parameter].$validate();
                    if(parameter === 'password') element.scope().triggerIfDirtyAndInvalid();
                    element.scope().errorMessageFromServer = '';
                });
            }
            else{
                var expireDate = moment.unix(response.data.expire).toDate();
                $cookies.put('username',response.data.username,{path:'/',expires:expireDate});
                $cookies.put('token',response.data.token,{path:'/',expires:expireDate});
                $scope.$dismiss();
                $timeout(function(){$window.location.reload();});
            }
            
        },function(error){
            console.log(error);
        });
        
    };
    
}]);