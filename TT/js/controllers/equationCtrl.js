tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	self.e = new Polynomial([1,3,2,1]);

	self.formula = new Formula(self.e.tex());
	
	self.e.solve();
	
}]);