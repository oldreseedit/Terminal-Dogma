tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	self.fn = new mFunction(new mSum([new Monomial(new mNumber(1),new mNumber(5)), new Monomial(new mNumber(-2),new mNumber(3)), new Monomial(new mNumber(1),new mNumber(1))]));
	
	console.log(self.fn, self.fn.toTex());
	
	var calculator = Desmos.Calculator($('#graph'),{
		keypad: false,
		expressions: false,
		settingsMenu: false,
		border: false		
	});
	calculator.setExpression({id:'function', latex:self.fn.toTex()});
	
	
}]);