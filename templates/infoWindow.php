<div class="container" ng-controller="infoWindowController as info">
    <h6 ng-bind="info.name"></h6>
    <h6><span class="fa fa-map-marker"></span> <span ng-bind="info.address"></span></h6>
    <p><span class="fa fa-phone"></span> <span ng-bind="info.phone"></span></p>
</div>