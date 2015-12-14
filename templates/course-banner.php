<p centered>
	<span>{{course.courseDescription.duration}} ore, </span>
	<span><emph>{{Math.round(100 * course.courseDescription.price/course.courseDescription.duration)/100}} €</emph> l'ora.</span>
	<span ng-if="course.courseHasStarted"> Il corso <emph>non</emph> è ancora partito.</span>
	<span ng-if="!course.courseHasStarted"> Il corso è iniziato </span>
	<span am-time-ago="course.courseDescription.startingDate"></span>
</p>