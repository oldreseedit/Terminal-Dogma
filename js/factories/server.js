main.factory('$server',['$http','inform',function($http,inform){
	
	var Post = function(url, data, showInform, config, forceSuccessFnInvocation)
	{
		url = 'index.php/' + url;
		this.showInform = showInform === undefined ? true : showInform;
		this.config = config === undefined ? null : config;
		this.forceSuccessFnInvocation = forceSuccessFnInvocation === undefined ? false : forceSuccessFnInvocation;
		if(this.config) this.promise = $http.post(url,data,config);
		else this.promise = $http.post(url,data);
		this.promise.id = url + JSON.stringify(data);
		
		return this;
	};
	
	Post.prototype.then = function(successFn,errorFn){
		successFn = successFn || null;
		errorFn = errorFn || null;
		
		var self = this;
		
		this.promise.then(function(response){
			
			if(self.showInform){
				if(response.data.error) inform.add(response.data.description,{type: 'danger'});
			}
			
			if(response)
			{
				if(successFn && (self.forceSuccessFnInvocation || !response.data.error))
					successFn(response);
			}
			
//			console.log(successFn);
		},function(error){
			
			if(!errorFn) console.log(error);
			else errorFn(error);
			
		});
		return this.promise;
	};
	
	var post = function(url,data,showInform,config,forceSuccessFnInvocation){
		return new Post(url,data,showInform,config,forceSuccessFnInvocation);
	}
	
	return {
		post : post
	};
	
	
}]);