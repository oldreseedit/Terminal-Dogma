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
	
	self.m = new Matrix();
	for(var i=0; i<3; i++)
	{
		self.m.pushRow([i+1,(i+1)*(i+1),(i+1)*(i+1)*(i+1)]);
	};
	$timeout(function(){
		self.numRows = 3;
		self.numCols = 3;
	},1000);
	
	
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