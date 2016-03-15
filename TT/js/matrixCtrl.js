tt.controller('matrixCtrl', ['$scope','$timeout', function($scope, $timeout){
	var self = this;
	
	self.m = new Matrix();
	
	self.numRows = 1;
	self.numCols = 1;
	
	$scope.$watchCollection(
			function()
			{
				return [self.numRows,self.numCols];
			},
			function(newValues)
			{
				self.m.setSize(newValues[0],newValues[1]);
				if($scope.reRender)
				{
					console.log($scope.reRender());
					$scope.reRender();
				}
			}
	);
	
}]);