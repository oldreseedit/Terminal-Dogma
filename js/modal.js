main.controller('modalController',['$scope','$uibModalInstance','data',function($scope,$modalInstance,data){
    
    $scope.ok = function(){
        $modalInstance.close(true);
    };
    
    $scope.cancel = function(){
        $modalInstance.close(false);
    };
    
    $scope.data = data;
}]);