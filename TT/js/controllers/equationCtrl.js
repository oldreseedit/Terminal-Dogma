tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	self.e = new Polynomial([3,4,1]);

	self.formula = new Formula(self.e.tex());
	
	self.e.solve();
	
}]);