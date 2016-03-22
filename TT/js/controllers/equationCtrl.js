tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	self.e = new Polynomial();

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