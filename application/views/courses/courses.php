<div id="courses" ng-controller="coursesController as courses">
    <div class="container">
        <h3>Non i soliti corsi</h3>
        <p class="text-justify">I corsi di reSeed pongono l’accento sul lato pratico dell’insegnamento e sono improntati al “<i>learn by doing</i>”.</p>
        <p class="text-justify">Tutti i nostri corsi prevedono infatti una parte di simulazione di <i>On-The-Job Training</i>, che pone gli studenti di fronte a questioni e problemi che non vengono affrontati in altri corsi di formazione ma che sono all'ordine del giorno in un ambiente lavorativo, con l’obiettivo di ottenere un prodotto finale (videogiochi, applicazioni, siti web, etc.) concreto e competitivo.</p>
        <div id="tiles-courses" size-on-controller>
            <div class="container" ng-if="courses.tilesCoursesWidth">
                <div class="category-column" ng-repeat="category in courses.categories" ng-style="courses.spacedCategories($first)" ng-init="indexOfCategory = $index">
                    <div class="category-title" ng-style="courses.getVerticalOffsetForCategory()">
                        <div class="container">
                            <span class="middler"></span><span class="middle" ng-bind="category.name" ng-class="courses.getColours(indexOfCategory)" fittext="0.9" fittext-multiple="categories"></span>
                        </div>
                    </div>
                    <div ng-repeat="tile in category.tiles" ng-style="courses.getVerticalOffset(category)">
                        <a ng-href="#!/courses/{{tile.url}}">
                        <div class="tile" ng-class="{'routePossible':(tile.url ? true : false)}">
                            
                            <div class="square-content responsive-hide" ng-class="courses.getStyle(indexOfCategory,flipped)" ng-mouseenter="flipped=true" ng-mouseleave="flipped=false">
                                <flipper flipped="flipped" horizontal >
                                    <front>
                                        <div class="title noselect" ng-style="courses.getTileTitle()">
                                            <span class="middler"></span><span class="middle noselect clickable" ng-bind="tile.title" fittext="0.9" fittext-multiple="titles"></span>
                                        </div>
                                        <div class="content" ng-style="courses.getTileContent()">
                                            <span class="clickable" ng-class="courses.getIconClass(tile)" fittext="0.9"></span>
                                        </div>
                                    </front>
                                    <back>
                                        <div class="back-title" ng-style="courses.getTileTitle()">
                                            <span class="middler"></span><span class="middle noselect back-title-icon clickable" ng-class="courses.getIconClass(tile)" fittext fittext-multiple="backIcons"></span><span class="middle noselect clickable" ng-bind="tile.title" fittext="0.7" fittext-multiple="backTitles"></span>
                                        </div>
                                        <div class="back-content" ng-style="courses.getTileContent()">
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
</div>