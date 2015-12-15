<p centered>
	<span><span ng-bind="course.courseDescription.duration"></span> ore, </span>
	<span><emph><span ng-bind="course.hourPrice"></span> €</emph> l'ora.</span>
	<span>Il corso </span>
	<span ng-if="course.courseHasStarted">è partito </span>
	<span ng-if="!course.courseHasStarted">partirà </span>
	<emph><time title="precisamente: il {{course.courseDescription.startingDate | amCalendar}}" am-time-ago="course.courseDescription.startingDate"></time></emph>
	<span>.</span>
	<span ng-if="!course.courseHasStarted && course.firstLesson">La prima lezione si terrà 
		<emph><time ng-bind="course.firstLesson"></time></emph>
	</span>
	<span ng-if="!course.courseHasStarted && !course.firstLesson">La data della prima lezione non è stata ancora decisa.</span>
</p>