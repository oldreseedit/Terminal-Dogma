tt.controller('equationCtrl',['$scope',function($scope){
	var self = this;
	
//	self.n = new mNumber(30);
//	self.n2 = new mNumber(42);
	self.n = new Fraction(new mNumber(4), new mNumber(3));
	self.n2 = new Fraction(new mNumber(3), new mNumber(2));
//	self.n2 = new Fraction(new mNumber(3), new mNumber(3));
//	self.r = new Root(4,2,3);
//	self.r2 = new Root(2,2,3);
//	self.r3 = new Root(2,3);
//	self.n = new Power(new mNumber(2), new mNumber(3), new mNumber(4));
//	self.n2 = new Power(new mNumber(2),new mNumber(4),new mNumber(3));
	
	console.log(self.n);
	console.log(self.n2);
	console.log(self.n.inverse());
//	console.log(self.n.gcd(self.n2));
//	console.log(self.n.mcm(self.n2));
	console.log(self.n.plus(self.n2));
	console.log(self.n.minus(self.n2));
	console.log(self.n.dot(self.n2));
	console.log(self.n.dot(self.n2).simplify());
	
}]);