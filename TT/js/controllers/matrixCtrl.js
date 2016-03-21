tt.controller('matrixCtrl', ['$scope','$timeout', function($scope, $timeout){
	var self = this;
	
//	self.m = new Matrix();
//	
//	self.numRows = 1;
//	self.numCols = 1;
//	
//	self.promise;
//	
	self.update = function()
	{
//		self.m.setSize(self.numRows,self.numCols);
//		self.determinant = self.m.determinant();
	}
	
	self.A = new Matrix();
	for(var i=0; i<4; i++)
	{
		self.A.pushRow([i+1,Math.pow(i+1,2),Math.pow(i+1,3), Math.pow(i+1,4)]);
	};
	
	self.B = new Matrix();
	for(var i=1; i<5; i++)
	{
		self.B.pushRow([ i-1,Math.pow(i+1,2), Math.pow(i-1,3), Math.pow(i-1,4) ]);
	}
	
	self.C = self.A.plus(self.B);
	
	self.D = self.A.times(self.B);
	
//	$timeout(function(){
////		self.numRows = 4;
////		self.numCols = 4;
//		$scope.reRender();
//	},2000);
	
	
//	$scope.$watchCollection(
//			function()
//			{
//				return [self.numRows,self.numCols];
//			},
//			function(newValues)
//			{
//				if($scope.reRender)
//				{
//					$timeout.cancel(self.promise);
//					self.promise = $timeout(function(){
//						$scope.reRender(self.update);
//					},100);
//				}
//			}
//	);
	
}]);