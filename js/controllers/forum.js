main.controller('forumController',['utilities','$scope','$http','$server','$routeParams','$timeout','$route','$cookies','inform','$window','$location','$anchorScroll',function(utilities,$scope,$http,$server,$routeParams,$timeout,$route,$cookies,inform,$window,$location,$anchorScroll){
    var self = this;
    self.showMessageBoard = false;
    
    self.forumNewMessage = "";
    
    /* CONFIG */
    self.username = $cookies.get('username');
    
    self.discussionTitle = "Titolo discussione";
    self.threadMessages = {
    		0: {
    			author: {
    				username: "Titto",
    				avatar: "http://www.animeemanga.it/wp-content/uploads/pokemon/charmeleon.jpg",
    				group: "admin",
    				messages: "102",
    				level: "11",
    				score: "302848283923",
    			},
    			message: {
    				text: "Benvenuti a <b>tutti</b>",
    				timestamp: "",
    			}
    		},
    		1: {
    			author: {
    				username: "Student1",
    				avatar: "",
    				group: "user",
    				messages: "12",
    				level: "4",
    				score: "382773",
    			},
    			message: {
    				text: "Ciao!",
    				timestamp: "",
    			}
    		},
    		2: {
    			author: {
    				username: "Student1",
    				avatar: "",
    				group: "user",
    				messages: "20",
    				level: "7",
    				score: "238357",
    			},
    			message: {
    				text: "Salve, prof!",
    				timestamp: "",
    			}
    		}    		
    }
    
    self.discussions = {
    		0: {
    			id: 'disc1',
    			icon: 'fa-comment',
    			title: 'Discussione 1',
    			description: 'Description 1',
    			author: 'Minnie',
    			threads: '30',
    			views: '10',
    			replies: '5',
    			participants: '2',
    			lastMessage: {
    				timestamp: "ieri",
    				author: "Chicco"
    			}
    			},
			1: {
				id: 'disc2',
    			icon: 'fa-comment',
    			title: 'Discussione 2',
    			description: 'Long description 2',
    			author: 'Pippo',
    			threads: '10',
    			views: '300',
    			replies: '210',
    			participants: '28',
    			lastMessage: {
    				timestamp: "l'altro ieri",
    				author: "Titto"
    			}
    			},
			2: {
				id: 'disc3',
    			icon: 'fa-comment',
    			title: 'Discussione 3',
    			description: 'Very very very very very very very very very very very very very very very very very long description 3',
    			author: 'Topolino',
    			threads: '1',
    			views: '1',
    			replies: '0',
    			participants: '1',
    			lastMessage: {
    				timestamp: "",
    				author: ""
    			}
    			}
    };
}]);