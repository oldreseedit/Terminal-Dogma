<div id="presentation" ng-controller="presentationController as presentation">
    <div class="container">
        <h3>In evidenza</h3>
        <div ng-include="'templates/spotlights.php'"></div>
        
        <h3>Come funziona</h3>
        <div ng-include="'templates/introduction.php'"></div>
        <h3>Esperienza</h3>
        <div ng-include="'templates/experience.php'"></div>
        <h3>News & Eventi</h3>
        <div ng-include="'templates/news.php'"></div>
    </div>
</div>