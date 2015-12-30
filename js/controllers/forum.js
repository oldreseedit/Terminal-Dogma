main.controller('forumController',['utilities','$scope','$http','$server','$routeParams','$timeout','$route','$cookies','inform','$window','$location','$anchorScroll',function(utilities,$scope,$http,$server,$routeParams,$timeout,$route,$cookies,inform,$window,$location,$anchorScroll){
    var self = this;
    self.showMessageBoard = false;
    
    self.forumNewMessage = "";
    
    /* CONFIG */
    self.username = $cookies.get('username');
    
    self.discussions = {
    		0: {
    			id: 'disc1',
    			icon: 'fa-comment',
    			title: 'Discussione 1',
    			description: 'Description 1',
    			threads: '30',
    			views: '10',
    			replies: '5',
    			participants: '2',
    			},
			1: {
				id: 'disc2',
    			icon: 'fa-comment',
    			title: 'Discussione 2',
    			description: 'Long description 2',
    			threads: '10',
    			views: '300',
    			replies: '210',
    			participants: '28',
    			},
			2: {
				id: 'disc3',
    			icon: 'fa-comment',
    			title: 'Discussione 3',
    			description: 'Very very very very very very very very very very very very very very very very very long description 3',
    			threads: '1',
    			views: '1',
    			replies: '1',
    			participants: '1',
    			}
    };
}]);