<div id="activities" ng-controller="activitiesController as activities">
    <div class="container">
        <h3>Servizi</h3>
        <div id="tiles-activities" size-on-controller>
            <div class="container" ng-if="activities.tilesActivitiesWidth">
				<div ng-repeat="tile in activities.tiles" class="float" ng-init="index=$index" ng-style="activities.spacedTiles(index)">
                	<a ng-href="/activities/{{tile.url}}">
	                    <div class="tile" ng-class="{'routePossible':(tile.url ? true : false)}">
	                    	<div class="square-content responsive-hide" ng-class="activities.getStyle(index,flipped)" ng-mouseenter="flipped=true" ng-mouseleave="flipped=false">
	                        	<flipper flipped="flipped" horizontal >
	                            	<front>
	                                	<div class="title noselect" ng-style="activities.getTileTitle()">
	                                    	<span class="middler"></span><span class="middle noselect clickable" ng-bind="tile.title" fittext="0.9" fittext-multiple="titles"></span>
	                                    </div>
	                                  	<div class="content" ng-style="activities.getTileContent()">
	                                     	<span class="middler"></span><span class="middle clickable" ng-class="activities.getIconClass(tile)" fittext="0.9"></span>
										</div>
	                                </front>
									<back>
	                                	<div class="back-title" ng-style="activities.getTileTitle()">
	                                    	<span class="middler"></span><span class="middle noselect back-title-icon clickable" ng-class="activities.getIconClass(tile)" fittext fittext-multiple="backIcons"></span><span class="middle noselect clickable" ng-bind="tile.title" fittext="0.7" fittext-multiple="backTitles"></span>
										</div>
	                                 	<div class="back-content" ng-style="activities.getTileContent()">
	                                    	<span class="noselect clickable" ng-bind="tile.contentFlipped" fittext-long="0.9"></span>
										</div>
									</back>
								</flipper>
							</div>
						</div>
					</a>
                </div>
            </div>
        </div>
    </div>
</div>