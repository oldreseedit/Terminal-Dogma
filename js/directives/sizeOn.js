/* for retrieving sizes - as attribute */
main.directive('sizeOnController', ['$timeout','$window','$document',function($timeout,$window,$document){
    return {
        restrict: 'A',
        link: function($scope, $element, $attrs) {
            var controller = $element.controller();
            
            var writer = function(){
                
                $timeout(function(){
	                controller[$attrs.$normalize($attrs.id) +'Width'] = $element.prop('offsetWidth');
	                controller[$attrs.$normalize($attrs.id) +'Height'] = $element.prop('offsetHeight');     
                });       	
            };
            
        	writer();


            $scope.$watch(
                function(scope){
                    return $element.prop('offsetHeight');
                }, 
                function(newValue,oldValue,scope){
                    writer();
                }
            );
            
            $scope.$watch(
                function(scope){
                    return $element.prop('offsetWidth');
                }, 
                function(newValue,oldValue,scope){
                    writer();
                }
            );
            
            $(window).resize(function(){
            	writer();
            });

            
        }
    };
}]);

main.directive('sizeOnScope', ['$timeout','$window','$document',function($timeout,$window,$document){
    return {
        restrict: 'A',
        link: function($scope, $element, $attrs) {
            
            var writer = function(){
            
                $timeout(function(){
                    $scope[$attrs.$normalize($attrs.id) +'Width'] = $element.prop('offsetWidth');
                    $scope[$attrs.$normalize($attrs.id) +'Height'] = $element.prop('offsetHeight');
                    $scope['sizesReady'] = true;
                });
                
            };
            
            writer();
            
            $scope.$watch(
                function(scope){
                    return $element.prop('offsetHeight');
                }, 
                function(newValue,oldValue,scope){
                    writer();
                }
            );
            
            $scope.$watch(
                function(scope){
                    return $element.prop('offsetWidth');
                }, 
                function(newValue,oldValue,scope){
                    writer();
                }
            );

            $(window).resize(function(){
                writer();
            });
        }
    };
}]);