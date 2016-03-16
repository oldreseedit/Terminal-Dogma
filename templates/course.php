<div id="singleCourse">

	<div class="pay-button clickable" ng-if="!course.presubscribed && !course.subscribed && !course.isInCart() && !imOnResponsive" ng-click="course.addCourse()">
		<img src="imgs/iscriviti.png">
	</div>
	
	<div class="faq-button clickable" ng-if="!imOnResponsive">
		<a href="/faq">
			<img src="imgs/faq.png">
		</a>
	</div>
	
<!-- 	<div class="faq-button clickable"> -->
<!-- 			<span class="fa-stack fa-5x"> -->
<!-- 			  <i class="fa fa-circle fa-stack-2x green"></i> -->
<!-- 			  <a href="/faq"> -->
<!-- 			  <i class="fa fa-stack-1x">FAQ</i> -->
<!-- 			  </a> -->
<!-- 			</span> -->
<!-- 	</div> -->
	
	<!-- Devo mostrare il bottone per iscriversi alla simulazione se:
	i) il corso ha la simulazione &&
	ii) ho già pagato il corso soltanto
	 -->
	<div class="pay-button clickable" ng-if="course.hasSimulation && course.subscribed && !course.subscribedToSimulation && !course.isInCart() && !imOnResponsive" ng-click="course.addSimulation()">
		<img src="imgs/iscriviti-simulazione.png">
	</div>
	
<!-- 	<div class="buttons" ng-if="imOnResponsive"> -->
<!-- 		<div class="course-faq"> -->
<!-- 			<a href="/faq"> -->
<!-- 				<i class="fa fa-stack"><i class="fa fa-square fa-stack-2x water"></i><i class="fa fa-question fa-stack-1x white"></i></i> -->
<!-- 							<i class="fa fa-question-circle water middle"></i> -->
<!-- 				<span class="middler"></span><h4 class="inline middle">Domande frequenti</h4> -->
<!-- 			</a> -->
<!-- 		</div> -->
<!-- 		<div class="course-subscribe" ng-if="!course.isInCart() && (!course.subscribed || (course.hasSimulation && !course.subscribedToSimulation))"> -->
<!-- 			<a ng-click="( course.hasSimulation && course.subscribed && !course.subscribedToSimulation ) ? course.addSimulation() : course.addCourse()"> -->
<!-- 				<span class="middler"></span><h4 class="inline middle" ng-bind="( course.hasSimulation && course.subscribed && !course.subscribedToSimulation ) ? 'Aggiungi la simulazione' : (!course.subscribed ? 'Iscriviti al corso' : '')"></h4> -->
<!-- 				<i class="fa fa-stack"><i class="fa fa-square fa-stack-2x water"></i><i class="fa fa-shopping-cart fa-stack-1x white"></i></i>			 -->
<!-- 			</a> -->
<!-- 		</div> -->
<!-- 	</div> -->
	
	<generic-bookmark bookmark-if="imOnResponsive && course.hasSimulation && course.subscribed && !course.subscribedToSimulation && !course.isInCart()" bookmark-action="course.addSimulation">
		<span class="middler"></span><i class="fa fa-2x fa-shopping-cart white middle"></i><span class="button-title">Iscriviti alla simulazione!</span>
	</generic-bookmark>
	<generic-bookmark bookmark-if="imOnResponsive && !course.presubscribed && !course.subscribed && !course.isInCart()" bookmark-action="course.addCourse">
		<span class="middler"></span><i class="fa fa-2x fa-shopping-cart white middle"></i><span class="button-title">Iscriviti al corso!</span>
	</generic-bookmark>
    
    <div class="no-items">
		<div  ng-repeat="item in course.items" ng-init="index = $index" ng-if="item.visible">
			<div class="clearfix" ng-if="course.isNewRow(index) && !imOnResponsive"></div>
	        <div class="no-gridster-item" equal-height="course.getAdjacent(item.id)" equal-height-wait-for="allReady" id="{{item.id}}" ng-class="course.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
<!-- 	        	<div ng-if="item.id === 'courseBanner'" class="container banner bg-dark-water text-center" > -->
<!-- 					<div ng-include="item.templateUrl"></div> -->
<!-- 				</div> -->
	            <div class="container" ng-if="item.id !== 'courseBanner'">
	            	<div class="panel-title bg-lawn">
	                	<h4 ng-bind="item.title"></h4>
					</div>
	                <div class="scrollbar-wrapper" ng-if="item.templateUrl">
	                	<div class="scrollbar">
			        		<div class="panel-content">
			                	<div class="container">
		                        	<div ng-include="item.templateUrl"></div>
			       				</div>
			                </div>
						</div>
					</div>
				</div>
			</div>
			<generic-bookmark class="float" bookmark-if="imOnResponsive && item.id === 'courseInfo'" bookmark-href="/faq" style="margin-bottom:1em">
				<span class="middler"></span><i class="fa fa-2x fa-question white middle"></i><span class="button-title">Domande frequenti</span>
			</generic-bookmark>
        </div>
    </div>
</div>