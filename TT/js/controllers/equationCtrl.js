tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	self.a = 1;
	self.b = 0;
	self.c = 0;

	self.sum = new mSum([new Monomial( new mNumber(3), new mNumber(2)), new mNumber(7), new Monomial( new mNumber(-2), new mNumber(1)) ]);
	self.sum2 = new mSum([new mNumber(3), new Monomial( new mNumber(1), new mNumber(2)), new mNumber(-2), new Monomial( new mNumber(2), new mNumber(1)) ]);
	
	self.e = new SecondDegreeEquation(self.sum, self.sum2);
	self.e.solve();
	
}]);