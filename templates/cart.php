<div id="cart">

<div class="container">
        <div class="no-gridster-item bg-light-grey">
        	<div class="container">
            	<div class="panel-title bg-lawn">
                	<h4>I corsi da te inseriti nel carrello</h4>
				</div>
                <div class="scrollbar-wrapper">
	        		<div class="panel-content">
	                	<div class="container">
	                		<div ng-if="cart.getCart().items.length == 0">Non ci sono corsi nel tuo carrello.</div>
		                	
		                	<div ng-if="cart.getCart().items.length > 0">
			                	<table class="table table-striped text-center">
									<tr ng-repeat="item in cart.getCart().items">
										<td align="left">
											<div>
											<span spinner="cart.coursesAjax" ><spinner-final><img ng-src="imgs/courses/black/{{cart.getCourseIcon(item)}}.png" class="cart-course-icon"></spinner-final><spinner-place class="fa-3x"></spinner-place></span>
											<p class="inline"><strong>Corso</strong>: <span ng-bind="item.courseName"></span></p>
<!-- 											<span class="cart-item-price"><span ng-bind="item.price"></span> €</span> -->
											</div>
											<div>
												<input type="checkbox" ng-if="!item.courseAlreadyPaid" ng-checked="item.payCourse" ng-disabled="item.courseAlreadyPaid" ng-click="cart.toggleCourse(item)">
												<p class="inline"><span class="cart-subitem">Corso<span ng-if="item.courseAlreadyPaid">: hai già acquistato il corso.</span></span></p>
												<p class="inline"><span class="cart-item-price" ng-class="{'price-cancelled': !item.payCourse}"><span ng-bind="item.price"></span> €</span></p>
											</div>
											<div ng-if="item.simulation">
												<input type="checkbox" ng-checked="item.paySimulation" ng-click="cart.toggleSimulation(item)">
												<p class="inline"><span class="cart-subitem">Simulazione</span></p>
												<p class="inline"><span class="cart-item-price" ng-class="{'price-cancelled': !item.paySimulation}"><span ng-bind="item.simulationPrice"></span> €</span></p>
											</div>
											<div ng-if="!item.simulation">
												<p class="inline"><span class="cart-subitem">Questo corso non prevede simulazione.</span></p>
											</div>
										</td>
										<td width="30px;">
											<p class="inline"><span title="Rimuovi questo articolo dal carrello" class="fa fa-2x fa-times-circle text-danger clickable" ng-click="cart.remove(item)"></span></p>
										</td>
									</tr>
								</table>
	
								<div class="choice-text">
									<p class="inline"><strong>Seedon: </strong></p>
									<input style="width:30%; display: inline-block; margin: 0 0 0 0;}" type="text" ng-model="cart.paymentOptions.customSeedon.seedon"/>
									<button class="btn btn-success pay-button" style="float: none; vertical-align: bottom; margin-left: 0.5em;" ng-disabled="!cart.paymentOptions.customSeedon.seedon" ng-click="cart.applyCustomSeedon(cart.paymentOptions.customSeedon)">Applica seedon</button>
									<p ng-if="cart.paymentOptions.customSeedon.description.length > 0" ng-bind="cart.paymentOptions.customSeedon.description"></p>
								</div>
	
								<div class="choice-text" ng-if="cart.paymentOptions.seedon.length > 1">
									<p class="inline"><strong>Seedon: </strong></p>
									<select ng-model="cart.getCart().options.seedOnChosen" ng-touch="cart.applySeedon(cart.getCart().options.seedOnChosen)">
										<option ng-repeat="seedon in cart.paymentOptions.seedon" value="{{seedon.seedonID}}" title="{{seedon.description}}">{{seedon.longDescription}}</option>
									</select>
								</div>
								
								<div class="choice-text">
									<p class="inline"><strong>Modalità di pagamento: </strong></p>
									<select ng-model="cart.getCart().options.paymentMediaChosen" ng-touch="cart.applyPaymentMedia()">
										<option ng-repeat="option in cart.paymentOptions.paymentMediaOptions" value="{{option.value}}" title="{{option.description}}">{{option.label}}</option>
									</select>
								</div>
								
								<div class="choice-text">
									<p class="inline"><strong>Rateizzazione: </strong></p>
									<select ng-model="cart.getCart().options.paymentCycleChosen" ng-touch="cart.applyPaymentCycle()">
										<option ng-repeat="option in cart.paymentOptions.paymentCycleOptions" value="{{option.value}}" title="{{option.description}}">{{option.label}}</option>
									</select>
								</div>
	
								<div title="Questo è il totale calcolato prima di applicare qualunque tipo di sconto." class="cart-total" ng-class="{'price-cancelled': cart.getCart().options.discount > 0 || cart.getCart().options.seedonDiscount > 0}">
									<p class="inline"><strong>Totale: </strong>
									<strong><span ng-bind="cart.getTotalPrice()"></span> €</strong></p>
								</div>
								
								<div title="Hai questo sconto a vita perché sei cliente di reSeed e hai contribuito alla sua crescita." class="cart-total strong leaf">
									<p class="inline"><strong>Sconto lifetime ottenuto grazie al tuo livello: </strong>
									<strong><span ng-bind="{{100*cart.getCart().options.discount}}"></span> % ({{cart.getTotalPrice()*cart.getCart().options.discount}} €)</strong></p>
								</div>
								
								<div title="Attento: questo sconto può essere usato solo una volta." class="cart-total strong leaf" ng-if="cart.getCart().options.seedonDiscount">
									<p class="inline"><strong>Sconto applicato in base al seedon scelto: </strong>
									<strong><span>{{100*cart.getCart().options.seedonDiscount}} %</span> ({{cart.getTotalPrice()*cart.getCart().options.seedonDiscount}} €)</strong></p>
								</div>
								
								<div title="Questo è il totale vero, calcolato dopo l'applicazione dei vari sconti." class="cart-total cart-grand-total">
									<p class="inline"><strong>Totale: </strong>
									<strong><span ng-bind="cart.getFinalPrice()"></span> €</strong>
									<span ng-if="cart.getCart().options.paymentCycleChosen === 'monthly'">/mese, per 3 mesi</span></p>
								</div>
								
								<div class="cart-buttons">
									<button class="btn btn-danger empty-button" ng-disabled="cart.getCart().items.length <= 0" ng-click="cart.emptyCart()">Svuota il carrello</button>
									<button class="btn btn-success pay-button" ng-disabled="cart.getCoursesToPay() <= 0 || cart.getCart().options.paymentCycleChosen == '' || cart.getCart().options.paymentMediaChosen == ''" ng-click="cart.prepay()">Rivedi e paga</button>
								</div>
							</div>
							
	       				</div>
	                </div>
				</div>
			</div>
        </div>
</div>

</div>