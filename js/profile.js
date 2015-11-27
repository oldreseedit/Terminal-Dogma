main.controller('profileController',['utilities','$scope','$http','$routeParams',function(utilities,$scope,$http,$routeParams){
    var self = this;
    
    self.summaryReady = true;
    self.notificationsReady = true;
    self.achievementsReady = true;
    self.rewardsReady = true;
    
    self.username = $routeParams.userID;
    
    self.xpBarTypes = function(){
        
        
        return 'success';
    };
    
    self.items = [
        {
            templateUrl: 'templates/profile-summary.php',
            ready : function(){
                return self.summaryReady;
            },
            measures: {
                width: 6,
                height: 5,
                position: {
                    x : 0,
                    y : 0
                },
                minWidth: 6,
                minHeight: 5
            }
        },
        {
            templateUrl: 'templates/profile-notifications.php',
            ready : function(){
                return self.notificationsReady;
            },
            measures: {
                width: 6,
                height: 5,
                position: {
                    x : 7,
                    y : 0
                },
                minWidth: 4
            }
        },
        {
            templateUrl: 'templates/profile-achievements.php',
            ready : function(){
                return self.achievementsReady;
            },
            measures: {
                width: 6,
                height: 5,
                position: {
                    x : 0,
                    y : 7
                },
                minWidth: 4
            }
        },
        {
            templateUrl: 'templates/profile-rewards.php',
            ready : function(){
                return self.rewardsReady;
            },
            measures: {
                width: 6,
                height: 5,
                position: {
                    x : 7,
                    y : 7
                },
                minWidth: 4
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
    
}]);