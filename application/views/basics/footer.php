<div id="footer" ng-controller="footerController as footer">
    <div class="container">
        <div id="social-icons">
            <div class="container">
                <a ng-repeat="icon in footer.icons" ng-href="{{icon.url}}" target="_blank">
                    <div class="fa-stack fa-2x" ng-class="footer.spacedIcons($first)">
                        <i class="fa fa-stack-2x fa-circle animated-class-fast" ng-class="footer.getColors(icon,hover)"></i>
                        <i class="fa fa-stack-1x animated-class-fast" ng-class="footer.getColorsInverse(icon,hover)" ng-mouseover="hover=true;" ng-mouseleave="hover=false;"></i>
                    </div>
                </a>
            </div>
        </div>
        <div id="tabs">
            <div class="container">
                <div ng-repeat="tab in footer.tabs" ng-class="footer.spaced($first)"><a ng-href="/{{tab.id}}" id="{{tab.id}}" ng-bind="tab.content" class="animated-class-fastest"></a></div>
            </div>
        </div>
        <div id="footer-logo">
            <div class="container outermiddler">
                <div class="innermiddler">
                    <img src="imgs/logo.png"></img>
                </div>
            </div>
        </div>
        <!--<div id="commercial-info">-->
        <!--    <p>reSeed S.N.C.</p>-->
        <!--    <p>P.Iva 44534534536445343</p>-->
        <!--</div>-->
    </div>
</div>