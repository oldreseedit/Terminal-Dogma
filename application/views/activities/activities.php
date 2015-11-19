<div id="activities" ng-controller="activitiesController as activities" size-on-controller>
    <div class="container">
        <h3>Servizi</h3>
        <p>Facciamo un botto di cose, mica solo corsi. Tipo le attività, e le cose. E le attività per i più piccoli. E le cose per i meno piccoli. E i piccoli per le meno attività cose. No aspetta.</p>
        <div id="tiles-activities">
            <div ng-repeat="tile in activities.tiles" ng-class="activities.spacedTiles($index)" class="tile-wrapper" ng-init="indexOfTile = $index">
                <a ng-href="{{tile.url}}">
                    <div class="tile">
                        <div class="square-content responsive-hide" ng-class="activities.getStyle(indexOfTile,flipped)" ng-mouseenter="flipped=true" ng-mouseleave="flipped=false">
                            <flipper flipped="flipped" horizontal >
                                <front>
                                    <div class="title" ng-style="activities.getTileTitle()">
                                        <div class="container">
                                            <span ng-bind="tile.title" fittext-multiple fittext-set="titles"></span>
                                        </div>
                                    </div>
                                    <div class="content" ng-style="activities.getTileContent()">
                                        <span ng-class="activities.getIconClass(tile)" fittext="0.9"></span>
                                    </div>
                                </front>
                                <back>
                                    <div class="back-symbol" ng-style="activities.getTileTitle()">
                                        <div class="container">
                                            <span ng-class="activities.getIconClass(tile)" fittext></span>
                                        </div>
                                    </div>
                                    <div class="back-title" ng-style="activities.getTileTitle()">
                                        <div class="container">
                                            <span class="middler"></span><span ng-bind="tile.title" fittext></span>
                                        </div>
                                    </div>
                                    <div class="back-content" ng-style="activities.getTileContent()">
                                        <div class="container">
                                            <span ng-bind="tile.contentFlipped"></span>
                                        </div>
                                    </div>
                                </back>
                            </flipper>
                        </div>
                        
                        <!-- Responsive Only -->
                        
                        <div class="square-content responsive-only" ng-class="activities.getStyle(tile,false)">
                            <div class="title" ng-style="activities.getTileTitle()">
                                <div class="container">
                                    <span ng-bind="tile.title" fittext-multiple fittext-set="responsive-titles"></span>
                                </div>
                                <div class="content" ng-style="activities.getTileContent()">
                                    <span ng-class="activities.getIconClass(tile)" fittext="0.9"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!--<div id="tiles-activities">-->
        <!--    <div class="container">-->
        <!--        <div ng-repeat="tile in activities.tiles" ng-class="activities.spacedTiles($index)" class="tile-wrapper">-->
        <!--            <div class="tile">-->
        <!--                <div class="square-content" ng-class="activities.getStyle(tile,flipped)" ng-mouseenter="flipped=true" ng-mouseleave="flipped=false">-->
        <!--                    <flipper flipped="flipped" horizontal>-->
        <!--                        <front>-->
        <!--                            <div class="title" id="activities-title" size-on-controller><p ng-bind="tile.title"></p></div>-->
        <!--                            <div class="content">-->
        <!--                                <span ng-class="activities.getIconClass(tile)" ng-style="activities.setFontSizeForIcon()"></span>-->
        <!--                            </div>-->
        <!--                        </front>-->
        <!--                        <back>-->
        <!--                            <div class="title">-->
        <!--                                <span class="middler" ng-class="activities.getIconClass(tile)" ng-style="activities.setFontSize(0.25)"></span>-->
        <!--                                <span class="middle inner-title" ng-bind="tile.title"></span>-->
        <!--                            </div>-->
        <!--                            <div class="content">-->
        <!--                                <span ng-bind="tile.contentFlipped"></span>-->
        <!--                            </div>-->
        <!--                        </back>-->
        <!--                    </flipper>-->
                            
                            
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
</div>