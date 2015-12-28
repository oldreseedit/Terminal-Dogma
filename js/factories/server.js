main.factory('$server',['$http','inform',function($http,inform){
	
	var Post = function(url, data, showInform, config)
	{
		showInform = showInform || true;
		config = config || null;
		if(config) this.promise = $http.post(url,data,config);
		else this.promise = $http.post(url,data);
		this.promise.id = url + JSON.stringify(data);
		
		return this;
	};
	
	Post.prototype.then = function(successFn,errorFn){
		successFn = successFn || null;
		errorFn = errorFn || null;
		this.promise.then(function(response){
			if(this.showInform){
				if(response.data.error) inform.add(response.data.description,{type: 'danger'});
			}
			if(response) if(successFn) successFn(response);
			
//			console.log(successFn);
		},function(error){
			
			if(!errorFn) console.log(error);
			else errorFn(error);
			
		});
		return this.promise;
	};
	
	var post = function(url,data,showInform,config){
		return new Post(url,data,showInform,config);
	}
	
	return {
		post : post
	};
	
	
}]);