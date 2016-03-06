<div id="singleCourse">

	<div class="pay-button clickable" ng-if="!course.presubscribed && !course.subscribed && !course.isInCart()" ng-click="course.addCourse()">
		<img src="imgs/iscriviti.png">
	</div>
	
	<div class="faq-button clickable">
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
	<div class="pay-button clickable" ng-if="course.hasSimulation && course.subscribed && !course.subscribedToSimulation && !course.isInCart()" ng-click="course.addSimulation()">
		<img src="imgs/iscriviti-simulazione.png">
	</div>
	
    <div class="container">
		<div  ng-repeat="item in course.items" ng-init="index = $index" ng-if="item.visible">
			<div class="clearfix" ng-if="course.isNewRow(index)"></div>
	        <div class="no-gridster-item bg-light-grey" equal-height="course.getAdjacent(item.id)" id="{{item.id}}" ng-class="course.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
<!-- 	        	<div ng-if="item.id === 'courseBanner'" class="container banner bg-dark-water text-center" > -->
<!-- 					<div ng-include="item.templateUrl"></div> -->
<!-- 				</div> -->
	            <div class="container" ng-if="item.id !== 'courseBanner'">
	            	<div class="panel-title bg-lawn">
	                	<h4 ng-bind="item.title"></h4>
					</div>
	                <div class="scrollbar-wrapper">
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
        </div>
    </div>
</div>