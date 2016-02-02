main.controller('modifyPreferenceController',['$scope','$uibModalInstance','$timeout','data',function($scope,$uibModalInstance,$timeout,data){
	var self = this;
	
	self.form = angular.copy(data);
	self.data = data;
	self.addressPrefixChoices = [
	                      'Via',
	                      'Viale',
	                      'Corso',
	                      'Vicolo',
	                      'Vicoletto',
	                      'Piazza',
	                      'Piazzale',
	                      'Piazzetta',
	                      'Largo',
	                      'Larghetto',
	                      'Altro'
	];
	
	$scope.initDate = moment(new Date()).subtract(18,'years').toDate();
	
	self.placeholder = function(){
		var message = 'Inserisci ';
		if(data.sex === 'm') message += 'il tuo nuovo ';
		else message += 'la tua nuova ';
		var title = data.title.charAt(0).toLowerCase() + data.title.slice(1);
		message +=  title;
		
		return message;
	}
	
	self.close = function(newValue){
		if(data.id === 'birthdate') newValue = moment(newValue).format('YYYY-MM-DD');
		if(data.id === 'address')
		{
			if(self.form.CAP < 10000 && self.form.CAP > 999) self.form.CAP = '0' +self.form.CAP;
			else if (self.form.CAP < 999) self.form.CAP = '00' + self.form.CAP;
			newValue = self.form.addressPrefix + ' ' + self.form.address + ' ' + self.form.civicNumber + ', ' + self.form.CAP;
		}
		if($scope.modifyPreferenceForm.$valid) $scope.$close(newValue);
	};	
	
}]);