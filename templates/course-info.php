<div class="container">
    <div class="course-info">
        <div class="container">
        	<div class="col-100 details text-center fa fa-5x fa-info-circle"></div>
        	
			<p>I corsi a reSeed si tengono tipicamente due volte l'anno: ad <emph>aprile</emph> e <emph>settembre</emph>.</p>
        
            <div class="details">
            	<h3>Corso:</h3>
				<ul class="fa-ul">
				  <li><i class="fa-li fa fa-hourglass-half fa-lg"></i><p class="inline"><b>Durata</b>: <span ng-bind="course.courseInfo.duration"></span> ore (<span ng-bind="course.courseInfo.lessons"></span> lezioni)</p></li>
				  <li><i class="fa-li fa fa-eur fa-lg"></i><p class="inline"><b>Costo</b>: <span ng-bind="course.courseInfo.price"></span> €</p></li>
				  <li><i class="fa-li fa fa-clock-o fa-lg"></i><p class="inline"><b>Orari</b>: ogni <span ng-bind="course.courseInfo.day"></span> dalle <span ng-bind="course.courseInfo.startingHour"></span> alle <span ng-bind="course.courseInfo.endingHour"></span></p></li>
<!-- 				  <li><i class="fa-li fa fa-pie-chart"></i><b>Numero lezioni</b>: <span ng-bind="course.courseInfo.lessons"></span></li> -->
				  <li><i class="fa-li fa fa-calendar-o fa-lg"></i><p class="inline"><b>Data di inizio e fine</b>:
					  <span ng-if="course.courseHasStarted">
			            <span>Il corso è partito </span>
						<emph class="text-danger"><time title="precisamente: il {{course.courseInfo.startingDate | amCalendar}}" am-time-ago="course.courseInfo.startingDate"></time></emph>
					  </span>
					  <span ng-if="!course.courseHasStarted">
					  	<span ng-bind="course.courseInfo.startingDateText"></span> -
					  	<span ng-bind="course.courseInfo.endingDateText"></span>.
					  </span>
					</p></li>
				</ul>
				<div ng-show="course.hasSimulation">
					<h3>Simulazione:</h3>
					<ul class="fa-ul">
					  <li><i class="fa-li fa fa-hourglass-half fa-lg"></i><p class="inline"><b>Durata</b>: <span ng-bind="course.courseInfo.simulationDuration"></span> ore (<span ng-bind="course.courseInfo.simulationLessons"></span> lezioni)</p></li>
					  <li><i class="fa-li fa fa-eur fa-lg"></i><p class="inline"><b>Costo</b>: <span ng-bind="course.courseInfo.simulationPrice"></span> €</p></li>
					  <li><i class="fa-li fa fa-clock-o fa-lg"></i><p class="inline"><b>Orari</b>: ogni <span ng-bind="course.courseInfo.simulationDay"></span> dalle <span ng-bind="course.courseInfo.simulationStartingHour"></span> alle <span ng-bind="course.courseInfo.simulationEndingHour"></span></p></li>
<!-- 					  <li><i class="fa-li fa fa-pie-chart"></i><b>Numero lezioni</b>: <span ng-bind="course.courseInfo.simulation.lessons"></span></li> -->
					  <li><i class="fa-li fa fa-calendar-o fa-lg"></i><p class="inline"><b>Data di inizio e fine</b>:
						  <span ng-if="course.simulationHasStarted">
				            <span>La simulazione è partita </span>
							<emph class="text-danger"><time title="precisamente: il {{course.courseInfo.simulationStartingDate | amCalendar}}" am-time-ago="course.courseInfo.simulationStartingDate"></time></emph>
						  </span>
						  <span ng-if="!course.simulationHasStarted">
						  	<span ng-bind="course.courseInfo.simulationStartingDateText"></span> -
						  	<span ng-bind="course.courseInfo.simulationEndingDateText"></span>.
						  </span>
						</p></li>
					</ul>
				</div>
				<div ng-show="!course.hasSimulation"><p><strong>Nota:</strong> Questo corso non prevede simulazione.</p></div>
            </div>
            
            
            <div>
				<div>
					<span ng-if="course.courseHasStarted && course.next">La prossima iterazione di questo corso corso ci sarà
						<emph><time title="precisamente: il {{course.next.startingDate | amCalendar}}" am-time-ago="course.next.startingDate"></time></emph>.
						<span><a href="/courses/{{course.next.courseID}}">Clicca qui</a> per vedere i dettagli del nuovo corso!</span>
					</span>
				</div>
				
<!-- 				<div>	 -->
<!-- 					<span ng-if="!course.courseHasStarted && course.firstLesson">La prima lezione si terrà  -->
<!-- 						<emph><time ng-bind="course.firstLesson"></time></emph> -->
<!-- 					</span> -->
<!-- 					<span ng-if="!course.courseHasStarted && !course.firstLesson">La data della prima lezione non è stata ancora decisa.</span> -->
<!-- 				</div> -->
            </div>
        </div>
    </div>
</div>