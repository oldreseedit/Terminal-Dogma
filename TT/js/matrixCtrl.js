tt.controller('matrixCtrl', ['$scope','$timeout', function($scope, $timeout){
	var self = this;
	
	self.m = new Matrix();
	
	self.numRows = 1;
	self.numCols = 1;
	
	self.promise;
	
	self.setSize = function()
	{
		self.m.setSize(self.numRows,self.numCols);
	}
	
	$scope.$watchCollection(
			function()
			{
				return [self.numRows,self.numCols];
			},
			function(newValues)
			{
				if($scope.reRender)
				{
					$timeout.cancel(self.promise);
					self.promise = $timeout(function(){
						$scope.reRender(self.setSize);
					},100);
				}
			}
	);
	
}]);