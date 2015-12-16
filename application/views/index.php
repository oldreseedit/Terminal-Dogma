<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
    
<head>
    <!-- HEAD DECLARATION -->
    <?php include_once("basics/head.php"); ?>
</head>

<body ng-app="Main">
    <!-- Google Analytics Snippet -->
    <?php include_once("basics/analyticstracking.php"); ?>
    
    <div class="container">
        
        <?php include_once("basics/navbar.php"); ?>
        
        <div class="mini-header" ng-if="miniHeader()">
            <div class="container">
                <img src="imgs/mini-header.jpg" />
            </div>
        </div>
        
        <div id="main" ng-view>
            
        </div>
        
        <?php include_once("basics/footer.php"); ?>
    </div>
    
    <div inform class="inform-shadow inform-fixed inform-center inform-animate"></div>
</body>
</html>