<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#"  ng-app="Main">
    
<head>
    <!-- HEAD DECLARATION -->
    <?php include_once("basics/head.php"); ?>
</head>

<body>
    <!-- Google Analytics Snippet -->
    <ng-include src="'templates/analyticstracking.php'"></ng-include>
        
    <ng-include src="'templates/navbar.php'"></ng-include>
    
    <div class="container">
        

        <div id="header" ng-if="!miniHeader()"></div>
        <div class="mini-header" ng-if="miniHeader()">
            <div class="container">
                <img src="imgs/mini-header.png" />
            </div>
        </div>
<!-- 				<h3 class="text-center" style="margin-top:1em">In evidenza</h3> -->
<!-- 		        <div ng-include="'templates/spotlights.php'"></div> -->
                
        <div id="main" ng-view>
        
            
        </div>
    </div>
        
    <ng-include src="'templates/footer.php'"></ng-include>
    
    <div inform class="inform-shadow inform-fixed inform-center inform-animate"></div>
</body>
</html>