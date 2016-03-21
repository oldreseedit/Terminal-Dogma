tt.controller('equationCtrl',[function(){
	var self = this;
	
	self.e = new Equation([1,2,1,3,5]);

	if(self.e.ok())
	{
		self.formula = new Formula(self.e.tex());
	}
	
}]);