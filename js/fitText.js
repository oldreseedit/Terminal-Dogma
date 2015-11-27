/* ng-FitText.js v3.3.3
 * https://github.com/patrickmarabeas/ng-FitText.js
 *
 * Original jQuery project: https://github.com/davatron5000/FitText.js
 *
 * Copyright 2015, Patrick Marabeas http://marabeas.io
 * Released under the MIT license
 * http://opensource.org/licenses/mit-license.php
 *
 * Date: 06/05/2015
 */

(function(window, document, angular) {

  angular.module('ngFitText', [])

    .directive('fittext', ['$timeout', '$window', function($timeout, config, fitTextConfig, $window) {
      return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {
          element[0].style.display = "none";
  
          var getStep = function(group) {
            var elementWidth = 0;
            var elementHeight = 0;
            
            // console.log(group);
            
            for(var i=0; i<group.length; i++){
              var item = group[i] instanceof jQuery ? group[i][0] : group[i];
              item.style.display = 'inline-block';
              item.style.fontSize = '10px';
              elementHeight = Math.max(item.offsetHeight, elementHeight);
              elementWidth += item.offsetWidth; 
            }
            
            var heightStep = elementHeight/10;
            var widthStep = elementWidth/10;
            
            // console.log(heightStep,widthStep);
            
            return {
              widthStep : widthStep,
              heightStep : heightStep
            };
          };

          var resizer = function() {
            
            var fss = [];
            var item = {};
            // var fssNames = []; // Debug
            
            var multiple = (element.attr('fittext-multiple') ? $('[fittext-multiple="' + element.attr('fittext-multiple') + '"]') : [element]);
            
            // console.log('multiple:',multiple);
            
            for(var i=0; i<multiple.length; i++)
            {
              var group = ($(multiple[i]).attr('fittext-group') ? $('[fittext-group="'+$(multiple[i]).attr('fittext-group')+'"]') : [multiple[i]]);
              
              // console.log('group:',group);
              // console.log(group[0] instanceof jQuery);
              
              var step = getStep(group);
              
              // console.log('step:', step);
              
              /* TO ASK: group can be NOT adjacent? */
              
              var parent = (group[0] instanceof jQuery ? group[0][0].parentNode : group[0].parentNode);
              if(attrs.fittextReference) parent = angular.element('#'+attrs.fittextReference)[0];
              
              // console.log('parent:',parent);
              
              // console.log(attrs.fittextExclusive);
              
              fss[i] = Math.min(parent.offsetWidth/step.widthStep, parent.offsetHeight/step.heightStep);
              
              if(attrs.fittextExclusive === 'width') fss[i] = parent.offsetWidth/step.widthStep;
              if(attrs.fittextExclusive === 'height') fss[i] = parent.offsetHeight/step.heightStep;
              // console.log(parent, parent.offsetWidth, step.widthStep, fss[i]);
              
              if(fss.length === 1) {
                for(var j=0; j<group.length; j++){
                  item = group[j] instanceof jQuery ? group[j][0] : group[j];
                  item.style.fontSize = fss[0]*0.95*compressor + 'px';
                }
              }
              
              // fssNames[i] = [parent, fss[i]]; // Debug
            }
            
            // console.log('fss:', fss);
            // if(fssNames.length > 0) console.log(fssNames);
            
            var fs = Math.min.apply(Math,fss);
            
            // console.log('fs:',fs);
            
            for(i=0; i<multiple.length; i++){
              item = multiple[i] instanceof jQuery ? multiple[i][0] : multiple[i];
              item.style.fontSize = fs*0.95*compressor + 'px';
            }
            
          };
          
          var compressor = attrs.fittext || 1;
          
          $timeout(function(){resizer();});

          scope.$watch(
            function(){
              return attrs.ngModel;
            },
            function() {
              $timeout(function(){resizer();});
            }
          );
        
          scope.$watch(
            function(){
              return element[0].parentNode.offsetHeight;
            },
            function() {
              $timeout(function(){resizer();});
            }
          );
          
          
          scope.$watch(
            function(){
              return element[0].parentNode.offsetWidth;
            },
            function() {
              $timeout(function(){resizer();});
            }
          );
        }
      };
    }])
    
    .directive('fittextLong', ['$timeout', '$window', function($timeout, $window) {
      return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {
            
          var resizer = function(){
            
            var fss = [];
            
            var multiple = (element.attr('fittext-long-multiple') ? $('[fittext-long-multiple="' + element.attr('fittext-long-multiple') + '"]') : [element]);
            
            // console.log(multiple);
            
            for(var i=0; i<multiple.length; i++)
            {
              var el = ( multiple[i] instanceof jQuery ? multiple[i][0] : multiple[i] );
              var parentHeight = el.parentNode.offsetHeight;
              
              // console.log(el);
              
              var j=1;
              el.style.fontSize = j+'px';
              
              while(el.offsetHeight < parentHeight){
                // console.log(j,el.offsetHeight,parentHeight);
                el.style.fontSize = j+'px';
                j++;
              }
              
              fss[i] = j-2;
            }
            // console.log(fss);
            var fs = Math.min.apply(Math,fss);
            for(i=0;i<multiple.length;i++){
              el = ( multiple[i] instanceof jQuery ? multiple[i][0] : multiple[i]);
              // console.log(fs);
              // console.log(el);
              // console.log(el.style.fontSize);
              el.style.fontSize = (fs*0.95*(attrs.fittextLong || 1))+'px';
            }
          };
          
          $timeout(function(){resizer();});

          scope.$watch(
            function(){
              return attrs.ngModel;
            },
            function() {
              $timeout(function(){resizer();});
            }
          );
        
          scope.$watch(
            function(){
              return element[0].parentNode.offsetHeight;
            },
            function() {
              $timeout(function(){resizer();});
            }
          );
          
          scope.$watch(
            function(){
              return element[0].parentNode.offsetWidth;
            },
            function() {
              $timeout(function(){resizer();});
            }
          );
        }
      };
    }]);

})(window, document, angular);