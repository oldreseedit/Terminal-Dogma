main.controller('preferencesController',['$server','$scope','$uibModal','inform',function($server,$scope,$uibModal,inform){
	var self = this;
	
	self.nonDisplayedProperties = ['advertisementProvenance','currentExp','previousExp','profilePicture'];
	self.nonModifiableProperties = ['userID', 'registrationDate', 'level'];
	
	self.getNameOf = function(key)
	{
		var name;
		switch(key){
			case 'address':
				name = 'Indirizzo';
				break;
			case 'birthdate':
				name = 'Data di nascita';
				break;
			case 'educationLevel':
				name = 'Grado di studi';
				break;
			case 'email':
				name = 'Email';
				break;
			case 'level':
				name = 'Livello';
				break;
			case 'mobileNumber':
				name = 'Numero di cellulare';
				break;
			case 'name':
				name = 'Nome';
				break;
			case 'phoneNumber':
				name = 'Numero di telefono';
				break;
			case 'profession':
				name = 'Professione';
				break;
//			case 'profilePicture':
//				name = 'Avatar';
//				break;
			case 'schoolName':
				name = 'Scuola';
				break;
			case 'registrationDate':
				name = 'ReSeeder dal';
				break;
			case 'surname':
				name = 'Cognome';
				break;
			case 'userID':
				name = 'Username';
				break;
			default:
				name = '';
				break;
		}
		return name;
	};
	
	self.isModifiable = function(key){
		var modifiable = true;
		for(var i=0; i<self.nonModifiableProperties.length; i++)
		{
			if(self.nonModifiableProperties[i] === key) modifiable = false;
		}
		return modifiable;
	};
	
	self.whichTypeIs = function(id)
	{
		switch(id){
			case 'email':
				return 'Email';
			case 'name':
				return 'Text';
			case 'surname':
				return 'Text';
			case 'schoolName':
				return 'Text';
			case 'address':
				return 'Text';
			case 'phoneNumber':
				return 'Text';
			case 'mobileNumber':
				return 'Text';
			case 'birthdate':
				return 'Date';
			case 'profession':
				return 'Text';
			case 'educationLevel':
				return 'Select';
		}
	};
	
	self.sexOf = function(key)
	{
		switch(key){
			case 'email':
				return 'f';
			case 'birthdate':
				return 'f';
			case 'profession':
				return 'f';
			case 'schoolName':
				return 'f';
			default:
				return 'm';
		}
	}
	
	self.getAjax = $server.post('/users/get',{username: $scope.username}).then(
			function(response){
				var data = response.data;
				var keys = Object.keys(data);
				self.data = [];
				angular.forEach(keys,function(key){
					var display = true;
					for(var i=0; i<self.nonDisplayedProperties.length; i++)
					{
						if(self.nonDisplayedProperties[i] === key) display = false;
					}
					if(display) self.data.push({title: self.getNameOf(key), value: data[key], id: key, sex: self.sexOf(key)});
				});
				self.oldData = angular.copy(self.data);
			}
	);
	
	self.getChoices = function(id)
	{
		if(id === 'educationLevel') return ['Scuola Primaria','Scuola Secondaria Inferiore','Scuola Secondaria Superiore','Laurea Triennale','Laurea Magistrale','Dottorato di Ricerca','Altro']
	};
	
	self.modify = function(data)
	{
		var typeOfData = self.whichTypeIs(data.id);
		var resolveData = angular.copy(data);
		if(typeOfData === 'Select') resolveData.choices = self.getChoices(data.id);
		
		var modalInstance = $uibModal.open({
			backdrop: false,
			controller: 'modifyPreferenceController as preference',
			resolve: {
				data: resolveData 
			},
			templateUrl : 'templates/modifyPreference' + typeOfData + '.php'
		});
		
		modalInstance.result.then(
				function(newValue)
				{
//					console.log(newValue);
					data.value = newValue;
				},
				function(dismiss)
				{
					// Don't touch anything.
				}
		);
	};
	
	self.set = function()
	{
		var data = {username: $scope.username};
		for(var i = 0; i < self.data.length; i++)
		{
			if(self.data[i].value !== self.oldData[i].value) data[self.data[i].id] = self.data[i].value;
		}
		
		self.setAjax = $server.post('/userinfo/update',data).then(
			function(response)
			{
				for(var i=0; i<response.data.length; i++)
				{
					if(response.data[i].error) inform.add(response.data[i].description,{type:'danger'});
    				else inform.add(response.data[i].description);
				}
			}
		);
	}
	
	
	
}]);