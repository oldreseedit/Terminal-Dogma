<h5 class="black">
	<span><span ng-bind="course.courseDescription.duration"></span> ore, 
	<emph><span ng-bind="course.hourPrice"></span> €</emph> l'ora. Il corso </span>
	<span ng-if="course.courseHasStarted">è partito </span><span ng-if="!course.courseHasStarted">partirà </span>
	<emph><time title="precisamente: il {{course.courseDescription.startingDate | amCalendar}}" am-time-ago="course.courseDescription.startingDate"></time></emph>.
		
	<span ng-if="!course.courseHasStarted && course.firstLesson">La prima lezione si terrà 
		<emph><time ng-bind="course.firstLesson"></time></emph>
	</span>
	<span ng-if="!course.courseHasStarted && !course.firstLesson">La data della prima lezione non è stata ancora decisa.</span>
	
	<span ng-if="course.courseHasStarted && course.next">La prossima iterazione del corso ci sarà
		<emph><time title="precisamente: il {{course.next.startingDate | amCalendar}}" am-time-ago="course.next.startingDate"></time></emph>.
	</span>
</h5>
<h5 class="black">
	<span>Attualmente (e solo temporaneamente) è impossibile iscriversi ad un nuovo corso. Risolveremo appena possibile!</span>
</h5>