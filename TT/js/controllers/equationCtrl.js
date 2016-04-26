tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
	var calculator = Desmos.Calculator($('#graph'),{
		keypad: false,
		expressions: false,
		settingsMenu: false,
		border: false
	});
	calculator.setExpression({id:'function', latex: 'x^2-2x-3'});
	
	
}]);