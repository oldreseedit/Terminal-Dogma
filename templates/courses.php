<div id="courses" ng-controller="coursesController as courses">

        <h3>Non i soliti corsi</h3>
        <p class="text-justify">I corsi di reSeed pongono l’accento sul lato pratico dell’insegnamento e sono improntati al “<i>learn by doing</i>”.</p>
        <p class="text-justify">Tutti i nostri corsi prevedono infatti una parte di simulazione di <i>On-The-Job Training</i>, che pone gli studenti di fronte a questioni e problemi che non vengono affrontati in altri corsi di formazione ma che sono all'ordine del giorno in un ambiente lavorativo, con l’obiettivo di ottenere un prodotto finale (videogiochi, applicazioni, siti web, etc.) concreto e competitivo.</p>
        
<!-- 		<div spinner="courses.coursesData">   -->
<!-- 		<spinner-place class="fa-4x"></spinner-place> -->
<!-- 		<spinner-final> -->
			<div id="courses-responsive">
				<div id="courses-bookmarks" ng-if="imOnResponsive" bookmarks>
					<bookmark-category ng-repeat="category in courses.categories" ng-init="indexOfCategory = $index">
					</bookmark-category>
				</div>
			</div>
			
	        <div id="tiles-courses" size-on-controller ng-if="!imOnResponsive">
	            <div class="container" ng-if="courses.tilesCoursesWidth">
	                <div class="category-column" ng-repeat="category in courses.categories" ng-style="courses.spacedCategories($first)" ng-init="indexOfCategory = $index">
	                    <div class="category-title" ng-style="courses.getVerticalOffsetForCategory()">
	                        <div class="container">
	                            <span class="middler"></span><span class="middle" ng-bind="category.name" ng-class="courses.getColours(indexOfCategory)"></span>
	                        </div>
	                    </div>
	                    <div ng-repeat="tile in category.tiles" ng-style="courses.getVerticalOffset(category)">
	                        <a ng-href="/courses/{{tile.url}}">
	                        <div class="tile" ng-class="{'routePossible':(tile.url ? true : false)}">
	                            
	                            <div class="square-content" ng-class="courses.getStyle(indexOfCategory,flipped)" ng-mouseenter="flipped=true" ng-mouseleave="flipped=false">
	                                <flipper flipped="flipped" horizontal >
	                                    <front>
	                                        <div class="title noselect" ng-style="courses.getTileTitle()">
	                                            <span class="middler"></span><span class="middle noselect clickable" ng-bind="tile.title"></span>
	                                        </div>
	                                        <div class="content" ng-style="courses.getTileContent()">
	                                            <span class="middler"></span><img class="middle resp-img back-title-icon clickable" alt="{{tile.iconName}}" ng-src="imgs/courses/black/{{tile.iconName}}.png" >
	                                        </div>
	                                    </front>
	                                    <back>
	                                        <div class="back-title">
	<!--                                             <img class="resp-img back-title-icon clickable" alt="{{tile.iconName}}" ng-src="imgs/{{tile.iconName}}-{{courses.getColours(indexOfCategory)}}.png" > -->
	                                            <span class="middle noselect clickable" ng-bind="tile.title"></span>
	                                        </div>
	                                        <div class="back-content">
	                                            <span class="noselect clickable" ng-bind="tile.contentFlipped"></span>
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
<!--         </spinner-final> -->
<!-- 		</div> -->
    </div>