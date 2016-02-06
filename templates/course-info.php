<div class="container">
    <div class="course-info">
        <div class="container">
        	<div class="col-100 details text-center fa fa-5x fa-info-circle"></div>
        	
			<div>I corsi a reSeed si tengono tipicamente due volte l'anno: ad <emph>aprile</emph> e <emph>settembre</emph>.</div>
        
            <div class="details">
				<ul class="fa-ul">
				  <li><i class="fa-li fa fa-hourglass-half"></i><b>Durata</b>: <span ng-bind="course.courseInfo.duration"></span> ore</li>
				  <li><i class="fa-li fa fa-eur"></i><b>Costo</b>: <span ng-bind="course.courseInfo.price"></span> €</li>
				  <li><i class="fa-li fa fa-book"></i><b>Quando</b>: ogni <span ng-bind="course.courseInfo.day"></span> dalle <span ng-bind="course.courseInfo.startingHour"></span> alle <span ng-bind="course.courseInfo.endingHour"></span></li>
				  <li><i class="fa-li fa fa-pie-chart"></i><b>Numero lezioni</b>: <span ng-bind="course.courseInfo.lessons"></span></li>
				  <li><i class="fa-li fa fa-calendar-o"></i><b>Inizio corso</b>:
					  <span ng-if="course.courseHasStarted">
			            <span>Il corso è partito </span>
						<emph class="text-danger"><time title="precisamente: il {{course.courseInfo.startingDate | amCalendar}}" am-time-ago="course.courseInfo.startingDate"></time></emph>.
					  </span>
					  <span ng-if="!course.courseHasStarted">
					  	<span ng-bind="course.courseInfo.startingDateText"></span>
					  </span>
					</li>
				</ul>
            </div>
            
            
            <div>
				<div>
					<span ng-if="course.courseHasStarted && course.next">La prossima iterazione di questo corso corso ci sarà
						<emph><time title="precisamente: il {{course.next.startingDate | amCalendar}}" am-time-ago="course.next.startingDate"></time></emph>.
						<span><a href="#!/courses/{{course.next.courseID}}">Clicca qui</a> per vedere i dettagli del nuovo corso!</span>
					</span>
				</div>
				
				<div>	
					<span ng-if="!course.courseHasStarted && course.firstLesson">La prima lezione si terrà 
						<emph><time ng-bind="course.firstLesson"></time></emph>
					</span>
					<span ng-if="!course.courseHasStarted && !course.firstLesson">La data della prima lezione non è stata ancora decisa.</span>
				</div>
            </div>
        </div>
    </div>
</div>