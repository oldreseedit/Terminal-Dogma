<div id="team" ng-controller="teamController as team">
    <div class="container">
        <h3>Chi siamo</h3>
        <hr>
        <div id="team-wrapper">
            <div class="container">
                <div ng-repeat="own in team.people" id="{{own.id}}" ng-class="team.spacedPeople($first)">
                    <div class="container">
                        <div><img class="circle-img" ng-src="{{own.urlImg}}"></img></div>
                        <div class="name"><h6 ng-bind="own.name"></h6></div>
                        <div class="team-social-buttons">
                            <div class="container">
                                <a ng-repeat="icon in own.socialNetworks" ng-href="{{icon.url}}" target="_blank">
                                    <div class="fa-stack" ng-class="team.spacedIcons($first)" ng-style="team.getFontSize()">
                                        <i class="fa fa-stack-2x fa-circle animated-class-fast" ng-class="team.getColors(icon,hover)"></i>
                                        <i class="fa fa-stack-1x animated-class-fast" ng-class="team.getColorsInverse(icon,hover)" ng-mouseover="hover=true;" ng-mouseleave="hover=false;"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>