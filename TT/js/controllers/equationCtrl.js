tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	self.e = new Polynomial([-3,2,-2]);

	if(self.e.ok())
	{
		self.formula = new Formula(self.e.tex());
		
		if(self.formula.ok())
		{
			self.e.solve();
			reRender();
		}
		
	}
	
}]);