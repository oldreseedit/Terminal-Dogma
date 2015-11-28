main.controller('profileController',['utilities','$scope','$http','$routeParams','$route',function(utilities,$scope,$http,$routeParams,$route){
    var self = this;
    
    self.username = $routeParams.userID;
    self.xpBarTypes = function(){        
        return 'success';
    };
    self.notifications = $route.current.locals.notifications;
//    self.achievementsAndRewards = $route.current.local.achievementsAndRewards;
//    console.log(self.achievementsAndRewards);
    
    $scope.gridsterItems = [
        {
        	title: 'Sommario',
            bgColour: 'bg-light-olive',
            templateUrl: 'templates/profile-summary.php',
            measures: {
                width: 6,
                height: 1,
                position: {
                    x : 0,
                    y : 0
                }
            }
        },
        {
        	title: 'Notifiche',
            bgColour: 'bg-light-lawn',
            templateUrl: 'templates/profile-notifications.php',
            measures: {
                width: 6,
                height: 1,
                position: {
                    x : 7,
                    y : 0
                }
            }
        },
        {
        	title: 'Achievements',
            bgColour: 'bg-light-green',
            templateUrl: 'templates/profile-achievements.php',
            measures: {
                width: 6,
                height: 1,
                position: {
                    x : 0,
                    y : 7
                }
            }
        },
        {
        	title: 'Rewards',
            bgColour: 'bg-light-leaf',
            templateUrl: 'templates/profile-rewards.php',
            measures: {
                width: 6,
                height: 1,
                position: {
                    x : 7,
                    y : 7
                }
            }
        }
    ];
    
    self.customItemMap = {
        sizeX: 'item.measures.width',
        sizeY: 'item.measures.height',
        row: 'item.measures.position.y',
        col: 'item.measures.position.x',
        minSizeX: 'item.measures.minWidth',
        minSizeY: 'item.measures.minHeight'
    };
    
    /* METHODS */
    
    self.getTitleOfNotification = function(notification)
    {
    	var title = notification.courseID || 'reSeed';
    	return title;
    };
    
    
    
}]);